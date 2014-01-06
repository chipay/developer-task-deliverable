<?php

namespace GSibay\DeveloperTask\Tests\Validator;

use GSibay\DeveloperTask\Validator\XMLSchemaValidator;

use GSibay\DeveloperTask\Validator;

class XMLSchemaValidatorTest extends \PHPUnit_Framework_TestCase
{

    const SCHEMA_FILE_NAME = "/../schema.xsd";
    
    public static function setUpBeforeClass()
    {
        $schemaFileName = __DIR__ . self::SCHEMA_FILE_NAME;
        $schemaStr = <<<EOB
<?xml version="1.0" encoding="utf-8"?>
<xsd:schema attributeFormDefault="unqualified" elementFormDefault="qualified" version="1.0" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <xsd:element name="timestamps" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element minOccurs="0" maxOccurs="unbounded" name="timestamp">
                    <xsd:complexType>
                        <xsd:attribute name="time" type="xsd:int"/>
                        <xsd:attribute name="text" type="xsd:string"/>
                    </xsd:complexType>
                </xsd:element>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:schema>
EOB;

        file_put_contents($schemaFileName, $schemaStr) or die;         
    }
    
    public static function tearDownAfterClass()
    {
        unlink(__DIR__ . self::SCHEMA_FILE_NAME);
    }
    
    public function test_Validate_NoTimestampChild_ReturnsTrue()
    {
        $validator = new XMLSchemaValidator(__DIR__ . self::SCHEMA_FILE_NAME);
        $validXml = "<?xml version='1.0' encoding='UTF-8'?><timestamps></timestamps>";
        
        $this->assertTrue($validator->validate($validXml));
    }

    public function test_Validate_NoTimestampChildSelfClosing_ReturnsTrue()
    {
        $validator = new XMLSchemaValidator(__DIR__ . self::SCHEMA_FILE_NAME);
        $validXml = "<?xml version='1.0' encoding='UTF-8'?><timestamps/>";
    
        $this->assertTrue($validator->validate($validXml));
    }
    
    public function test_Validate_OneChild_ReturnsTrue()
    {
        $validator = new XMLSchemaValidator(__DIR__ . self::SCHEMA_FILE_NAME);
        $validXml = "<?xml version='1.0' encoding='UTF-8'?>
        <timestamps><timestamp time='239983' text='24-2-1970 13:00:00' /></timestamps>";
    
        $this->assertTrue($validator->validate($validXml));
    }

    public function test_Validate_ThreeChildren_ReturnsTrue()
    {
        $validator = new XMLSchemaValidator(__DIR__ . self::SCHEMA_FILE_NAME);
        $validXml = "<?xml version='1.0' encoding='UTF-8'?>
        <timestamps>
            <timestamp time='23' text='24-2-1970 14:00:00' />
            <timestamp time='2' text='24-2-2170 13:00:00' />
            <timestamp time='4434234' text='24-2-1970 15:05:00' />
            <timestamp time='2392334' text='24-2-1780 13:00:00' />
            <timestamp time='233232983' text='24-2-1978 13:33:12' />
        </timestamps>";
    
        $this->assertTrue($validator->validate($validXml));
    }
    
    public function test_Validate_NoTimestampsEnclosingTag_ReturnsFalse()
    {
        $validator = new XMLSchemaValidator(__DIR__ . self::SCHEMA_FILE_NAME);
        $validXml = "<?xml version='1.0' encoding='UTF-8'?>
        <timestamp time='239983' text='24-2-1970 13:00:00' />";
        
        //ignore warnings for this test. Only check that the validation is false
        @$this->assertFalse($validator->validate($validXml));
    }
}
