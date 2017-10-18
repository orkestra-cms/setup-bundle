<?php

namespace Orkestra\Bundles\SetupBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
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
            ->setDescription('TODO')
            ->requirePackage('egeloen/ckeditor-bundle')
            ->markForCopy('app/config/merges/ckeditor.yml');
    }
}
