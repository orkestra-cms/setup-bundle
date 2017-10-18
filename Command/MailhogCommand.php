<?php

namespace Orkestra\Bundles\SetupBundle\Command;

class MailhogCommand extends SetupCommand
{
    protected function configure()
    {
        $this->setName('mailhog')
            ->setDescription('')
            ->markForCopy('app/config/merges/mailhog.yml')
            ->markForCopy('nanobox/nginx.mailhog.conf');
    }
}