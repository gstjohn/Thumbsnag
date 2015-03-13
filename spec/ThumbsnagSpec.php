<?php namespace spec\Thumbsnag;

require_once __DIR__ . '/../stub/DOMDocumentStub.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thumbsnag\ImageSizeAnalyzer;
use Thumbsnag\Stub\DOMDocumentStub;
use Thumbsnag\UrlDocument;

class ThumbsnagSpec extends ObjectBehavior
{

    public function let()
    {
        $document = UrlDocument::build(
            DOMDocumentStub::getDocument(),
            'http://simplegifts.co'
        );
        $analyzer = new StubFileSizeAnalyzer();

        $this->beConstructedThrough('load', [$document, $analyzer]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Thumbsnag\Thumbsnag');
    }

    public function it_should_remove_duplicate_images()
    {
        $domDoc = new \DOMDocument();
        $domDoc->loadHtml('<html><body><img src="img/bird.jpg" /><img src="img/bird.jpg" /></body></html>');

        $document = UrlDocument::build($domDoc, 'http://simplegifts.co');

        $analyzer = new StubFileSizeAnalyzer();

        $this->beConstructedThrough('load', [$document, $analyzer]);

        $this->process()->shouldHaveCount(1);
    }

    public function it_should_remove_filtered_file_names()
    {
        $domDoc = new \DOMDocument();
        $domDoc->loadHtml('<html><body><img src="img/spacer.gif" /><img src="img/sprite.png" /><img src="img/cat.jpg" /></body></html>');

        $document = UrlDocument::build($domDoc, 'http://simplegifts.co');

        $analyzer = new StubFileSizeAnalyzer();

        $this->beConstructedThrough('load', [$document, $analyzer]);

        $this->process()->shouldHaveCount(1);
    }

    public function it_returns_an_array_of_representative_images()
    {
        $this->process()->shouldBeArray();
        $this->process()->shouldHaveCount(2);
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
