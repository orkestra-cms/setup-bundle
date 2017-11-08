<?php

namespace Orkestra\Bundles\SetupBundle\Mergers;

use Orkestra\Bundles\SetupBundle\Mergers\Traits\CopyTrait;

class LineMerger implements MergerInterface
{
    use CopyTrait;

    /**
     * @var string
     */
    private $comment;

    /**
     * @inheritDoc
     */
    public function merge(string $source, string $destination, bool $markedForCopy): MergerInterface
    {
        if (!$markedForCopy) return $this;
        if ($this->copy($source, $destination, $markedForCopy)) return $this;
        $left = file($destination);
        $right = file($source);

        if (!empty($this->comment)) {
            $final = array_merge($left, ['', $this->comment], $right);
        } else {
            $final = array_merge($left, $right);
        }
        array_walk($final, function(&$item) {
            $item = trim($item);
        });
        $final = implode("\n", $final);
        file_put_contents($destination, $final);
        return $this;
    }

    /**
     * @param string $comment
     * @return LineMerger
     */
    public function setComment(string $comment): LineMerger
    {
        $this->comment = sprintf('# %s', $comment);
        return $this;
    }
}