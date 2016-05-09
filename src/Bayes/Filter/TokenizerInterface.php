<?php

/**
 * @author Shuhei Suzuki <hum2.dmg@gmail.com>
 */

namespace Hum2\Bayes\Filter;

interface TokenizerInterface
{
    /**
     * @param string $text
     * @return mixed
     */
    public function tokenize($text);
}