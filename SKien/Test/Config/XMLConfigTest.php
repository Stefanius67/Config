<?php
declare(strict_types=1);

namespace SKien\Test\Config;

use SKien\Config\AbstractConfig;
use SKien\Config\XMLConfig;

/**
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class XMLConfigTest extends AbstractConfigTest
{
    public function test_constructMissing() : void
    {
        // test for not existing config file
        $this->expectError();
        $cfg = new XMLConfig('missing.xml');
        $cfg->getString('test');
    }
    
    public function test_constructInvalid() : void
    {
        $this->expectError();
        $cfg = new XMLConfig(dirname(__FILE__) . '/testdata/InvalidConfig.xml');
        $cfg->getString('test');
    }
    
    public function test_constructNull() : AbstractConfig
    {
        $cfg = new XMLConfig(dirname(__FILE__) . '/testdata/TestConfig.xml');
        $this->assertIsObject($cfg);
        
        return $cfg;
    }
    
    public function test_construct() : AbstractConfig
    {
        $cfg = new XMLConfig(dirname(__FILE__) . '/testdata/TestConfig.xml');
        $this->assertIsObject($cfg);
        
        return $cfg;
    }
}

