<?php
declare(strict_types=1);

namespace SKien\Test\Config;

use PHPUnit\Framework\TestCase;
use SKien\Config\NullConfig;

/**
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class NullConfigTest extends TestCase
{
    public function test_construct()
    {
        $cfg = new NullConfig();
        $this->assertIsObject($cfg);
        $this->assertEquals('default', $cfg->getString('BaseString_1', 'default'));
        $this->assertEquals(10, $cfg->getInt('Module_1.Int_1', 10));
        $this->assertEquals(12.34, $cfg->getFloat('Module_1.Float_1', 12.34));
        $this->assertEquals(false, $cfg->getBool('Module_1.Bool_X', false));
        $this->assertEquals(true, $cfg->getBool('Module_1.Bool_X', true));
        $this->assertEquals('2021-02-20', date('Y-m-d', $cfg->getDate('Module_1.Date_X', mktime(0, 0, 0, 02, 20, 2021))));
        $this->assertEquals('2021-02-20 16:27', date('Y-m-d H:i', $cfg->getDateTime('Module_1.DateTime_X', mktime(16, 27, 0, 02, 20, 2021))));
    }

    public function test_getIndexedArray() : void
    {
        $cfg = new NullConfig();
        $aValues = $cfg->getArray('IndexedArray', ['First Element', 'Second Element', 'Third Element']);
        $this->assertIsArray($aValues);
        $this->assertEquals(3, count($aValues));
        $this->assertEquals('First Element', $aValues[0]);
        $this->assertEquals('Second Element', $aValues[1]);
        $this->assertEquals('Third Element', $aValues[2]);
    }

    public function test_getAssocArray() : void
    {
        $cfg = new NullConfig();
        $aValues = $cfg->getArray('AssocArray', ['First' => 'Element 1', 'Second' => 'Element 2', 'Third' => 'Element 3']);
        $this->assertIsArray($aValues);
        $this->assertEquals(3, count($aValues));
        $this->assertEquals('Element 1', $aValues['First']);
        $this->assertEquals('Element 2', $aValues['Second']);
        $this->assertEquals('Element 3', $aValues['Third']);
    }
}
