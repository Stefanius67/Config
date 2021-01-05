<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data from XML file.
 *
 * #### History
 * - *2021-01-01*   initial version
 *
 * @package SKien/GCalendar
 * @version 1.0.0
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class XMLConfig extends AbstractConfig
{
    /**
     * Get the boolean value specified by path.
     * Accepted values are (case insensitiv): <ul>
     * <li> true, on, yes, 1 </li>
     * <li> false, off, no, none, 0 </li></ul>
     * for all other values the default is returned!
     * @param string $strPath
     * @param bool $bDefault
     * @return bool
     */
    public function getBool(string $strPath, bool $bDefault = false) : bool
    {
        $value = (string) $this->getValue($strPath, $bDefault);
        if ($this->isTrue($value)) {
            return true;
        } else if ($this->isFalse($value)) {
            return false;
        } else {
            return $bDefault;
        }
    }
    
    /**
     * Parse the given file an add all settings to the internal configuration.
     * @param string $strConfigFile
     */
    protected function parseFile(string $strConfigFile) : array
    {
        if (!file_exists($strConfigFile)) {
            trigger_error('Config File (' . $strConfigFile . ') does not exist!', E_USER_WARNING);
            return [];
        }
        
        $aXML = [];
        // first read XML data into stdclass object using the SimpleXML
        // to convert this object into associative array by encode it as JSON string and
        // decode it with the $assoc parameter set to true...
        $oXML = new \SimpleXMLElement($strConfigFile, 0, true);
        $strJSON = json_encode($oXML);
        $aXML = json_decode($strJSON, true);
        
        return $aXML;
    }
}
