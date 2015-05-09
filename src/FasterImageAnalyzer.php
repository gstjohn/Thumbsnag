<?php namespace Thumbsnag;

class FasterImageAnalyzer implements ImageSizeAnalyzer
{
    /**
     * @var \FasterImage\FasterImage
     */
    private $fasterImage;


    public function __construct(\FasterImage\FasterImage $fasterimage)
    {
        $this->fasterImage = $fasterimage;
    }

    /**
     * Get the sizes of a given array of image urls
     *
     * @param array $urls
     *
     * @return mixed
     */
    public function batch(array $urls)
    {
        return $this->fasterImage->batch($urls);
    }
}
