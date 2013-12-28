<?php

namespace GSibay\DeveloperTask\Transformer;

use GSibay\DeveloperTask\Transformer\Transformer;
use \DOMDocument as DOMDocument;
use \XSLTProcessor as XSLTProcessor;

class DateTimeArrayXMLToTimeStampsXML implements Transformer
{

    static public function convertStrDate($originalFormat, $targetFormat, $strDate)
    {
        $newDate = \DateTime::createFromFormat($originalFormat, $strDate);
        //$newDate->setTimezone($timeZone);
        return $newDate->format($targetFormat);
        //return $newDate->format($targetFormat);
    }
    
    /**
     * TODO: is this the way to declare a type string?
     * The format to stamp the date 
     * @var string
     */
    private $format;
    
    /**
     * Constructor
     * @param string $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }
    
    /**
     * (non-PHPdoc)
     * @see Gsibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($anObject)
    {
        $originalDateFormat = 'Y-m-d H:i:s';
        $dateFormatTime = 'Y-m-d';
        $dateFormatText = 'U';

        // NUEVA IDEA! EN VEZ DE PONER LA FECHA ASI, MEJOR LA PONGO TIPO UNIX TIME Y AHI LA PUEDO
        // PARSEAR Y TENER EL DATETIME
        // You store the time either as a timestamp or a datetime in one timezone
        //
        $xsl = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
     xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" exclude-result-prefixes="php">
    <xsl:output method="xml" encoding="UTF-8" indent="yes"/>
    <xsl:template match="result">
        <timestamps>
            <xsl:apply-templates/>
        </timestamps>
    </xsl:template>
    <xsl:template match="entry">
        <timestamp> 
            <xsl:attribute name="asIs">
                <xsl:value-of select="." />
            </xsl:attribute>
            <xsl:attribute name="time">
                <xsl:value-of select="php:functionString('GSibay\DeveloperTask\Transformer\DateTimeArrayXMLToTimeStampsXML::convertStrDate', '$originalDateFormat', '$dateFormatTime', .)" disable-output-escaping="yes" />
            </xsl:attribute>
            <xsl:attribute name="text">
                <xsl:value-of select="php:functionString('GSibay\DeveloperTask\Transformer\DateTimeArrayXMLToTimeStampsXML::convertStrDate', '$originalDateFormat', '$dateFormatText', .)" disable-output-escaping="yes" />
            </xsl:attribute>
        </timestamp>
    </xsl:template>
</xsl:stylesheet>
EOT;
        
        $xmldoc = DOMDocument::loadXML($anObject);
        $xsldoc = DOMDocument::loadXML($xsl);
        
        $proc = new XSLTProcessor();
        $proc->registerPHPFunctions();
        $proc->importStyleSheet($xsldoc);
        return $proc->transformToXML($xmldoc);
    }
    
    /*
    $serializer = SerializerBuilder::create()->setDebug(true)->build();
    $date = new DateTime('1980-10-29');
    $dates = array($date, new DateTime('1990-10-29'));
    var_dump("before serialization: ");
    var_dump($dates);
    var_dump("normal serialization: ");
    $normalSerialization = $serializer->serialize($dates, 'xml');
    var_dump($normalSerialization);
    
    var_dump("deserialization: ");
    $dates = $serializer->deserialize($normalSerialization, "array<DateTime>", 'xml');
    var_dump($dates);
    */
    
}