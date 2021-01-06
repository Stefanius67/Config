<?php
declare(strict_types=1);

namespace SKien\Test\Config;

use PHPUnit\Framework\TestCase;
use SKien\Config\ArrayConfig;

/**
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class ArrayConfigTest extends TestCase
{
    public function test_construct()
    {
        $cfg = new ArrayConfig();
        $this->assertIsObject($cfg);
    }
    
    public function test_addConfig() : void
    {
        $cfg = $this->createConfig();
        $this->assertEquals('default', $cfg->getString('BaseString_2', 'default'));
        $this->assertEquals('First string Parameter', $cfg->getString('Module_1.String_1', 'default'));
        $this->assertEquals('Second string Parameter', $cfg->getString('Module_1.String_2', 'default'));
        $cfg->addConfig([
            "BaseString_2" => "Additional string Parameter",
            "Module_1" => [
                "String_1" => "Modified First string Parameter",
            ],
        ]);
        $this->assertEquals('Additional string Parameter', $cfg->getString('BaseString_2', 'default'));
        $this->assertEquals('Modified First string Parameter', $cfg->getString('Module_1.String_1', 'default'));
        $this->assertEquals('default', $cfg->getString('Module_1.String_2', 'default'));
    }
    
    public function test_setValue() : void
    {
        $cfg = $this->createConfig();
        $this->assertEquals('Base string Parameter', $cfg->getString('BaseString_1', 'default'));
        $cfg->setValue("BaseString_1", "Changed string Parameter");
        $cfg->setValue("BaseString_2", "Additional string Parameter");
        $this->assertEquals('Changed string Parameter', $cfg->getString('BaseString_1', 'default'));
        $this->assertEquals('Additional string Parameter', $cfg->getString('BaseString_2', 'default'));
    }
    
    protected function createConfig() : ArrayConfig
    {
        $cfg = new ArrayConfig([
            "BaseString_1" => "Base string Parameter",
            "Module_1" => [
                "String_1" => "First string Parameter",
                "String_2" => "Second string Parameter",
                ],
        ]);
        return $cfg;
    }
}
