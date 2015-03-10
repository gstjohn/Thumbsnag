<?php namespace spec\Thumbsnag;

require_once __DIR__ . '/../stub/DOMDocumentStub.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Thumbsnag\Location;
use Thumbsnag\Stub\DOMDocumentStub;

class ThumbsnagSpec extends ObjectBehavior
{

    public function let()
    {
        $document = DOMDocumentStub::getDocument();

        $this->beConstructedThrough('load', [$document]);
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
