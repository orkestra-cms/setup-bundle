<?php

namespace Orkestra\Bundles\SetupBundle\Command;

class NanoboxCommand extends SetupCommand
{
    protected function configure()
    {
        $this
            ->setName('nanobox')
            ->setDescription('')
            ->markAllForCopy();
    }
}