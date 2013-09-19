<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2008-2012 Isotope eCommerce Workgroup
 *
 * @package    Isotope
 * @link       http://www.isotopeecommerce.com
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Isotope\Model\Gallery;


/**
 * Class ZoomGallery
 *
 * @copyright  Isotope eCommerce Workgroup 2009-2012
 * @author     Andreas Schempp <andreas.schempp@terminal42.ch>
 * @author     Kamil Kuźmiński <kamil.kuzminski@gmail.com>
 */
class Zoom extends Inline
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'iso_gallery_zoom';


    /**
     * Generate gallery
     * @param string
     * @param integer
     * @param boolean
     */
    public function generateGallery($intSkip=0, $blnForce=false)
    {
        // Include scripts and styles
        $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/isotope/assets/zoomgallery' . (ISO_DEBUG ? '' : '.min') . '.js';
        $GLOBALS['TL_CSS'][] = 'system/modules/isotope/assets/zoomgallery' . (ISO_DEBUG ? '' : '.min') . '.css';

        return parent::generateGallery($intSkip, $blnForce);
    }


    /**
     * Add large image size to template
     * @param   object
     * @param   string
     * @param   array
     * @return  string
     */
    protected function addImageToTemplate(\Isotope\Template $objTemplate, $strType, array $arrFile)
    {
        parent::addImageToTemplate($objTemplate, $strType, $arrFile);

        $objTemplate->large = $arrFile['lightbox'];
    }
}
