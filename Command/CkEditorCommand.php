<?php

namespace Orkestra\Bundles\SetupBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CkEditorCommand extends SetupCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ckeditor')
            ->setDescription('Installs the CKEditor bundle and some a toolbar configuration.')
            ->addComposerPackage('egeloen/ckeditor-bundle')
            ->markForCopy('app/config/merges/ckeditor.yml');
    }

    /**
     * {@inheritdoc}
     */
    protected function preExecute(InputInterface $input, OutputInterface $output)
    {
    }
}
