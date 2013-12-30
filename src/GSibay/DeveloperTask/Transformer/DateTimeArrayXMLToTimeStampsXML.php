<?php

namespace GSibay\DeveloperTask\Transformer;

use GSibay\DeveloperTask\Transformer\Transformer;
use \DOMDocument as DOMDocument;
use \XSLTProcessor as XSLTProcessor;

class DateTimeArrayXMLToTimeStampsXML implements Transformer
{

    public static function convertStrDate($originalFormat, $targetFormat, $strDate)
    {
        $newDate = \DateTime::createFromFormat($originalFormat, $strDate);

        return $newDate->format($targetFormat);
    }

    /**
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
}
