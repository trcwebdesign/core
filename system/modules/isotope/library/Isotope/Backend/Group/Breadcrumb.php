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

namespace Isotope\Backend\Group;

use Isotope\Model\Group;


class Breadcrumb extends \Backend
{

    /**
     * Generate groups breadcrumb and return it as HTML string
     * @param   string
     * @return  string
     */
    public static function generate($getNode=null, $setNode=null, $filterNode=null)
    {
        $getNode = $getNode ?: function() {
            return \Session::getInstance()->get('tl_iso_group_node');
        };

        $setNode = $setNode ?: function($intNode) {
            \Session::getInstance()->set('tl_iso_group_node', $intNode);
        };

        $filterNode = $filterNode ?: function($intNode) {
            $GLOBALS['TL_DCA']['tl_iso_group']['list']['sorting']['root'] = array($intNode);
        };


		// Set a new node
		if (isset($_GET['node'])) {
			$setNode(\Input::get('node'));
			\Controller::redirect(preg_replace('/&node=[^&]*/', '', \Environment::get('request')));
		}

		$intNode = $getNode();

		if ($intNode < 1) {
			return '';
		}

		$arrIds   = array();
		$arrLinks = array();
		$objUser  = \BackendUser::getInstance();

		// Generate breadcrumb trail
		if ($intNode) {

			$intId = $intNode;
			$objDatabase = \Database::getInstance();

			do {
				$objGroup = $objDatabase->prepare("SELECT * FROM tl_iso_group WHERE id=?")
									    ->limit(1)
									    ->execute($intId);

				if ($objGroup->numRows < 1) {
					// Currently selected group does not exits
					if ($intId == $intNode) {
						$setNode(0);
						return '';
					}

					break;
				}

				$arrIds[] = $intId;

				// No link for the active group
				if ($objGroup->id == $intNode) {
					$arrLinks[] = '<img src="system/modules/isotope/assets/images/folder-network.png" width="16" height="16" alt="" style="padding:1px 0">' . ' ' . $objGroup->name;
				} else {
					$arrLinks[] = '<img src="system/modules/isotope/assets/images/folder-network.png" width="16" height="16" alt="" style="padding:1px 0"> <a href="' . \Controller::addToUrl('node='.$objGroup->id) . '" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['selectNode']).'">' . $objGroup->name . '</a>';
				}

				// Do not show the mounted groups
				if (!$objUser->isAdmin && $objUser->hasAccess($objGroup->id, 'iso_groups')) {
					break;
				}

				$intId = $objGroup->pid;

			} while ($intId > 0);
		}

		// Check whether the node is mounted
		if (!$objUser->isAdmin && !$objUser->hasAccess($arrIds, 'iso_groups')) {
			$setNode(0);

			\System::log('Group ID '.$intNode.' was not mounted', __METHOD__, TL_ERROR);
			\Controller::redirect('contao/main.php?act=error');
		}

		// Limit tree
		$filterNode($intNode);

		// Add root link
		$arrLinks[] = '<img src="system/modules/isotope/assets/images/folders.png" width="16" height="16" alt="" style="padding:1px 0"> <a href="' . \Controller::addToUrl('node=0') . '" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['selectAllNodes']).'">' . $GLOBALS['TL_LANG']['MSC']['filterAll'] . '</a>';
		$arrLinks = array_reverse($arrLinks);

		return '

<ul id="tl_breadcrumb">
  <li>' . implode(' &gt; </li><li>', $arrLinks) . '</li>
</ul>';
    }
}
