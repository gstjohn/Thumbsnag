<?php

namespace Thumbsnag;

interface ImageSizeAnalyzer {

    /**
     * Load URL
     *
     * @param $url
     */
    public function load($url);

    /**
     * Get image size
     *
     * @return array
     */
    public function getSize();
}