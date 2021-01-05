<?php
declare(strict_types=1);

namespace SKien\Test\Config;

use SKien\Config\AbstractConfig;
use SKien\Config\INIConfig;

/**
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class INIConfigTest extends AbstractConfigTest
{
    public function test_constructMissing() : void
    {
        // test for not existing config file
        $this->expectError();
        $cfg = new INIConfig('missing.ini');
        $cfg->getString('test');
    }
    
    public function test_constructNull() : AbstractConfig
    {
        $cfg = new INIConfig(dirname(__FILE__) . '/testdata/TestConfig.ini');
        $this->assertIsObject($cfg);
        
        return $cfg;
    }
    
    public function test_construct() : AbstractConfig
    {
        $cfg = new INIConfig(dirname(__FILE__) . '/testdata/TestConfig.ini');
        $this->assertIsObject($cfg);
        
        return $cfg;
    }
}

