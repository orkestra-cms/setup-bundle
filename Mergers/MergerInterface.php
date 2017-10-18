<?php

namespace Orkestra\Bundles\SetupBundle\Mergers;

interface MergerInterface
{
    /**
     * @param string $source
     * @param string $destination
     * @param bool $markedForCopy
     * @return MergerInterface
     */
    public function merge(string $source, string $destination, bool $markedForCopy): MergerInterface;
}