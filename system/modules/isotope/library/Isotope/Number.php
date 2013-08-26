<?php
/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2013 Isotope eCommerce Workgroup
 *
 * @package    Isotope
 * @link       http://www.isotopeecommerce.com
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Isotope;

/**
 * This class is inspired by the Money library of Mathias Verraes
 */
class Number
{
    /**
     * The amount in integer representation
     * @var int
     */
    private $intAmount;

    /**
     * Create a Number instance
     * @param   integer The amount in representation to support 4 floating points
     * @throws \InvalidArgumentException
     */
    public function __construct($intAmount)
    {
        if (!is_int($intAmount)) {
            throw new \InvalidArgumentException("The first parameter of Number must be an integer.");
        }

        $this->intAmount = $intAmount;
    }

    /**
     * Gets the amount
     * @return  int
     */
    public function getAmount()
    {
        return $this->intAmount;
    }

    /**
     * Adds up another Number instance
     * @param   Number
     * @return  Number
     */
    public function add(Number $objToAdd)
    {
        return new self($this->getAmount() + $objToAdd->getAmount());
    }

    /**
     * Subtracts another Number instance
     * @param   Number
     * @return  Number
     */
    public function subtract(Number $objToSubstract)
    {
        return new self($this->getAmount() - $objToSubstract->getAmount());
    }

    /**
     * Multiplies with another Number instance
     * @param   Number
     * @return  Number
     */
    public function multiply(Number $objToMultiplyWith)
    {
        return new self((int) $this->getAmount() * $objToMultiplyWith->getAmount() / 10000);
    }


    /**
     * Divides by another Number instance
     * @param   Number
     * @return  Number
     */
    public function divide(Number $objToDivideBy)
    {
        return new self((int) (($this->getAmount() * 10000) / $objToDivideBy->getAmount()));
    }

    /**
     * Check if two Number instances are equal
     *
     * @param   Number
     * @return  boolean
     */
    public function equals(Number $objToCompare)
    {
        return $this->getAmount() === $objToCompare->getAmount();
    }

    /**
     * Check if greater than another Number instance
     * @param   Number
     * @return  boolean
     */
    public function greaterThan(Number $objToCompare)
    {
        return $this->getAmount() > $objToCompare->getAmount();
    }

    /**
     * Check if less than another Number instance
     * @param   Number
     * @return  boolean
     */
    public function lessThan(Numberv $objToCompare)
    {
        return $this->getAmount() < $objToCompare->getAmount();
    }

    /**
     * Check if zero
     * @return  boolean
     */
    public function isZero()
    {
        return $this->getAmount() === 0;
    }

    /**
     * Check if positive
     * @return  boolean
     */
    public function isPositive()
    {
        return $this->getAmount() > 0;
    }

    /**
     * Check if negative
     * @return  boolean
     */
    public function isNegative()
    {
        return $this->getAmount() < 0;
    }

    /**
     * Get the float value
     * @return float
     */
    public function getAsFloat()
    {
        return (float) $this->__toString();
    }

    /**
     * Echoes the correct value
     * @return  string
     */
    public function __toString()
    {
        return (string) substr($this->getAmount(), 0, -4) . '.' . substr($this->getAmount(), -4);
    }

    /**
     * Create Number instance from PHP value
     * @param   mixed
     * @return  Number
     * @throws  \InvalidArgumentException
     */
    public static function create($varInput)
    {
        if (is_float($varInput) || is_int($varInput)) {
            $varInput = (string) $varInput;
        }

        if (!is_string($varInput)) {
            throw new \InvalidArgumentException('Input must be float or integer or string.');
        }

        if (preg_match('/(.+?)([.,](\d+))?$/', $varInput, $arrMatches) === false) {
            throw new \InvalidArgumentException('Input is not a valid number representation.');
        }

        $strValue = str_replace(array('.', ',', '\''), '', $arrMatches[1]);
        $strDecimals = $arrMatches[3];

        if (!is_numeric($strValue)) {
            throw new \InvalidArgumentException('Input is not a valid number representation.');
        }

        return new static((int) ($strValue . str_pad(substr($strDecimals, 0, 4), 4, '0', STR_PAD_RIGHT)));
    }
}