<?php namespace spec\Thumbsnag;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedThrough('fromUrl', ['http://simplegifts.co/image1.jpg']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Thumbsnag\Image');
    }

    public function it_should_be_able_to_set_dimensions()
    {
        $this->setDimensions(100, 200);

        $this->getDimensions()->shouldEqual([100, 200]);
    }

    public function it_should_provide_its_width_to_height_ratio()
    {
        $this->setDimensions(100, 200);

        $this->getRatio()->shouldReturn(0.5);
    }
}
