<?php namespace spec\Thumbsnag;

require_once __DIR__ . '/../stub/DOMDocumentStub.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thumbsnag\Stub\DOMDocumentStub;

class OpenGraphSpec extends ObjectBehavior
{

    public function let()
    {
        $document = DOMDocumentStub::getDocument();

        $this->beConstructedWith($document);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Thumbsnag\OpenGraph');
    }

    public function it_provides_open_graph_meta_tag_images()
    {
        $this->images()->shouldBeArray();
        $this->images()->shouldHaveCount(2);
    }

    public function it_provides_an_empty_array_if_no_opengraph_images_are_found()
    {
        $document = new \DOMDocument();
        $document->loadHTML('<html></html>');

        $this->beConstructedWith($document);

        $this->images()->shouldReturn([]);
    }
}

