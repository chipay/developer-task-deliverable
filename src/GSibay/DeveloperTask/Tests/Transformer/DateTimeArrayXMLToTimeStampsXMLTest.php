<?php

namespace GSibay\DeveloperTask\Tests;

use GSibay\DeveloperTask\Transformer\DateTimeArrayXMLToTimeStampsXML;

class DateTimeArrayXMLToTimeStampsXMLTest extends \PHPUnit_Framework_TestCase
{
    
    //TODO: add the TimeZone to the format in these tests
    
    public function testTransformer_NoEntrie_NoTimestampExpected()
    {
        $xml = <<<EOB
<?xml version='1.0' encoding='UTF-8'?>
<result>
</result>
EOB;
        
        $expectedTransformedXml = <<<EOB
<?xml version='1.0' encoding='UTF-8'?>
<timestamps>
</timestamps>
EOB;

        ////var_dump('originalXML: '.$xml);
        
        $transformer = new DateTimeArrayXMLToTimeStampsXML('Y-m-d H:i:s');
        $transformedXML = $transformer->transform($xml);
        
        $this->assertXmlStringEqualsXmlString($expectedTransformedXml, $transformedXML);
    }

    public function testTransformer_OneEntrie_OneTimestampExpected()
    {
        $this->markTestSkipped('timestamp is lost in entry. It should be saved as timestamp');
        $xml = <<<EOB
<?xml version='1.0' encoding='UTF-8'?>
<result>
<entry><![CDATA[2009-06-30 13:00:00]]></entry>
</result>
EOB;
    
        $expectedTransformedXml = <<<EOB
<?xml version='1.0' encoding='UTF-8'?>
<timestamps>
    <timestamp time="1246406400" text="2009-06-30 13:00:00" />
</timestamps>
EOB;
    
        $transformer = new DateTimeArrayXMLToTimeStampsXML('Y-m-d H:i:s');
        $transformedXML = $transformer->transform($xml);
        $this->assertXmlStringEqualsXmlString($expectedTransformedXml, $transformedXML);
    }
    
}