<html>
<head>
<style>
body
{
    font-family: "Arial";
}
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
.default
{
    color: grey;
    font-style: italic;
}
</style>
</head>
<body>
	<h1>Config: Example how the mergeWith() method works</h1>
<?php
require_once 'autoloader.php';

use SKien\Config\JSONConfig;
use SKien\Config\ConfigInterface;

// load first config and display the content
// -> only the values defined in this file are available
$oCfg1 = new JSONConfig('MergeExample1.json');

echo '<h2>pure Config 1</h2>' . PHP_EOL;
printConfig($oCfg1);

// load second config and display the content
// -> only the values defined in this file are available
$oCfg2 = new JSONConfig('MergeExample2.json');

echo '<h2>pure Config 2</h2>' . PHP_EOL;
printConfig($oCfg2);

// clone first config and merge it with the second.
// -> elements only available in first config keep the value
// -> elements available in both are overwritten with value from second config
// -> elements only available in second config are supplemented
// -> index based array elements are overwritten as whole element
$oCfg3 = clone $oCfg1;
$oCfg3->mergeWith($oCfg2);

echo '<h2>Config 1 merged with Config 2</h2>' . PHP_EOL;
printConfig($oCfg3);


// clone second config and merge it with the first.
// -> elements only available in second config keep the value
// -> elements available in both are overwritten with value from first config
// -> elements only available in second first are supplemented
// -> index based array elements are overwritten as whole element
$oCfg3 = clone $oCfg2;
$oCfg3->mergeWith($oCfg1);

echo '<h2>Config 2 merged with Config 1</h2>' . PHP_EOL;
printConfig($oCfg3);

/**
 * Just print the values of the given config
 * @param ConfigInterface $oCfg
 */
function printConfig(ConfigInterface $oCfg) : void
{
    echo '<h3>Base Entries</h3>' . PHP_EOL;
    echo '<ul>' . PHP_EOL;
    echo '<li>BaseString_1: ' . $oCfg->getString('BaseString_1', '<span class=default>not Set</span>') . '</li>' . PHP_EOL;
    echo '<li>BaseString_2: ' . $oCfg->getString('BaseString_2', '<span class=default>not Set</span>') . '</li>' . PHP_EOL;
    echo '<li>BaseString_3: ' . $oCfg->getString('BaseString_3', '<span class=default>not Set</span>') . '</li>' . PHP_EOL;
    echo '</ul>' . PHP_EOL;
    echo '<h3>Module 1</h3>' . PHP_EOL;
    echo '<ul>' . PHP_EOL;
    echo '<li>Module_1.String_1: ' . $oCfg->getString('Module_1.String_1', '<span class=default>not Set</span>') . '</li>' . PHP_EOL;
    echo '<li>Module_1.String_2: ' . $oCfg->getString('Module_1.String_2', '<span class=default>not Set</span>') . '</li>' . PHP_EOL;
    echo '<li>Module_1.String_3: ' . $oCfg->getString('Module_1.String_3', '<span class=default>not Set</span>') . '</li>' . PHP_EOL;
    echo '<li>Module_1.String_4: ' . $oCfg->getString('Module_1.String_4', '<span class=default>not Set</span>') . '</li>' . PHP_EOL;
    echo '<li>Module_1.String_5: ' . $oCfg->getString('Module_1.String_5', '<span class=default>not Set</span>') . '</li>' . PHP_EOL;
    echo '</ul>' . PHP_EOL;
    echo '<h3>Indexed Array:</h3>' . PHP_EOL;
    $aEntry = $oCfg->getArray('IndexedArray');
    $i = 0;
    echo '<ul>' . PHP_EOL;
    foreach ($aEntry as $value) {
        echo '<li>Value[' . $i++ . ']: ' . $value . '</li>' . PHP_EOL;
    }
    echo '</ul>' . PHP_EOL;
}
?>
</body>
</html>
