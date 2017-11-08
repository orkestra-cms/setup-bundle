<?php

namespace Orkestra\Bundles\SetupBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SessionCommand extends SetupCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('session')
            ->setDescription('Configures Symfony to use Namespaced sessions.')
            ->markForCopy('app/config/merges/session.yml');
    }

    /**
     * {@inheritdoc}
     */
    protected function preExecute(InputInterface $input, OutputInterface $output)
    {
    }
}
