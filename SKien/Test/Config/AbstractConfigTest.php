<?php
declare(strict_types=1);

namespace SKien\Test\Config;

use PHPUnit\Framework\TestCase;
use SKien\Config\AbstractConfig;

/**
 * Abstract class providing comprehensive tests for all classes that implement the
 * PNDataProvider Interface.
 * Extending classes have to
 * - create database fixture for whole testclass in the static setUpBeforeClass() method
 * - create an instance of the class in the setUp() method and assign it to the $dp property
 * - implement tests to verify the creation
 * - implement tests for extended functions not supported by PNDataProvider
 * - Clean-Up Database after last test in the static tearDownAfterClass() method
 *
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
abstract class AbstractConfigTest extends TestCase
{
    /**
     * @depends test_constructNull
     */
    public function test_configIsNull(AbstractConfig $cfg) : void
    {
        // create reflection object to manipulate protected property of AbstractConfig
        $reflectionObject = new \ReflectionObject($cfg);

        $reflectionConfig = $reflectionObject->getProperty('aConfig');
        $reflectionConfig->setAccessible(true);
        $reflectionConfig->setValue($cfg, null);
        $this->assertEquals('default', $cfg->getString('BaseString_1', 'default'));
    }

    /**
     * @depends test_construct
     */
    public function test_getString(AbstractConfig $cfg) : void
    {
        $this->assertEquals('Base String Parameter', $cfg->getString('BaseString_1'));
    }

    /**
     * @depends test_construct
     */
    public function test_getStringEmpty(AbstractConfig $cfg) : void
    {
        $this->assertEquals('', $cfg->getString('Module_1.EmptyString', 'not empty'));
    }

    /**
     * @depends test_construct
     */
    public function test_getStringInvalid(AbstractConfig $cfg) : void
    {
        $this->assertEquals('invalid', $cfg->getString('BaseString_1.Invalid', 'invalid'));
    }

    /**
     * @depends test_construct
     */
    public function test_getStringDefault(AbstractConfig $cfg) : void
    {
        $this->assertEquals('default', $cfg->getString('BaseString_X', 'default'));
    }

    /**
     * @depends test_construct
     */
    public function test_getInt(AbstractConfig $cfg) : void
    {
        $this->assertEquals(10, $cfg->getInt('Module_1.Int_1'));
    }

    /**
     * @depends test_construct
     */
    public function test_getIntDefault(AbstractConfig $cfg) : void
    {
        $this->assertEquals(33, $cfg->getInt('Module_1.Int_X', 33));
    }

    /**
     * @depends test_construct
     */
    public function test_getFloat(AbstractConfig $cfg) : void
    {
        $this->assertEquals(12.34, $cfg->getFloat('Module_1.Float_1'));
    }

    /**
     * @depends test_construct
     */
    public function test_getFloatDefault(AbstractConfig $cfg) : void
    {
        $this->assertEquals(56.78, $cfg->getFloat('Module_1.Float_X', 56.78));
    }

    /**
     * @depends test_construct
     */
    public function test_getBoolTrue(AbstractConfig $cfg) : void
    {
        $this->assertEquals(true, $cfg->getBool('Module_2.True_1'));
        $this->assertEquals(true, $cfg->getBool('Module_2.True_2'));
        $this->assertEquals(true, $cfg->getBool('Module_2.True_3'));
        $this->assertEquals(true, $cfg->getBool('Module_2.True_4'));
        $this->assertEquals(true, $cfg->getBool('Module_2.True_5'));
        $this->assertEquals(true, $cfg->getBool('Module_2.True_6'));
        $this->assertEquals(true, $cfg->getBool('Module_2.True_7'));
        $this->assertEquals(true, $cfg->getBool('Module_2.True_8'));
    }

    /**
     * @depends test_construct
     */
    public function test_getBoolFalse(AbstractConfig $cfg) : void
    {
        $this->assertEquals(false, $cfg->getBool('Module_2.False_1'));
        $this->assertEquals(false, $cfg->getBool('Module_2.False_2'));
        $this->assertEquals(false, $cfg->getBool('Module_2.False_3'));
        $this->assertEquals(false, $cfg->getBool('Module_2.False_4'));
        $this->assertEquals(false, $cfg->getBool('Module_2.False_5'));
        $this->assertEquals(false, $cfg->getBool('Module_2.False_6'));
        $this->assertEquals(false, $cfg->getBool('Module_2.False_7'));
        $this->assertEquals(false, $cfg->getBool('Module_2.False_8'));
    }

    /**
     * @depends test_construct
     */
    public function test_getBoolInvalid(AbstractConfig $cfg) : void
    {
        $this->assertEquals(false, $cfg->getBool('Module_1.Bool_Invalid', false));
        $this->assertEquals(true, $cfg->getBool('Module_1.Bool_Invalid', true));
    }

    /**
     * @depends test_construct
     */
    public function test_getBoolDefault(AbstractConfig $cfg) : void
    {
        $this->assertEquals(false, $cfg->getBool('Module_1.Bool_X', false));
        $this->assertEquals(true, $cfg->getBool('Module_1.Bool_X', true));
    }

    /**
     * @depends test_construct
     */
    public function test_getDate(AbstractConfig $cfg) : void
    {
        $this->assertEquals('2021-01-12', date('Y-m-d', $cfg->getDate('Module_1.Date_1')));
        $this->assertEquals('2021-02-20', date('Y-m-d', $cfg->getDate('Module_1.Date_2')));
        $cfg->setDateFormat('d.m.Y');
        $this->assertEquals('2012-03-14', date('Y-m-d', $cfg->getDate('Module_1.Date_3')));
    }

    /**
     * @depends test_construct
     */
    public function test_getDateInvalid(AbstractConfig $cfg) : void
    {
        $this->assertEquals('2021-02-20', date('Y-m-d', $cfg->getDate('Module_1.Date_Invalid', mktime(0, 0, 0, 02, 20, 2021))));
    }

    /**
     * @depends test_construct
     */
    public function test_getDateDefault(AbstractConfig $cfg) : void
    {
        $this->assertEquals('2021-02-20', date('Y-m-d', $cfg->getDate('Module_1.Date_X', mktime(0, 0, 0, 02, 20, 2021))));
    }

    /**
     * @depends test_construct
     */
    public function test_getDateTime(AbstractConfig $cfg) : void
    {
        $this->assertEquals('2021-01-12 13:47', date('Y-m-d H:i', $cfg->getDateTime('Module_1.DateTime_1')));
        $this->assertEquals('2021-02-20 05:53', date('Y-m-d H:i', $cfg->getDateTime('Module_1.DateTime_2')));
        $cfg->setDateTimeFormat('d.m.Y H:i');
        $this->assertEquals('2012-03-14 13:47', date('Y-m-d H:i', $cfg->getDateTime('Module_1.DateTime_3')));
    }

    /**
     * @depends test_construct
     */
    public function test_getDateTimeInvalid(AbstractConfig $cfg) : void
    {
        $this->assertEquals('2021-02-20 16:27', date('Y-m-d H:i', $cfg->getDateTime('Module_1.DateTime_Invalid', mktime(16, 27, 0, 02, 20, 2021))));
    }

    /**
     * @depends test_construct
     */
    public function test_getDateTimeDefault(AbstractConfig $cfg) : void
    {
        $this->assertEquals('2021-02-20 16:27', date('Y-m-d H:i', $cfg->getDateTime('Module_1.DateTime_X', mktime(16, 27, 0, 02, 20, 2021))));
    }

    /**
     * @depends test_construct
     */
    public function test_getIndexedArray(AbstractConfig $cfg) : void
    {
        $aValues = $cfg->getArray('IndexedArray');
        $this->assertIsArray($aValues);
        $this->assertEquals(3, count($aValues));
        $this->assertEquals('First Element', $aValues[0]);
        $this->assertEquals('Second Element', $aValues[1]);
        $this->assertEquals('Third Element', $aValues[2]);
    }

    /**
     * @depends test_construct
     */
    public function test_getIndexedArray1(AbstractConfig $cfg) : void
    {
        $aValues = $cfg->getArray('BaseString_1');
        $this->assertIsArray($aValues);
        $this->assertEquals(1, count($aValues));
    }

    /**
     * @depends test_construct
     */
    public function test_getAssocArray(AbstractConfig $cfg) : void
    {
        $aValues = $cfg->getArray('AssocArray');
        $this->assertIsArray($aValues);
        $this->assertEquals(3, count($aValues));
        $this->assertEquals('Element 1', $aValues['First']);
        $this->assertEquals('Element 2', $aValues['Second']);
        $this->assertEquals('Element 3', $aValues['Third']);
    }

    /**
     * @depends test_construct
     */
    public function test_splitPath(AbstractConfig $cfg) : void
    {
        $rflMethod = $this->getProtectedMethod('splitPath', $cfg);
        $aTest = $rflMethod->invokeArgs($cfg, ['first.second']);
        $this->assertIsArray($aTest);
        $this->assertEquals(2, count($aTest));
    }

    /**
     * @depends test_construct
     */
    public function test_splitPathInvalid(AbstractConfig $cfg) : void
    {
        $cfg->setPathSeparator('');
        $rflMethod = $this->getProtectedMethod('splitPath', $cfg);
        // disable error_reporting() because set empty separator will cause
        // a PHP warning that would stop the execution of the testcode...
        $iLevel = error_reporting(0);
        $aTest = $rflMethod->invokeArgs($cfg, ['first.second']);
        error_reporting($iLevel);
        $this->assertIsArray($aTest);
        $this->assertEquals(1, count($aTest));
    }

    protected function getProtectedMethod(string $strMethod, AbstractConfig $cfg) : \ReflectionMethod
    {
        // create reflection object to call protected method of JsonLD
        $rflObject = new \ReflectionObject($cfg);

        $rflMethod = $rflObject->getMethod($strMethod);
        $rflMethod->setAccessible(true);

        return $rflMethod;
    }
}

