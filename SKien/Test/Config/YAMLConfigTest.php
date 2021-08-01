<?php
declare(strict_types=1);

namespace SKien\Test\Config;

use SKien\Config\AbstractConfig;
use SKien\Config\YAMLConfig;

/**
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class YAMLConfigTest extends AbstractConfigTest
{
    public function test_constructMissing() : void
    {
        // test for not existing config file
        $this->expectError();
        $cfg = new YAMLConfig('missing.yaml');
        $cfg->getString('test');
    }

    public function test_constructInvalid() : void
    {
        $this->expectError();
        $cfg = new YAMLConfig(dirname(__FILE__) . '/testdata/InvalidConfig.yaml');
        $cfg->getString('test');
    }

    public function test_constructNull() : AbstractConfig
    {
        $cfg = new YAMLConfig(dirname(__FILE__) . '/testdata/TestConfig.yaml');
        $this->assertIsObject($cfg);

        return $cfg;
    }

    public function test_construct() : AbstractConfig
    {
        $cfg = new YAMLConfig(dirname(__FILE__) . '/testdata/TestConfig.yaml');
        $this->assertIsObject($cfg);

        return $cfg;
    }
}

