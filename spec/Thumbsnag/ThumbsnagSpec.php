<?php namespace spec\Thumbsnag;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ThumbsnagSpec extends ObjectBehavior
{

    public function it_is_initializable()
    {
        $this->shouldHaveType('Thumbsnag\Thumbsnag');
    }
}

