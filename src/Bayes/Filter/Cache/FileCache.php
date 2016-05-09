<?php

namespace Hum2\Bayes\Filter\Tokenizer;

use Psr\Cache\CacheItemInterface;

class FileCache implements CacheItemInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $expired = null;

    /**
     * FileCache constructor.
     *
     * @param string $path
     */
    public function __construct($path = '/tmp/')
    {
        $this->path = $path;
    }

    public function getKey()
    {
        return md5(get_class());
    }

    public function get()
    {
        if ($this->isHit()) {
            return null;
        }

        $data = unserialize(file_get_contents($this->path . $this->getKey()));
        if ($data['expired'] != null && (new \DateTime())->getTimestamp() > $data['expired']) {
            return null;
        }
        unset($data['expired']);

        return $data;
    }

    public function isHit()
    {
        return file_exists($this->path . $this->getKey());
    }

    public function set($value)
    {
        $value['expired'] = $this->expired;
        file_put_contents($this->path . $this->getKey(), serialize($value), LOCK_EX);
    }

    public function expiresAt($expiration)
    {
        $this->expired = $expiration->getTimestamp();
    }

    public function expiresAfter($time)
    {
        $this->expired = (new \Datetime)->getTimestamp() + $time;
    }

}