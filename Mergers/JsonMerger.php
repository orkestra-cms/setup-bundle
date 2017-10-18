<?php

namespace Orkestra\Bundles\SetupBundle\Mergers;

use Orkestra\Bundles\SetupBundle\Mergers\Traits\CopyTrait;

class JsonMerger implements MergerInterface
{
    use CopyTrait;

    /**
     * @inheritDoc
     */
    public function merge(string $source, string $destination, bool $markedForCopy): MergerInterface
    {
        if ($this->copy($source, $destination, $markedForCopy)) return $this;
        $left = json_decode(file_get_contents($destination), true);
        $right = json_decode(file_get_contents($source), true);
        $final = $this->mergeJson($left, $right);
        file_put_contents($destination, json_encode($final, JSON_PRETTY_PRINT));
        return $this;
    }

    private function mergeJson(&$left, &$right) {
        foreach($right as $key => $value) {
            if (!is_array($value)) {
                $left[$key] = $right[$key];
            } else {
                $left[$key] = $this->mergeJson($left[$key], $right[$key]);
            }
        }
        return $left;
    }
}