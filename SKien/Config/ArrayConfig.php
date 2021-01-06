<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data directly from Array.
 *
 * #### History
 * - *2021-01-01*   initial version
 *
 * @package SKien/Config
 * @version 1.0.0
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class ArrayConfig extends AbstractConfig
{
    /**
     * The array containing comnfiguartion data can directly be passed to the constructor.
     * Addition data can be passed with the addValue() and addConfig() methods.
     * @param array $aConfig
     */
    public function __construct(array $aConfig = [])
    {
        $this->aConfig = $aConfig;
    }
    
    /**
     * Add additional data to the current config.
     * <b>Note: This method uses the php array_merge() function! </b><br/>
     * If the additional data contains section(s) the current config at least
     * contains, the complete section is overwritten! <br/>
     * If you want to 'realy' merge two configurations, you have to use separate
     * instances and use the mergeWith() method!
     * @param array $aConfig
     */
    public function addConfig(array $aConfig) : void
    {
        $this->aConfig = ($this->aConfig ? array_merge($this->aConfig, $aConfig) : $aConfig);
    }
    
    /**
     * Add new value to the config.
     * @param string $strName
     * @param mixed $value
     */
    public function setValue(string $strName, $value) : void
    {
        $this->aConfig ?: $this->aConfig = [];
        $this->aConfig[$strName] = $value;
    }
}
