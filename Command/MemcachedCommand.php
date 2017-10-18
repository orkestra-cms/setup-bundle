<?php

namespace Orkestra\Bundles\SetupBundle\Command;

class MemcachedCommand extends SetupCommand
{
    protected function configure()
    {
        $this->setName('mailhog')
            ->setDescription('')
            ->markForCopy('app/config/merges/memcached.yml')
            ->markForCopy('nanobox/nginx.mailhog.conf');
    }
}