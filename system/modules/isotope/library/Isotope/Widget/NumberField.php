<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2012 Isotope eCommerce Workgroup
 *
 * @package    Isotope
 * @link       http://www.isotopeecommerce.com
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Isotope\Widget;
use Isotope\Number;


/**
 * Class NumberField
 *
 * Provide methods to handle Number input.
 * @copyright  Isotope eCommerce Workgroup 2009-2012
 * @author     Yanick Witschi <yanick.witschi@terminal42.ch>
 */
class NumberField extends \TextField
{

    /**
     * Make sure we have the correct value
     * @param string
     * @param mixed
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'value':
                $this->varValue = Number::create($varValue);
            break;
        }

        parent::__set($strKey, $varValue);
    }


    /**
     * Validate input and set value
     * @param mixed
     * @return mixed
     */
    public function validator($varInput)
    {
        try {
            $varInput = Number::create($varInput)->getAmount();
        } catch(\InvalidArgumentException $e) {
            $this->addError($GLOBALS['TL_LANG']['ERR']['numberInputNotAllowed']);
        }

        return parent::validator($varInput);
    }
}
