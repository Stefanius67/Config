<?php

require_once 'autoloader.php';

// use SKien\Config\JSONConfig;
// $oCfg = new JSONConfig('ExampleConfig.json');

// use SKien\Config\INIConfig;
// $oCfg = new INIConfig('ExampleConfig.ini');

use SKien\Config\XMLConfig;
$oCfg = new XMLConfig('ExampleConfig.xml');

echo '<h1>Base Entries</h1>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>' . $oCfg->getString('BaseString_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>' . $oCfg->getString('BaseString_2', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h1>Module 1</h1>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_1.String_1: ' . $oCfg->getString('Module_1.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_2: ' . $oCfg->getString('Module_1.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_3: ' . $oCfg->getString('Module_1.String_3', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.Int_1: ' . $oCfg->getString('Module_1.Int_1', 1) . '</li>' . PHP_EOL;
echo '<li>Module_1.Int_2: ' . $oCfg->getString('Module_1.Int_2', 2) . '</li>' . PHP_EOL;
echo '<li>Module_1.Int_3: ' . $oCfg->getString('Module_1.Int_3', 3) . '</li>' . PHP_EOL;
echo '<li>Module_1.Date_1: ' . date('d.m.Y', $oCfg->getDate('Module_1.Date_1', 0)) . '</li>' . PHP_EOL;
echo '<li>Module_1.Date_2: ' . date('d.m.Y', $oCfg->getDate('Module_1.Date_2', time())) . '</li>' . PHP_EOL;
echo '<li>Module_1.DateTime_1: ' . date('d M. Y - H:i', $oCfg->getDateTime('Module_1.DateTime_1', 0)) . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;

// or get all entries from Module_1 as Array...
echo '<h1>Module_1 as array</h1>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
$aModule1 = $oCfg->getArray('Module_1');
foreach ($aModule1 as $key => $value) {
    echo '<li>Module_1[' . $key . ']: ' . $value . '</li>' . PHP_EOL;
}
echo '</ul>' . PHP_EOL;

echo '<h1>Module_2</h1>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_2.String_1: ' . $oCfg->getString('Module_2.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_2.String_2: ' . $oCfg->getString('Module_2.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_2.Int_1: ' . $oCfg->getString('Module_2.Int_1', 1) . '</li>' . PHP_EOL;
echo '<li>Module_2.Int_2: ' . $oCfg->getString('Module_2.Int_2', 2) . '</li>' . PHP_EOL;
echo '<li>Module_2.Bool_1: ' . ($oCfg->getBool('Module_2.Bool_1') ? 'true' : 'false') . '</li>' . PHP_EOL;
echo '<li>Module_2.Bool_Error: ' . ($oCfg->getBool('Module_2.Bool_Error', true) ? 'true' : 'false') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;

echo '<h1>Module_3</h1>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_3.String_1: ' . $oCfg->getString('Module_3.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_3.String_2: ' . $oCfg->getString('Module_3.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;

echo '<h1>Array Entry</h1>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Indexed Array:<ul>' . PHP_EOL;
$aEntry = $oCfg->getArray('IndexedArray');
$i = 0;
foreach ($aEntry as $value) {
    echo '<li>Value[' . $i++ . ']: ' . $value . '</li>' . PHP_EOL;
}
echo '    </ul></li>' . PHP_EOL;
echo '<li>Associative Array:<ul>' . PHP_EOL;
$aEntry = $oCfg->getArray('AssocArray');
foreach ($aEntry as $key => $value) {
    echo '<li>Value[' . $key . ']: ' . $value . '</li>' . PHP_EOL;
}
echo '    </ul></li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
