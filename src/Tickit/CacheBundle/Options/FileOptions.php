<?php

namespace Tickit\CacheBundle\Options;

use Tickit\CacheBundle\Options\Exception\InvalidOptionException;

/**
 * Options resolver class for the File caching engine
 *
 * @author James Halsall <james.t.halsall@googlemail.com>
 */
class FileOptions extends AbstractOptions
{
    /**
     * The cache directory
     *
     * @var string $cacheDir
     */
    protected $cacheDir;

    /**
     * Boolean value indicating whether data should be automatically
     * serialized before caching
     *
     * @var bool $autoSerialize
     */
    protected $autoSerialize;

    /**
     * Sets the desired path to the cache file directory
     *
     * @param string $path The full working path to the cache directory
     *
     * @throws \Tickit\CacheBundle\Options\Exception\InvalidOptionException
     */
    public function setCacheDir($path)
    {
        if (!is_writable($path)) {
            throw new InvalidOptionException();
        }

        $this->cacheDir = $path;
    }


    /**
     * Returns true if the current options requires that serialization
     * of data should be automatic, false otherwise
     *
     * @return bool
     */
    public function getAutoSerialize()
    {
        return $this->autoSerialize;
    }


    /**
     * Gets the cache directory option
     *
     * @return string
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * Overrides abstract implementation and sets up engine specific options
     */
    protected function _resolveOptions()
    {
        $cacheDir = $this->getRawOption('cache_dir', '');

        try {
            $this->setCacheDir($cacheDir);
        } catch (InvalidOptionException $e) {
            $defaultCacheDir = $this->container->getParameter('tickit_cache.file.default_path');
            $this->setCacheDir($defaultCacheDir);
        }

        $autoSerialize = $this->getRawOption('auto_serialize', null);
        if (is_bool($autoSerialize)) {
            $this->autoSerialize = $autoSerialize;
        } else {
            $this->autoSerialize = $this->container->getParameter('tickit_cache.file.auto_serialize');
        }

        parent::_resolveOptions();
    }

}