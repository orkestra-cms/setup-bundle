<?php

namespace Orkestra\Bundles\SetupBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MemcachedCommand extends SetupCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('memcached')
            ->setDescription('Configures Symfony to use memcached for session handling and Doctrine caching.')
            ->markForCopy('app/config/merges/memcached.yml');
    }

    /**
     * {@inheritdoc}
     */
    protected function preExecute(InputInterface $input, OutputInterface $output)
    {
    }
}