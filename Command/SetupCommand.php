<?php

namespace Orkestra\Bundles\SetupBundle\Command;

use Orkestra\Bundles\SetupBundle\Mergers\Traits\CopyTrait;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

abstract class SetupCommand extends ContainerAwareCommand
{
    use CopyTrait;

    /**
     * @var bool
     */
    private $markAllForCopy = false;
    /**
     * @var string[]
     */
    private $markedForCopy = [];
    /**
     * @var string
     */
    private $mergeName;
    /**
     * @var string[]
     */
    private $requiredPackages = [];

    final public function setName($name)
    {
        $ret = preg_match('/^[a-z-_]+$/', $name);
        if ($ret !== 1) {
            throw new LogicException('Your command name can only contain lowercase letters, underscores and dashes.');
        }
        $this->mergeName = $name;
        return parent::setName(sprintf('setup:%s', $name)); // TODO: Change the autogenerated stub
    }

    /**
     * @param string $relativePath
     * @return bool
     */
    final private function isMarkedForCopy(string $relativePath)
    {
        return $this->markAllForCopy ? true : array_key_exists($relativePath, $this->markedForCopy);
    }

    /**
     * By default when a file doesn't exist in the destination project it will simply be ignored.
     * This method allows a command to force all files to be copied when they don't exist.
     *
     * @return $this
     */
    final protected function markAllForCopy()
    {
        $this->markAllForCopy = true;
        return $this;
    }

    /**
     * By default when a file doesn't exist in the destination project it will simply be ignored.
     * This method allows a command to force it to be copied when it doesn't exist.
     *
     * @param string $relativePath
     * @return $this
     */
    final protected function markForCopy(string $relativePath)
    {
        $this->markedForCopy[$relativePath] = true;
        return $this;
    }

    /**
     * Installs a Composer package when executing the command.
     *
     * @param string $package
     * @return $this
     */
    final protected function requirePackage(string $package)
    {
        $this->requiredPackages[$package] = true;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    final protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kernel = $this->getContainer()->get('kernel');
        $projectDir = $this->getContainer()->getParameter('kernel.project_dir');
        $sourcePath = $kernel->locateResource(
            sprintf('@OrkestraSetupBundle/Resources/merges/%s', $this->mergeName)
        );
        if (!is_dir($sourcePath)) {
            throw new LogicException('No files found for the "%s" merge.', $this->mergeName);
        }
        // Process all merge files
        $finder = new Finder();
        $finder->files()->ignoreDotFiles(false)->in($sourcePath);
        foreach($finder as $file) {
            $relativePath = str_replace('\\', '/', $file->getRelativePathname());
            $source = $file->getPathname();
            $destination = sprintf('%s/%s', $projectDir, $relativePath);
            switch($file->getExtension()) {
                case 'gitignore':
                case 'nanoignore':
                    $this->getContainer()->get('orkestra.setup.merger.line')
                        ->setComment(sprintf('%s merger', $this->mergeName))
                        ->merge($source, $destination, $this->isMarkedForCopy($relativePath));
                    break;
                case 'json':
                    $this->getContainer()->get('orkestra.setup.merger.json')
                        ->merge($source, $destination, $this->isMarkedForCopy($relativePath));
                    break;
                case 'yml':
                case 'yaml':
                    $this->getContainer()->get('orkestra.setup.merger.yaml')
                        ->merge($source, $destination, $this->isMarkedForCopy($relativePath));
                    break;
                default:
                    if ($this->isMarkedForCopy($relativePath)) {
                        $this->copy($source, $destination, true);
                    } else {
                        throw new LogicException('Don\'t know what to do with ' . $relativePath);
                    }
                    break;
            }
        }
        // Install Composer packages
    }
}
