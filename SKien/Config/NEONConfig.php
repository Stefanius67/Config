<?php
declare(strict_types=1);

namespace SKien\Config;

use Nette\Neon\Neon;

/**
 * Class for config component getting data from NEON file.
 *
 * This class uses the Nette/Neon module
 *
 * @package Config
 * @author Stefanius <s.kientzler@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class NEONConfig extends AbstractConfig
{
    /**
     * The constructor expects an valid filename/path to the NEON file.
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

        $aNeon = null;
        $strNeon = file_get_contents($strConfigFile);
        if ($strNeon !== false) {
            try {
                $aNeon = Neon::decode($strNeon);
                if (!is_array($aNeon)) {
                    trigger_error('Config file (' . $strConfigFile . ') does not contain config informations!', E_USER_ERROR);
                }
            } catch (\Exception $e) {
                trigger_error('Invalid config file (' . $strConfigFile . '): ' . $e->getMessage(), E_USER_ERROR);
            }
        }
        return $aNeon ?? [];
    }
}
