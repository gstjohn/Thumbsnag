<?php namespace Thumbsnag;

class FastImageAnalyzer implements ImageSizeAnalyzer
{
    /**
     * @var \Fastimage
     */
    private $fastImage;

    /**
     * @var \FastImage
     */
    private $analyzer;

    public function __construct(\FastImage $fastimage)
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
        $this->analyzer = new $this->fastImage;
        $this->analyzer->load($url);
    }

    /**
     * Get image size
     *
     * @return array
     * @throws \Exception
     */
    public function getSize()
    {
        $result = $this->analyzer->getSize();

        if (!is_array($result)) {
//            die('<pre>'.print_r($this->analyzer, true).'</pre>');
            throw new \Exception('Unable to get image size.');
        }

        return $result;
    }
}
