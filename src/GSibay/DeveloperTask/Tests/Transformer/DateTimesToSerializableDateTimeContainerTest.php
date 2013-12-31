<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use \Mockery as m;

class DateTimesToSerializableDateTimeContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyDateTimes_EqualsEmptyArray()
    {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
        //Transformer
    }
    
    public function testXXX()
    {
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
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
