<html>
<head>
<style>
.config1
{
    color: red;
    font-weight: bold;
}
.config2
{
    color: blue;
    font-weight: bold;
}
</style>
</head>
<body>
<?php

require_once 'autoloader.php';

use SKien\Config\JSONConfig;
$oCfg1 = new JSONConfig('MergeExample1.json');

echo '<h1>Config 1</h1>' . PHP_EOL;
echo '<h2>Base Entries</h2>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>BaseString_1: ' . $oCfg1->getString('BaseString_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>BaseString_2: ' . $oCfg1->getString('BaseString_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>BaseString_3: ' . $oCfg1->getString('BaseString_3', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h2>Module 1</h2>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_1.String_1: ' . $oCfg1->getString('Module_1.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_2: ' . $oCfg1->getString('Module_1.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_3: ' . $oCfg1->getString('Module_1.String_3', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_4: ' . $oCfg1->getString('Module_1.String_4', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_5: ' . $oCfg1->getString('Module_1.String_5', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h2>Indexed Array:</h2>' . PHP_EOL;
$aEntry = $oCfg1->getArray('IndexedArray');
$i = 0;
echo '<ul>' . PHP_EOL;
foreach ($aEntry as $value) {
    echo '<li>Value[' . $i++ . ']: ' . $value . '</li>' . PHP_EOL;
}
echo '</ul>' . PHP_EOL;

$oCfg2 = new JSONConfig('MergeExample2.json');

echo '<h1>Config 2</h1>' . PHP_EOL;
echo '<h2>Base Entries</h2>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>BaseString_1: ' . $oCfg2->getString('BaseString_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>BaseString_2: ' . $oCfg2->getString('BaseString_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>BaseString_3: ' . $oCfg2->getString('BaseString_3', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h2>Module 1</h2>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_1.String_1: ' . $oCfg2->getString('Module_1.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_2: ' . $oCfg2->getString('Module_1.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_3: ' . $oCfg2->getString('Module_1.String_3', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_4: ' . $oCfg2->getString('Module_1.String_4', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_5: ' . $oCfg2->getString('Module_1.String_5', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h2>Indexed Array:</h2>' . PHP_EOL;
$aEntry = $oCfg2->getArray('IndexedArray');
$i = 0;
echo '<ul>' . PHP_EOL;
foreach ($aEntry as $value) {
    echo '<li>Value[' . $i++ . ']: ' . $value . '</li>' . PHP_EOL;
}
echo '</ul>' . PHP_EOL;

$oCfg3 = clone $oCfg1;
$oCfg3->mergeWith($oCfg2);

echo '<h1>Config 1 merged with Config 2</h1>' . PHP_EOL;
echo '<h2>Base Entries</h2>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>BaseString_1: ' . $oCfg3->getString('BaseString_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>BaseString_2: ' . $oCfg3->getString('BaseString_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>BaseString_3: ' . $oCfg3->getString('BaseString_3', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h2>Module 1</h2>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_1.String_1: ' . $oCfg3->getString('Module_1.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_2: ' . $oCfg3->getString('Module_1.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_3: ' . $oCfg3->getString('Module_1.String_3', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_4: ' . $oCfg3->getString('Module_1.String_4', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_5: ' . $oCfg3->getString('Module_1.String_5', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h2>Indexed Array:</h2>' . PHP_EOL;
$aEntry = $oCfg3->getArray('IndexedArray');
$i = 0;
echo '<ul>' . PHP_EOL;
foreach ($aEntry as $value) {
    echo '<li>Value[' . $i++ . ']: ' . $value . '</li>' . PHP_EOL;
}
echo '</ul>' . PHP_EOL;

$oCfg3 = clone $oCfg2;
$oCfg3->mergeWith($oCfg1);

echo '<h1>Config 2 merged with Config 1</h1>' . PHP_EOL;
echo '<h2>Base Entries</h2>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>BaseString_1: ' . $oCfg3->getString('BaseString_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>BaseString_2: ' . $oCfg3->getString('BaseString_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>BaseString_3: ' . $oCfg3->getString('BaseString_3', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h2>Module 1</h2>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_1.String_1: ' . $oCfg3->getString('Module_1.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_2: ' . $oCfg3->getString('Module_1.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_3: ' . $oCfg3->getString('Module_1.String_3', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_4: ' . $oCfg3->getString('Module_1.String_4', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_5: ' . $oCfg3->getString('Module_1.String_5', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h2>Indexed Array:</h2>' . PHP_EOL;
$aEntry = $oCfg3->getArray('IndexedArray');
$i = 0;
echo '<ul>' . PHP_EOL;
foreach ($aEntry as $value) {
    echo '<li>Value[' . $i++ . ']: ' . $value . '</li>' . PHP_EOL;
}
echo '</ul>' . PHP_EOL;

// use SKien\Config\INIConfig;
// $oCfg = new INIConfig('ExampleConfig.ini');

// use SKien\Config\XMLConfig;
// $oCfg = new XMLConfig('ExampleConfig.xml');
/*
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
*/
?>
</body>
</html>
