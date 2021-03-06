<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2014 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @package    Isotope
 * @link       http://isotopeecommerce.org
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

namespace Isotope\Interfaces;


/**
 * IsotopeGallery interface describes an Isotope gallery object
 */
interface IsotopeGallery
{

    /**
     * Generate main image and return it as HTML string
     * @param string
     * @return string
     */
    public function generateMainImage();

    /**
     * Generate gallery and return it as HTML string
     * @param string
     * @param integer
     * @return string
     */
    public function generateGallery($intSkip = 1);
}
