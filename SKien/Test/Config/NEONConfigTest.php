<?php
declare(strict_types=1);

namespace SKien\Test\Config;

use SKien\Config\AbstractConfig;
use SKien\Config\NEONConfig;

/**
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class NEONConfigTest extends AbstractConfigTest
{
    public function test_constructMissing() : void
    {
        // test for not existing config file
        $this->expectError();
        $cfg = new NEONConfig('missing.neon');
        $cfg->getString('test');
    }

    public function test_constructInvalid() : void
    {
        $this->expectError();
        $cfg = new NEONConfig(dirname(__FILE__) . '/testdata/InvalidConfig.neon');
        $cfg->getString('test');
    }

    public function test_constructNull() : AbstractConfig
    {
        $cfg = new NEONConfig(dirname(__FILE__) . '/testdata/TestConfig.neon');
        $this->assertIsObject($cfg);

        return $cfg;
    }

    public function test_construct() : AbstractConfig
    {
        $cfg = new NEONConfig(dirname(__FILE__) . '/testdata/TestConfig.neon');
        $this->assertIsObject($cfg);

        return $cfg;
    }
}

