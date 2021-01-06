<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data from XML file.
 *
 * #### History
 * - *2021-01-01*   initial version
 *
 * @package SKien/Config
 * @version 1.0.0
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class XMLConfig extends AbstractConfig
{
    /**
     * The constructor expects an valid filename/path to the JSON file.
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
        try {
            $oXML = new \SimpleXMLElement($strConfigFile, 0, true);
            $strJSON = json_encode($oXML);
            $aXML = json_decode($strJSON, true);
        } catch (\Exception $e) {
            trigger_error('Invalid config file (' . $strConfigFile . '): ' . $e->getMessage(), E_USER_ERROR);
        }
        
        return $aXML;
    }
}
