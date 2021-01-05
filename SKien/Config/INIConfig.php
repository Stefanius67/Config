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
        $aINI = parse_ini_file($strConfigFile, TRUE);
        return $aINI;
    }
}
