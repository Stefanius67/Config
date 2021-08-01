<?php
declare(strict_types=1);

use SKien\Config\INIConfig;
use SKien\Config\JSONConfig;
use SKien\Config\NEONConfig;
use SKien\Config\XMLConfig;
use SKien\Config\YAMLConfig;

$strFormat = $_POST['format'] ?? 'JSON';
?>
<html>
<head>
<style>
body
{
    font-family: "Arial";
}
</style>
</head>
<body>
	<h1>Config: Example for the use of the different formats</h1>
	<form action="" enctype="multipart/form-data" method="post">
        <label for="format">File format:</label>
        <select name="format" size="1">
            <option <?php echo ($strFormat == 'JSON') ? 'selected ' : '';?>value="JSON">JSON</option>
            <option <?php echo ($strFormat == 'INI') ? 'selected ' : '';?>value="INI">INI</option>
            <option <?php echo ($strFormat == 'XML') ? 'selected ' : '';?>value="XML">XML</option>
            <option <?php echo ($strFormat == 'YAML') ? 'selected ' : '';?>value="YAML">YAML</option>
            <option <?php echo ($strFormat == 'NEON') ? 'selected ' : '';?>value="NEON">NEON</option>
        </select>
		<input type="submit" value="change format">
	</form>
<?php
require_once 'autoloader.php';


switch ($strFormat) {
    case 'INI':
        $strConfigFile = 'ExampleConfig.ini';
        $oCfg = new INIConfig($strConfigFile);
        break;
    case 'XML':
        $strConfigFile = 'ExampleConfig.xml';
        $oCfg = new XMLConfig($strConfigFile);
        break;
    case 'YAML':
        $strConfigFile = 'ExampleConfig.yaml';
        $oCfg = new YAMLConfig($strConfigFile);
        break;
    case 'NEON':
        $strConfigFile = 'ExampleConfig.neon';
        $oCfg = new NEONConfig($strConfigFile);
        break;
    default:
        $strConfigFile = 'ExampleConfig.json';
        $oCfg = new JSONConfig($strConfigFile);
        break;
}

echo '<h2>Configuration: ' . $strConfigFile . '</h2>' . PHP_EOL;
echo '<h3>Base Entries</h3>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>' . $oCfg->getString('BaseString_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>' . $oCfg->getString('BaseString_2', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;
echo '<h3>Module 1</h3>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_1.String_1: ' . $oCfg->getString('Module_1.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_2: ' . $oCfg->getString('Module_1.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.String_3: ' . $oCfg->getString('Module_1.String_3', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.EmptyString: ' . $oCfg->getString('Module_1.EmptyString', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_1.Int_1: ' . $oCfg->getInt('Module_1.Int_1', 1) . '</li>' . PHP_EOL;
echo '<li>Module_1.Int_2: ' . $oCfg->getInt('Module_1.Int_2', 2) . '</li>' . PHP_EOL;
echo '<li>Module_1.Int_3: ' . $oCfg->getInt('Module_1.Int_3', 3) . '</li>' . PHP_EOL;
echo '<li>Module_1.Date_1: ' . date('d.m.Y', $oCfg->getDate('Module_1.Date_1', 0)) . '</li>' . PHP_EOL;
echo '<li>Module_1.Date_2: ' . date('d.m.Y', $oCfg->getDate('Module_1.Date_2', time())) . '</li>' . PHP_EOL;
echo '<li>Module_1.DateTime_1: ' . date('d M. Y - H:i', $oCfg->getDateTime('Module_1.DateTime_1', 0)) . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;

// or get all entries from Module_1 as Array...
echo '<h3>Module_1 as array</h3>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
$aModule1 = $oCfg->getArray('Module_1');
foreach ($aModule1 as $key => $value) {
    echo '<li>Module_1[' . $key . ']: ' . $value . '</li>' . PHP_EOL;
}
echo '</ul>' . PHP_EOL;

echo '<h3>Module_2</h3>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_2.String_1: ' . $oCfg->getString('Module_2.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_2.String_2: ' . $oCfg->getString('Module_2.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_2.Int_1: ' . $oCfg->getInt('Module_2.Int_1', 1) . '</li>' . PHP_EOL;
echo '<li>Module_2.Int_2: ' . $oCfg->getInt('Module_2.Int_2', 2) . '</li>' . PHP_EOL;
echo '<li>Module_2.Float_1: ' . $oCfg->getFloat('Module_2.Float_1', 0.1) . '</li>' . PHP_EOL;
echo '<li>Module_2.Bool_1: ' . ($oCfg->getBool('Module_2.Bool_1') ? 'true' : 'false') . '</li>' . PHP_EOL;
echo '<li>Module_2.Bool_Error: ' . ($oCfg->getBool('Module_2.Bool_Error', true) ? 'true' : 'false') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;

echo '<h3>Module_3</h3>' . PHP_EOL;
echo '<ul>' . PHP_EOL;
echo '<li>Module_3.String_1: ' . $oCfg->getString('Module_3.String_1', 'Default String') . '</li>' . PHP_EOL;
echo '<li>Module_3.String_2: ' . $oCfg->getString('Module_3.String_2', 'Default String') . '</li>' . PHP_EOL;
echo '</ul>' . PHP_EOL;

echo '<h3>Array Entry</h3>' . PHP_EOL;
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
?>
</body>
</html>
