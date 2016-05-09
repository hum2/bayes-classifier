<?php

/**
 * @author Shuhei Suzuki <hum2.dmg@gmail.com>
 */

namespace Hum2\Bayes\Filter;

use Psr\Cache\CacheItemInterface;

class Classifier
{
    /**
     * @var TokenizerInterface
     */
    protected $tokenizer;

    /**
     * @var CacheItemInterface
     */
    protected $cache;

    /**
     * @var array
     */
    protected $data;

    /**
     * Classifier constructor.
     *
     * @param TokenizerInterface      $tokenizer
     * @param CacheItemInterface|null $cache
     */
    public function __construct(TokenizerInterface $tokenizer, CacheItemInterface $cache = null)
    {
        $this->tokenizer = $tokenizer;
        $this->cache     = $cache;
    }

    /**
     * @param string $label
     * @param string $token
     * @param int    $score
     */
    public function train($label, $token, $score = 1)
    {
        if (isset($this->data[$label][$token])) {
            $this->data['token'][$label][$token] += $score;
        } else {
            $this->data['token'][$label][$token] = $score;
        }

        if (isset($this->scores[$label])) {
            $this->data['score'][$label] += $score;
        } else {
            $this->data['score'][$label] = $score;
        }
    }

    public function save()
    {
        if ($this->cache) {
            $this->cache->set($this->data);
        }
    }

    public function load()
    {
        if ($this->cache) {
            $this->data = $this->cache->get();
        }
    }

    /**
     * TODO
     */
    public function predict()
    {

    }
}