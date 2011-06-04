<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Claus Due <claus@wildside.dk>, Wildside A/S
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
***************************************************************/

/**
 * ExtJS integration service
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_Fed_Utility_ExtJS implements t3lib_Singleton {

	/**
	 * @var Tx_Fed_Utility_DomainObjectInfo;
	 */
	protected $infoService;

	/**
	 * @var Tx_Fed_ExtJS_ModelGenerator
	 */
	protected $modelGenerator;

	/**
	 * @param Tx_Fed_Utility_DomainObjectInfo $infoService
	 */
	public function injectInfoService(Tx_Fed_Utility_DomainObjectInfo $infoService) {
		$this->infoService = $infoService;
	}

	/**
	 * @param Tx_Fed_ExtJS_ModelGeneratpr
	 */
	public function injectModelGenerator(Tx_Fed_ExtJS_ModelGenerator $modelGenerator) {
		$this->modelGenerator = $modelGenerator;
	}

	/**
	 * Exposes one or mode ModelObjects as ExtJS Model classes in Javascript
	 *
	 * @param mixed $object ModelObject to expose to ExtJS
	 * @return string
	 */
	public function expose($object, $typeNum, $properties=NULL, $prefix) {
		$this->modelGenerator->setTypeNum($typeNum);
		$this->modelGenerator->setPrefix($prefix);
		return $this->modelGenerator->generateModelClass($object, $properties);
	}

	/**
	 * Maps data from ExtJS unto a DomainObject - recursively. Sets proper types
	 * of data based on the source code annotations and uses proper setters to
	 * set values. The result can be updated or added using the corresponding
	 * Repository
	 * @param Tx_Extbase_DomainObject_AbstractDomainEntity $object
	 * @param object $data
	 * @return Tx_Extbase_DomainObject_AbstractDomainEntity
	 */
	public function mapDataFromExtJS($object, $data) {
		#$getters =
		return $object;
	}

	/**
	 * Maps data onto an stdClass object - recursively - based on the ExtJS source
	 * annotations.
	 *
	 * @param Tx_Extbase_DomainObject_AbstractDomainEntity $object
	 * @return stdClass
	 */
	public function exportDataToExtJS($object) {
		$data = $this->infoService->getValuesByAnnotation($object, 'ExtJS');
		return $data;
	}

}

?>
