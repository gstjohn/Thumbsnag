<?php namespace Thumbsnag;

interface ImageSizeAnalyzer {

    /**
     * Get the sizes of a given array of image urls
     *
     * @param array $urls
     *
     * @return mixed
     */
    public function batch(array $urls);
}
