<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Transformer\ChainTransformer;
use \DateTime as DateTime;
use \Mockery as M;

class ChainTransformerTest extends \PHPUnit_Framework_TestCase
{

    public function test_Transform_EmptyChain_ObjetNotChanged()
    {
        $now = new DateTime();
        $chainTransformer = new ChainTransformer(array());
        $this->assertSame($now, $chainTransformer->transform($now));
    }

    public function test_Transform_OneTransformer_TransformerCalledOnce()
    {
        $objectToTransform = 'A string to be transformed';
        $expectedTransformedObject = 'The transformed string';

        $transformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $transformer->shouldReceive('transform')->once()->with($objectToTransform)
            ->andReturn($expectedTransformedObject);

        $chainTransformer = new ChainTransformer(array($transformer));

        $this->assertEquals($expectedTransformedObject,
                $chainTransformer->transform($objectToTransform));
    }

    public function test_Transform_ThreeTransformer_AllTransformersCalledInChain()
    {
        $objectToTransform = new DateTime();
        $objectAfterFirstTransformation = M::mock('\DateTime');
        $objectAfterSecondTransformation = M::mock('\DateTime');
        $objectAfterThirdTransformation = M::mock('\DateTime');

        $firstTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $firstTransformer->shouldReceive('transform')->with($objectToTransform)->once()->ordered()->andReturn($objectAfterFirstTransformation);

        $secondTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $secondTransformer->shouldReceive('transform')->with($objectAfterFirstTransformation)->once()->ordered()->andReturn($objectAfterSecondTransformation);

        $thirdTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $thirdTransformer->shouldReceive('transform')->with($objectAfterSecondTransformation)->once()->ordered()->andReturn($objectAfterThirdTransformation);

        $chainTransformer = new ChainTransformer(
                array($firstTransformer, $secondTransformer, $thirdTransformer));

        $this->assertEquals($objectAfterThirdTransformation, $chainTransformer->transform($objectToTransform));
    }
}
