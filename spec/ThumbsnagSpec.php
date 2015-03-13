<?php namespace spec\Thumbsnag;

require_once __DIR__ . '/../stub/DOMDocumentStub.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thumbsnag\ImageSizeAnalyzer;
use Thumbsnag\Stub\DOMDocumentStub;

class ThumbsnagSpec extends ObjectBehavior
{

    public function let()
    {
        $document = DOMDocumentStub::getDocument();
        $analyzer = new StubFileSizeAnalyzer();
        $baseUrl = "http://simplegifts.co";

        $this->beConstructedThrough('load', [$document, $analyzer, $baseUrl]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Thumbsnag\Thumbsnag');
    }

    public function it_returns_an_array_of_representative_images()
    {
        $this->process()->shouldBeArray();
        $this->process()->shouldHaveCount(5);
    }
}

class StubFileSizeAnalyzer implements ImageSizeAnalyzer
{

    private $filePath;

    /**
     * Load URL
     *
     * @param $url
     */
    public function load($url)
    {
        $this->filePath = __DIR__ . '/../stub/img/' . basename($url);
    }

    /**
     * Get image size
     *
     * @return array
     */
    public function getSize()
    {
        $imageSize = getimagesize($this->filePath);

        return [$imageSize[0], $imageSize[1]];
    }
}
