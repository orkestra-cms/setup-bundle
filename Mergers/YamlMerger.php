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
        if ($this->copy($source, $destination, $markedForCopy)) return $this;
        $parser = new Parser();
        $dumper = new Dumper();
        $left = $parser->parse(file_get_contents($destination));
        $right = $parser->parse(file_get_contents($source));
        $final = $this->mergeYaml($left, $right);
        file_put_contents($destination, $dumper->dump($final, 10));
        return $this;
    }

    private function mergeYaml(&$left, &$right) {
        foreach($right as $key => $value) {
            if (!is_array($value)) {
                $left[$key] = $right[$key];
            } else {
                $left[$key] = $this->mergeYaml($left[$key], $right[$key]);
            }
        }
        return $left;
    }
}