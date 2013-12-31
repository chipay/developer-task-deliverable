<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Transformer\ChainTransformer;
use \DateTime as DateTime;
use \Mockery as m;

class ChainTransformerTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyChain_ObjetNotChanged()
    {
        $now = new DateTime();
        $chainTransformer = new ChainTransformer(array());
        $this->assertSame($now, $chainTransformer->transform($now));
    }

    public function testOneTransformer_TransformerCalledOnce()
    {
        $objectToTransform = "A string to be transformed";
        $expectedTransformedObject = "The transformed string";

        $transformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $transformer->shouldReceive('transform')->once()->with($objectToTransform)
            ->andReturn($expectedTransformedObject);

        $chainTransformer = new ChainTransformer(array($transformer));

        $this->assertEquals($expectedTransformedObject,
                $chainTransformer->transform($objectToTransform));
    }

    public function testThreeTransformer_AllTransformersCalledInChain()
    {
        $objectToTransform = new DateTime();
        $objectAfterFirstTransformation = new DateTime('20-10-1990');
        $objectAfterSecondTransformation = new DateTime('10-10-1998');
        $objectAfterThirdTransformation = new DateTime('1-1-1970');

        $firstTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $firstTransformer->shouldReceive('transform')->with($objectToTransform)
            ->andReturn($objectAfterFirstTransformation);

        $secondTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $secondTransformer->shouldReceive('transform')->with($objectAfterFirstTransformation)
            ->andReturn($objectAfterSecondTransformation);

        $thirdTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $thirdTransformer->shouldReceive('transform')->with($objectAfterSecondTransformation)
            ->andReturn($objectAfterThirdTransformation);

        $chainTransformer = new ChainTransformer(
                array($firstTransformer, $secondTransformer, $thirdTransformer));

        $this->assertEquals($objectAfterThirdTransformation, $chainTransformer->transform($objectToTransform));
    }
}
