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
*  the Free Software Foundation; either version 3 of the License, or
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
***************************************************************/

/**
 * Dynamic FlexForm insertion hook class
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @package Fed
 * @subpackage Backend
 */
class Tx_Fed_Backend_DynamicFlexForm {

	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var Tx_Fed_Domain_Repository_FceRepository
	 */
	protected $fceRepository;

	/**
	 * @var Tx_Fed_Backend_FCEParser
	 */
	protected $fceParser;

	/**
	 * CONSTRUCTOR
	 */
	public function __construct() {
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$this->fceRepository = $this->objectManager->get('Tx_Fed_Domain_Repository_FceRepository');
		$this->fceParser = $this->objectManager->get('Tx_Fed_Backend_FCEParser');
	}

	public function getFlexFormDS_postProcessDS(&$dataStructArray, $conf, &$row, $table, $fieldName) {
		if ($row['CType'] == 'fed_template') {
			$flexForm = t3lib_extMgm::extPath('fed', '/Configuration/FlexForms/Template.xml');
			$file = file_get_contents($flexForm);
			$dataStructArray = t3lib_div::xml2array($file);
		} else if ($row['CType'] == 'fed_datasource') {
			$flexForm = t3lib_extMgm::extPath('fed', '/Configuration/FlexForms/DataSource.xml');
			$file = file_get_contents($flexForm);
			$dataStructArray = t3lib_div::xml2array($file);
		} else if ($row['CType'] == 'fed_fce') {
			$uid = $row['tx_fed_fceuid'];
			if ($uid < 1) {
				return;
			}
			$fce = $this->fceRepository->findByUid($uid);
			$templateFile = $fce->getFilename();
			$config = $this->fceParser->getFceDefinitionFromTemplate(PATH_site . $templateFile);
				$flexformTemplateFile = t3lib_extMgm::extPath('fed', 'Resources/Private/Templates/FlexibleContentElement/AutoFlexForm.xml');
			$template = $this->objectManager->get('Tx_Fluid_View_StandaloneView');
			$template->setTemplatePathAndFilename($flexformTemplateFile);
			$template->assign('fce', $config);
			$flexformXml = $template->render();
			$dataStructArray = t3lib_div::xml2array($flexformXml);
		}
	}

}


?>