<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Claus Due <claus@wildside.dk>, Wildside A/S
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 *
 *
 * @author Claus Due, Wildside A/S
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @package Fed
 * @subpackage ViewHelpers/Fce
 */
class Tx_Fed_ViewHelpers_Fce_GridViewHelper extends Tx_Fed_Core_ViewHelper_AbstractFceViewHelper {

	public function render() {

		// intitialize an empty grid container
		$grid = array('rows' => array());
		$this->templateVariableContainer->add('grid', $grid);

		// renderChildren fills grid configuration
		$this->renderChildren();
		$grid = $this->templateVariableContainer->get('grid');

		#var_dump($grid);

		// completed grid config is added to storage
		$storage = $this->getStorage();
		if (is_array($storage['grids']) === FALSE) {
			$storage['grids'] = array();
		}
		array_push($storage['grids'], $grid);
		$this->setStorage($storage);

		// cleanup
		$this->templateVariableContainer->remove('grid');
	}

}

?>