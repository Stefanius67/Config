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

    public function test_mergeWith() : void
    {
        $cfg1 = new JSONConfig(dirname(__FILE__) . '/testdata/MergeExample1.json');
        $cfg2 = new JSONConfig(dirname(__FILE__) . '/testdata/MergeExample2.json');

        $this->assertEquals('First string - Config 1', $cfg1->getString('Module_1.String_1'));
        $this->assertEquals('Second string - Config 1', $cfg1->getString('Module_1.String_2'));
        $this->assertEquals('Third string - Config 1', $cfg1->getString('Module_1.String_3'));
        $this->assertEquals('default', $cfg1->getString('Module_1.String_4', 'default'));
        $this->assertEquals('default', $cfg1->getString('Module_1.String_5', 'default'));

        $cfg1->mergeWith($cfg2);

        $this->assertEquals('First string - Config 1', $cfg1->getString('Module_1.String_1'));
        $this->assertEquals('Second string - Config 1', $cfg1->getString('Module_1.String_2'));
        $this->assertEquals('Third string - Config 2', $cfg1->getString('Module_1.String_3'));
        $this->assertEquals('Fourth string - Config 2', $cfg1->getString('Module_1.String_4', 'default'));
        $this->assertEquals('Fifth string - Config 2', $cfg1->getString('Module_1.String_5', 'default'));
    }

    public function test_mergeWithEmpty() : void
    {
        $cfg1 = new JSONConfig(dirname(__FILE__) . '/testdata/MergeExample1.json');
        $cfg2 = new JSONConfig(dirname(__FILE__) . '/testdata/MergeExample2.json');

        // create reflection object to manipulate protected property
        $reflectionObject = new \ReflectionObject($cfg1);

        $reflectionConfig = $reflectionObject->getProperty('aConfig');
        $reflectionConfig->setAccessible(true);
        $reflectionConfig->setValue($cfg1, null);
        $this->assertEquals('default', $cfg1->getString('BaseString_1', 'default'));

        $cfg1->mergeWith($cfg2);
        $this->assertEquals('Base String 2 - Config 2', $cfg1->getString('BaseString_2'));
    }
}

