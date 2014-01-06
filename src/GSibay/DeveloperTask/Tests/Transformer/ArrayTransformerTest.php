<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Transformer\Transformer;
use GSibay\DeveloperTask\Transformer\ArrayTransformer;
use \DateTime as DateTime;
use \Mockery as M;

class ArrayTransformerTest extends \PHPUnit_Framework_TestCase
{

    public function test_Transform_EmptyArray_ReturnsEmptyArray()
    {
        $arrayTransformer = new ArrayTransformer(M::mock('GSibay\DeveloperTask\Transformer\Transformer'));
        $this->assertEquals(array(), $arrayTransformer->transform(array()));
    }

    public function test_Transform_OneElementArray_ReturnsOneElementArray()
    {
        $objectToTransform = M::mock('\DateTime');
        $transformedObject = M::mock('\DateTime');

        $transformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $transformer->shouldReceive('transform')->once()->with($objectToTransform)
            ->andReturn($transformedObject);

        $arrayTransformer = new ArrayTransformer($transformer);

        $this->assertEquals(array($transformedObject),
                $arrayTransformer->transform(array($objectToTransform)));
    }

    public function test_Transform_ThreeElementsArray_ReturnsThreeElementsArray()
    {
        $date1 = M::mock('\DateTime');
        $date2 = M::mock('\DateTime');
        $date3 = M::mock('\DateTime');

        $transformedDate1 = M::mock('\DateTime');
        $transformedDate2 = M::mock('\DateTime');
        $transformedDate3 = M::mock('\DateTime');

        $elementTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $elementTransformer->shouldReceive('transform')->with($date1)->once()->andReturn($transformedDate1)
            ->shouldReceive('transform')->with($date2)->once()->andReturn($transformedDate2)
            ->shouldReceive('transform')->with($date3)->once()->andReturn($transformedDate3)->ordered();

        $arrayTransformer = new ArrayTransformer($elementTransformer);

        $objectToTransform = array($date1, $date2, $date3);
        $expected = array($transformedDate1, $transformedDate2, $transformedDate3);
        $this->assertEquals($expected, $arrayTransformer->transform($objectToTransform));
    }
}
