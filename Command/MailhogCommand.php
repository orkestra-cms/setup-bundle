<?php

namespace Orkestra\Bundles\SetupBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MailhogCommand extends SetupCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('mailhog')
            ->setDescription('Installs MailHog and required configuration files.')
            ->markAllForCopy();
    }

    /**
     * {@inheritdoc}
     */
    protected function preExecute(InputInterface $input, OutputInterface $output)
    {
    }
}