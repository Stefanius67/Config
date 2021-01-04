<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data from JSON file.
 *
 * #### History
 * - *2021-01-01*   initial version
 *
 * @package SKien/GCalendar
 * @version 1.0.0
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class JSONConfig extends AbstractConfig
{
    /** @var array holding the config data    */
    protected ?array $aConfig = null;
    
    /**
     * The constructor expects an valid filename/path to the JSON file.
     * @param string $strConfigFile
     */
    public function __construct(string $strConfigFile)
    {
        if (!file_exists($strConfigFile)) {
            trigger_error('Config File (' . $strConfigFile . ') does not exist!', E_USER_WARNING);
            return;
        }
        
        $strJson = file_get_contents($strConfigFile);
        $this->aConfig = json_decode($strJson, true);
        if ($this->aConfig === null) {
            trigger_error('Invalid config file (' . $strConfigFile . '): ' . json_last_error_msg(), E_USER_ERROR);
        }
    }
    
    /**
     * Get the value specified by path.
     * @param string $strPath
     * @param mixed $default
     * @return mixed
     */
    public function getValue(string $strPath, $default = null)
    {
        if ($this->aConfig === null) {
            // without valid config file just return the default value
            return $default;
        }
        $aPath = $this->splitPath($strPath);
        $iDepth = count($aPath);
        $value = null;
        $aValues = $this->aConfig;
        for ($i = 0; $i < $iDepth; $i++) {
            if (!is_array($aValues)) {
                $value = null;
                break;
            }
            $value = $aValues[$aPath[$i]] ?? null;
            if ($value === null) {
                break;
            }
            $aValues = $value;
        }
        return $value ?? $default;
    }
    
    /**
     * Split the given path in its components.
     * @param string $strPath
     * @return array
     */
    protected function splitPath(string $strPath) : array
    {
        return explode('.', $strPath);
    }
}
