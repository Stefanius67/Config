<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data directly from Array.
 *
 * @package Config
 * @author Stefanius <s.kientzler@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class ArrayConfig extends AbstractConfig
{
    /**
     * The array containing configuartion data can directly be passed to the constructor.
     * Additional data can be passed with the `setValue()` and `addConfig()` methods.
     * @param array $aConfig    associative array
     */
    public function __construct(array $aConfig = [])
    {
        $this->aConfig = $aConfig;
    }

    /**
     * Add additional data to the current config.
     * <b>Note: This method uses the php `array_merge()` function! </b><br/>
     * If the additional data contains section(s) the current config at least
     * contains, the complete section is overwritten! <br/>
     * If you want to 'realy' merge two configurations, you have to use separate
     * instances and use the mergeWith() method!
     * @param array $aConfig    associative array
     */
    public function addConfig(array $aConfig) : void
    {
        $this->aConfig = ($this->aConfig ? array_merge($this->aConfig, $aConfig) : $aConfig);
    }

    /**
     * Add new value to the config.
     * Currently only values of highest level are supported.
     * @param string $strName   name of the value to set
     * @param mixed $value      value to set
     */
    public function setValue(string $strName, $value) : void
    {
        $this->aConfig ?: $this->aConfig = [];
        $this->aConfig[$strName] = $value;
    }
}
