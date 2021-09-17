<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data from YAML file.
 *
 * This class needs the php module yaml to be installed!
 *
 * @package Config
 * @author Stefanius <s.kientzler@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class YAMLConfig extends AbstractConfig
{
    /**
     * The constructor expects an valid filename/path to the YAML file.
     * @param string $strConfigFile
     */
    public function __construct(string $strConfigFile)
    {
        if (!extension_loaded('yaml')) {
            // no codecoverage: can only be tested on clean system...
            trigger_error('The php extension [yaml] must be installed!', E_USER_ERROR); // @codeCoverageIgnore
        } else {
            $this->aConfig = $this->parseFile($strConfigFile);
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
        }

        $strYaml = file_get_contents($strConfigFile);
        $aYAML = [];
        if ($strYaml !== false) {
            $aYAML = yaml_parse($strYaml);
            if ($aYAML === false) {
                // no codecoverage: haven't found example to test for returnvalue of false
                trigger_error('Invalid config file (' . $strConfigFile . ')', E_USER_ERROR); // @codeCoverageIgnore
            }
        }

        return $aYAML;
    }
}
