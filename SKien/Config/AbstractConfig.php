<?php
declare(strict_types=1);

namespace SKien\Config;

/**
 * Abstract base class for config components.
 *
 * #### History
 * - *2021-01-01*   initial version
 *
 * @package SKien/Config
 * @version 1.0.0
 * @author Stefanius <s.kien@online.de>
 * @copyright MIT License - see the LICENSE file for details
 */
abstract class AbstractConfig implements ConfigInterface
{
    /** @var array holding the config data    */
    protected ?array $aConfig = null;
    /** @var string format for date parameters     */
    protected string $strDateFormat = 'Y-m-d';
    /** @var string format for datetime parameters     */
    protected string $strDateTimeFormat = 'Y-m-d H:i';
    
    /**
     * Set the format for date parameters.
     * See the formatting options DateTime::createFromFormat. 
     * In most cases, the same letters as for the date() can be used. 
     * @param string $strFormat
     * @link https://www.php.net/manual/en/datetime.createfromformat.php
     */
    public function setDateFormat(string $strFormat) : void
    {
        $this->strDateFormat = $strFormat;
    }
    
    /**
     * Set the format for datetime parameters.
     * See the formatting options DateTime::createFromFormat. 
     * In most cases, the same letters as for the date() can be used. 
     * @param string $strFormat
     * @link https://www.php.net/manual/en/datetime.createfromformat.php
     */
    public function setDateTimeFormat(string $strFormat) : void
    {
        $this->strDateTimeFormat = $strFormat;
    }
    
    /**
     * Get the value specified by path.
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
        $iDepth = count($aPath);
        $value = null;
        $aValues = $this->aConfig;
        for ($i = 0; $i < $iDepth; $i++) {
            if (!is_array($aValues)) {
                $value = null;
                break;
            }
            $value = $aValues[$aPath[$i]] ?? null;
            if ($value === null) {
                break;
            }
            $aValues = $value;
        }
        return $value ?? $default;
    }
    
    /**
     * Get the string value specified by path.
     * @param string $strPath
     * @param string $strDefault
     * @return string
     */
    public function getString(string $strPath, string $strDefault = '') : string
    {
        return (string) $this->getValue($strPath, $strDefault);
    }
    
    /**
     * Get the integer value specified by path.
     * @param string $strPath
     * @param int $iDefault
     * @return int
     */
    public function getInt(string $strPath, int $iDefault = 0) : int
    {
        return intval($this->getValue($strPath, $iDefault));
    }
    
    /**
     * Get the integer value specified by path.
     * @param string $strPath
     * @param float $fltDefault
     * @return float
     */
    public function getFloat(string $strPath, float $fltDefault = 0.0) : float
    {
        return floatval($this->getValue($strPath, $fltDefault));
    }
    
    /**
     * Get the boolean value specified by path.
     * @param string $strPath
     * @param bool $bDefault
     * @return bool
     */
    public function getBool(string $strPath, bool $bDefault = false) : bool
    {
        $value = $this->getValue($strPath, $bDefault);
        if (!is_bool($value)) {
            $value = $this->boolFromString((string) $value, $bDefault);
        }
        return $value;
    }
    
    /**
     * Get the date value specified by path.
     * @param string $strPath
     * @param mixed $default default value (unix timestamp, DateTime object or date string)
     * @return int date as unix timestamp
     */
    public function getDate(string $strPath, $default = 0) : int
    {
        $date = (string) $this->getValue($strPath, $default);
        if (!ctype_digit($date)) {
            $dt = \DateTime::createFromFormat($this->strDateFormat, $date);
            $date = $default;
            if ($dt !== false) {
                $aError = $dt->getLastErrors();
                if ($aError['error_count'] == 0) {
                    $dt->setTime(0, 0);
                    $date = $dt->getTimestamp();
                }
            }
        } else {
            $date = intval($date);
        }
        return $date;
    }
    
    /**
     * Get the date and time value specified by path as unix timestamp.
     * @param string $strPath
     * @param int $default default value (unix timestamp)
     * @return int unix timestamp
     */
    public function getDateTime(string $strPath, $default = 0) : int
    {
        $date = (string) $this->getValue($strPath, $default);
        if (!ctype_digit($date)) {
            $dt = \DateTime::createFromFormat($this->strDateTimeFormat, $date);
            $date = $default;
            if ($dt !== false) {
                $aError = $dt->getLastErrors();
                if ($aError['error_count'] == 0) {
                    $date = $dt->getTimestamp();
                }
            }
        } else {
            $date = intval($date);
        }
        return $date;
    }
    
    /**
     * Get the array specified by path.
     * @param string $strPath
     * @param array $aDefault
     * @return array
     */
    public function getArray(string $strPath, array $aDefault = []) : array
    {
        $value = $this->getValue($strPath, $aDefault);
        return is_array($value) ? $value : $aDefault;
    }
    
    /**
     * Split the given path in its components.
     * @param string $strPath
     * @return array
     */
    protected function splitPath(string $strPath) : array
    {
        return explode('.', $strPath);
    }
    
    /**
     * Convert string to bool.
     * Accepted values are (case insensitiv): <ul>
     * <li> true, on, yes, 1 </li>
     * <li> false, off, no, none, 0 </li></ul>
     * for all other values the default value is returned!
     * @param string $strValue
     * @param bool $bDefault
     * @return bool
     */
    protected function boolFromString(string $strValue, bool $bDefault = false) : bool
    {
        if ($this->isTrue($strValue)) {
            return true;
        } else if ($this->isFalse($strValue)) {
            return false;
        } else {
            return $bDefault;
        }
    }
    
    /**
     * Checks whether the passed value is a valid expression for bool 'True'.
     * Accepted values for bool 'true' are (case insensitiv): <i>true, on, yes, 1</i>
     * @param string $strValue
     * @return bool
     */
    protected function isTrue(string $strValue) : bool
    {
        $strValue = strtolower($strValue);
        return in_array($strValue, ['true', 'on', 'yes', '1']);
    }
    
    /**
     * Checks whether the passed value is a valid expression for bool 'False'.
     * Accepted values for bool 'false' are (case insensitiv): <i>false, off, no, none, 0</i>
     * @param string $strValue
     * @return bool
     */
    protected function isFalse(string $strValue) : bool
    {
        $strValue = strtolower($strValue);
        return in_array($strValue, ['false', 'off', 'no', 'none', '0']);
    }
}