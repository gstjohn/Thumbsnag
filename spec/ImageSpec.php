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

    public function it_should_throw_an_exception_if_trying_to_set_invalid_dimensions()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('setDimensions', [null, 125]);
    }

    public function it_should_provide_its_width_to_height_ratio()
    {
        $this->setDimensions(100, 200);

        $this->getRatio()->shouldReturn(0.5);
    }

    public function it_should_know_if_it_has_dimensions()
    {
        $this->hasDimensions()->shouldReturn(false);

        $this->setDimensions(100, 200);
        $this->hasDimensions()->shouldReturn(true);
    }

    public function it_should_return_its_url()
    {
        $this->getUrl()
            ->shouldReturn('http://simplegifts.co/image1.jpg');
    }

    public function it_should_be_able_to_reset_its_url()
    {
        $this->setUrl('http://simplegifts.co/image2.jpg');

        $this->getUrl()
            ->shouldReturn('http://simplegifts.co/image2.jpg');
    }

    public function it_should_cast_to_a_string_containing_url(){
        $this->__toString()
            ->shouldReturn('http://simplegifts.co/image1.jpg');
    }
}
