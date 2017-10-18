<?php

namespace Orkestra\Bundles\SetupBundle\Mergers\Traits;

trait CopyTrait
{
    /**
     * Convenience method for mergers. If a file can simply be copied this method does the copying
     * and returns TRUE.
     *
     * @param string $source
     * @param string $destination
     * @param bool $markedForCopy
     * @return bool
     * @throws \Exception
     */
    public function copy(string $source, string $destination, bool $markedForCopy): bool
    {
        if (file_exists($destination)) return false;
        if (!$markedForCopy) return false;
        $directory = dirname($destination);
        if (!is_dir($directory)) {
            $ret = @mkdir($directory, 0755, true);
            if (!$ret) {
                throw new \Exception(sprintf('The directory %s could not be copied.', $directory));
            }
        }
        $ret = copy($source, $destination);
        if (!$ret) {
            throw new \Exception(sprintf('The file %s could not be copied.', basename($destination)));
        }
        return true;
    }
}