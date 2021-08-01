<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data from XML file.
 *
 * @package Config
 * @author Stefanius <s.kientzler@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class XMLConfig extends AbstractConfig
{
    /**
     * The constructor expects an valid filename/path to the XML file.
     * @param string $strConfigFile
     */
    public function __construct(string $strConfigFile)
    {
        $this->aConfig = $this->parseFile($strConfigFile);
    }

    /**
     * Parse the given file an add all settings to the internal configuration.
     * @param string $strConfigFile
     */
    protected function parseFile(string $strConfigFile) : array
    {
        if (!file_exists($strConfigFile)) {
            trigger_error('Config File (' . $strConfigFile . ') does not exist!', E_USER_WARNING);
        }

        // first read XML data into stdclass object using the SimpleXML
        // to convert this object into associative array by encode it as JSON string and
        // decode it with the $assoc parameter set to true...
        $aXML = [];
        try {
            $oXML = new \SimpleXMLElement($strConfigFile, 0, true);
            $strJSON = json_encode($oXML);
            // 1. SimpleXMLElement converts an empty node to an empty SimpleXMLElement
            // 2. json_encode() converts an empty SimpleXMLElement to '{}'
            // 3. json_decode() converts '{}' to an empty array :-(
            // -> to prevent this, we replace all '{}' with an empty string '""' before decoding!
            $strJSON = str_replace('{}', '""', $strJSON);
            $aXML = json_decode($strJSON, true);
        } catch (\Exception $e) {
            trigger_error('Invalid config file (' . $strConfigFile . '): ' . $e->getMessage(), E_USER_ERROR);
        }

        return $aXML;
    }
}
