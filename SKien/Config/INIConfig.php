<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Class for config component getting data from INI file.
 * Lines begin with semikolon are ignored as comments.
 * The begin of a section have to be set in square brackets.
 * A section is active until next section begins or to the end of file.
 *
 * #### History
 * - *2021-01-01*   initial version
 *
 * @package SKien/Config
 * @version 1.0.0
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
class INIConfig extends AbstractConfig
{
    /** @var array holding the config data    */
    protected ?array $aConfig = null;
    
    /**
     * The constructor expects an valid filename/path to the JSON file.
     * @param string $strConfigFile
     */
    public function __construct(string $strConfigFile)
    {
        if (!file_exists($strConfigFile)) {
            trigger_error('Config File (' . $strConfigFile . ') does not exist!', E_USER_WARNING);
            return;
        }
        
        $this->aConfig = [];
        $aSection = null;
        $strSection = null;
        $aLines = file($strConfigFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($aLines as $strLine) {
            $strLine = $this->skipComment($strLine);
            if (strlen($strLine) === 0) {
                continue;
            }
            // check for new section
            if (($strNewSection = $this->getSection($strLine)) !== null) {
                $this->addSection($strSection, $aSection);
                $strSection = $strNewSection;
                $aSection = [];
                continue;
            }
            list ($strName, $strValue) = explode('=', $strLine, 2);
            $strName = trim($strName);
            if ($this->isArray($strValue)) {
                $value = $this->parseArray($strValue);
            } else {
                $value = $this->trimValue($strValue);
            }
            $aSection !== null ? $aSection[$strName] = $value : $this->aConfig[$strName] = $value;
        }
        $this->addSection($strSection, $aSection);
    }
    
    /**
     * Get the value specified by path.
     * INI file only supports sections. 
     * @param string $strPath
     * @param mixed $default
     * @return mixed
     */
    public function getValue(string $strPath, $default = null)
    {
        if ($this->aConfig === null) {
            // without valid config file just return the default value
            return $default;
        }
        $aPath = $this->splitPath($strPath);
        if (count($aPath) > 1) {
            return $this->aConfig[$aPath[0]][$aPath[1]] ?? $default;
        } else {
            return $this->aConfig[$strPath] ?? $default;
        }
    }
    
    /**
     * Get the boolean value specified by path.
     * Accepted values are (case insensitiv): <ul>
     * <li> true, on, yes, 1 </li>
     * <li> false, off, no, none, 0 </li></ul>
     * for all other values the default is returned!
     * @param string $strPath
     * @param bool $bDefault
     * @return bool
     */
    public function getBool(string $strPath, bool $bDefault = false) : bool
    {
        $value = (string) $this->getValue($strPath, $bDefault);
        if ($this->isTrue($value)) {
            return true;
        } else if ($this->isFalse($value)) {
            return false;
        } else {
            return $bDefault;
        }
    }
    
    /**
     * Split the given path in section and name.
     * INI files only support depth of 1 level (-> sections).
     * @param string $strPath
     * @return array
     */
    protected function splitPath(string $strPath) : array
    {
        return explode('.', $strPath, 2);
    }
    
    /**
     * Skip all from the first ';' as comment.
     * ';' inside of single/double quot belongs to the value and do not mark a comment!
     * @param string $strLine
     * @return string
     */
    protected function skipComment(string $strLine) : string
    {
        $strLine = trim($strLine);
        if (substr($strLine, 0, 1) == ';') {
            return '';
        }
        if (strpos($strLine, ';') === false) {
            return $strLine;
        }
        // Since both single and double quotes are supported, it is a bit complicated to solve 
        // this with a RegEx (... and unfortunately I am not really a specialist in RegEx)
        // Therefore following is simply coded 'pure' to find first semikolon ouside of quotes
        // to skip the rest as comment
        $iLen = strlen($strLine);
        $bInDblQuote = false;
        $bInSingleQuote = false;
        for ($i = 0; $i < $iLen; $i++) {
            if ($bInDblQuote) {
                $bInDblQuote = ($strLine[$i] != '"');
                continue;
            } else if ($bInSingleQuote) {
                $bInSingleQuote = ($strLine[$i] != "'");
                continue;
            } else {
                $bInDblQuote = ($strLine[$i] == '"');
                $bInSingleQuote = ($strLine[$i] == "'");
            }
            if ($strLine[$i] == ";") {
                break;
            }
        }
        return substr($strLine, 0, $i);
    }
    
    /**
     * Trim the value.
     * All whitespaces and single OR double quotes are removed.
     * @param string $strValue
     * @return string
     */
    protected function trimValue(string $strValue) : string
    {
        // all whitespaces...
        $strValue = trim($strValue);
        // ... and single or double quotation marks
        if (substr($strValue, 0, 1) === '"') {
            return trim($strValue, '"');
        } else {
            return trim($strValue, "'");
        }
    }
    
    /**
     * Check, if value contains array.
     * @param string $strValue
     * @return bool
     */
    protected function isArray(string $strValue) : bool
    {
        // only Comma outside of double quot...
        $bComma = (preg_match_all('/^([^"]|"[^"]*")*?(,)/', $strValue) > 0);
        // ... and outside of single quot are counting
        $bComma = $bComma && (preg_match_all('/^([^\']|\'[^\']*\')*?(,)/', $strValue) > 0);
        return $bComma;
    }
    
    /**
     * Parse string into array.
     * Using the str_getcsv() method we don't have to take care about separator(s)
     * inside of quotation marks! 
     * @param string $strValue
     * @return array
     */
    protected function parseArray(string $strValue) : array
    {
        $strValue = trim($strValue);
        $enclosure = substr($strValue, 0, 1);
        if ($enclosure == "'") {
            $aValues = str_getcsv($strValue, ',', "'");
        } else {
            $aValues = str_getcsv($strValue);
        }
        return $aValues;
    }
    
    /**
     * Check if line starts new section and extract it. 
     * @param string $strLine
     * @return string|NULL name of the section or null, if no section specified.
     */
    protected function getSection(string $strLine) : ?string
    {
        $strSection = null;
        $aSections = null;
        if (preg_match_all('/\[([^\]]*)\]/', $strLine, $aSections) > 0) {
            $strSection = $aSections[1][0];
        }
        return $strSection;
    }
    
    /**
     * Add section to the config array.
     * @param string $strSection
     * @param array $aSection
     */
    protected function addSection(?string $strSection, ?array $aSection) : void
    {
        if ($strSection !== null && $aSection !== null) {
            $this->aConfig[$strSection] = $aSection;
        }
    }
}
