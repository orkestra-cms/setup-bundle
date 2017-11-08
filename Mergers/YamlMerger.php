<?php

namespace Orkestra\Bundles\SetupBundle\Mergers;

use Orkestra\Bundles\SetupBundle\Mergers\Traits\CopyTrait;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

class YamlMerger implements MergerInterface
{
    use CopyTrait;

    /**
     * @inheritDoc
     */
    public function merge(string $source, string $destination, bool $markedForCopy): MergerInterface
    {
        if (!$markedForCopy) return $this;
        if ($this->copy($source, $destination, $markedForCopy)) return $this;
        $parser = new Parser();
        $dumper = new Dumper();
        $left = $parser->parse(file_get_contents($destination));
        $right = $parser->parse(file_get_contents($source));
        $final = array_merge_recursive($left, $right);
        file_put_contents($destination, $dumper->dump($final, 10));
        return $this;
    }
}