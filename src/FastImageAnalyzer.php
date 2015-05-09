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
     * Get the sizes of a given array of image urls
     *
     * @param array $urls
     *
     * @return mixed
     */
    public function batch(array $urls)
    {
        $results = [];
        foreach ($urls as $url) {
            $this->load($url);
            $results[$url]['size'] = $this->getSize();
        }

        return $results;
    }

    /**
     * Get image size
     *
     * @return array
     * @throws \Exception
     */
    protected function getSize()
    {
        $result = $this->analyzer->getSize();

        if (!is_array($result)) {
//            die('<pre>'.print_r($this->analyzer, true).'</pre>');
            throw new \Exception('Unable to get image size.');
        }

        return $result;
    }

    /**
     * Load URL
     *
     * @param $url
     */
    protected function load($url)
    {
        $this->analyzer = new $this->fastImage;
        $this->analyzer->load($url);
    }
}
