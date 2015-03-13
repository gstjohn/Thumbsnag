<?php namespace Thumbsnag;

class FastImageAnalyzer implements ImageSizeAnalyzer
{
    /**
     * @var \Fastimage
     */
    private $fastImage;

    public function __construct(\Fastimage $fastimage)
    {
        $this->fastImage = $fastimage;
    }

    /**
     * Load URL
     *
     * @param $url
     */
    public function load($url)
    {
        $this->fastImage->load($url);
    }

    /**
     * Get image size
     *
     * @return array
     * @throws \Exception
     */
    public function getSize()
    {
        $result = $this->fastImage->getSize();

        if ($result === false) {
            throw new \Exception('Unable to get image size.');
        }
    }
}