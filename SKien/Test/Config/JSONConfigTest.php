<?php
declare(strict_types=1);

namespace SKien\Test\Config;

use SKien\Config\AbstractConfig;
use SKien\Config\JSONConfig;

/**
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class JSONConfigTest extends AbstractConfigTest
{
    public function test_constructMissing() : void
    {
        // test for not existing config file
        $this->expectError();
        $cfg = new JSONConfig('missing.json');
        $cfg->getString('test');
    }
    
    public function test_constructInvalid() : void
    {
        $this->expectError();
        $cfg = new JSONConfig(dirname(__FILE__) . '/testdata/InvalidConfig.json');
        $cfg->getString('test');
    }
    
    public function test_constructNull() : AbstractConfig
    {
        $cfg = new JSONConfig(dirname(__FILE__) . '/testdata/TestConfig.json');
        $this->assertIsObject($cfg);
        
        return $cfg;
    }
    
    public function test_construct() : AbstractConfig
    {
        $cfg = new JSONConfig(dirname(__FILE__) . '/testdata/TestConfig.json');
        $this->assertIsObject($cfg);
        
        return $cfg;
    }
}

