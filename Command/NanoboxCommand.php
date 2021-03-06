<?php

namespace Orkestra\Bundles\SetupBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NanoboxCommand extends SetupCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('nanobox')
            ->setDescription('Setup a Nanobox environment for your project.')
            ->addComposerPackage('doctrine/doctrine-migrations-bundle')
            ->markAllForCopy();
    }

    /**
     * {@inheritdoc}
     */
    protected function preExecute(InputInterface $input, OutputInterface $output)
    {
    }
}