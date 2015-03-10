<?php namespace spec\Thumbsnag;

require_once __DIR__ . '/../stub/DOMDocumentStub.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thumbsnag\Stub\DOMDocumentStub;

class BodyImagesSpec extends ObjectBehavior
{

    public function let()
    {
        $document = DOMDocumentStub::getDocument();

        $this->beConstructedWith($document);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Thumbsnag\BodyImages');
    }

    public function it_provides_body_images()
    {
        $this->images()->shouldBeArray();
        $this->images()->shouldHaveCount(3);
    }

    public function it_provides_an_empty_array_if_no_images_are_found()
    {
        $document = new \DOMDocument();
        $document->loadHTML('<html></html>');

        $this->beConstructedWith($document);

        $this->images()->shouldReturn([]);
    }
}
