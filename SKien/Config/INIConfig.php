<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data from INI file.
 * Lines begin with semikolon are ignored as comments.
 * The begin of a section have to be set in square brackets.
 * A section is active until next section begins or to the end of file.
 *
 * #### History
 * - *2021-01-01*   initial version
 *
 * @package SKien/Config
 * @version 1.0.0
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class INIConfig extends AbstractConfig
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
        $aINI = parse_ini_file($strConfigFile, TRUE);
        if ($aINI === false) {
            $aINI = [];
        }
        return $aINI;
    }
}
