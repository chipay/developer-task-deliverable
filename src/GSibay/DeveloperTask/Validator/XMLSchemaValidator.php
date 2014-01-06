<?php

namespace GSibay\DeveloperTask\Validator;

use \DOMDocument as DOMDocument;

/**
 * Validates an XML using a schema
 * @author gsibay
 *
 */
class XMLSchemaValidator implements Validator
{

    /**
     * file contaning the schema
     * @var string
     */
    private $schemaFileName;

    /**
     *
     * @param string $schemaFileName
     */
    public function __construct($schemaFileName)
    {
        if ($schemaFileName === null) {
            throw \RuntimeException("A schema must be provided.");
        }
        $this->schemaFileName = $schemaFileName;
    }

    public function validate($object)
    {
        $xml= new DOMDocument();
        $xml->loadXML($object, LIBXML_NOBLANKS);

        return $xml->schemaValidate($this->schemaFileName);
    }
}
