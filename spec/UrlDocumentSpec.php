<?php namespace spec\Thumbsnag;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlDocumentSpec extends ObjectBehavior
{

    public function let()
    {
        $document = new \DOMDocument('<html></html>');
        $documentUrl = 'http://simplegifts.co';

        $this->beConstructedThrough('build', [$document, $documentUrl]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Thumbsnag\UrlDocument');
    }

    public function it_should_be_able_to_get_the_document()
    {
        $this->getDocument()
            ->shouldReturnAnInstanceOf('\DOMDocument');
    }

    public function it_should_return_the_document_url()
    {
        $this->getUrl()
            ->shouldBeString();
    }
}

