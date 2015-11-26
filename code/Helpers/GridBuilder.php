<?php

class GridBuilder {

	private $gridConfig;

	function getGridConfig() {
		return $this->gridConfig;
	}

	function setGridConfig($gridConfig) {
		$this->gridConfig = $gridConfig;
		return $this;
	}

	// Make constructor private to for creation via on of the static create* methods
	private function __construct() {
		
	}

	/**
	 * Create a grid builder with a default GridFieldConfig
	 * @return \self
	 */
	static public function create() {
		$result				 = new self();
		$result->gridConfig	 = GridFieldConfig::create();
		return $result;
	}

	/**
	 * Create a grid builder with a default GridFieldConfig_RelationEditor
	 * 
	 * <p>
	 * Allows to search for existing records to add to the relationship, detach 
	 * listed records from the relationship (rather than removing them from the 
	 * database), and automatically add newly created records to it.
	 * </p>
	 * 
	 * @return \self
	 */
	static public function createRelation() {
		$result				 = new self();
		$result->gridConfig	 = GridFieldConfig_RelationEditor::create()
				->addComponent(new GridFieldAddExistingSearchButton())
				->removeComponentsByType('GridFieldAddExistingAutocompleter');
		return $result;
	}

	/**
	 * Create a grid builder with a default GridFieldConfig_RelationEditor
	 * 
	 * <p>
	 * Allows drag and drop sorting of grid rows
	 * </p>
	 * 
	 * <p>
	 * Allows to search for existing records to add to the relationship, detach 
	 * listed records from the relationship (rather than removing them from the 
	 * database), and automatically add newly created records to it.
	 * </p>
	 * 
	 * @return \self
	 */
	static public function createRelationSortableGrid($sortField = "Sort") {
		$result				 = self::createRelation();
		$result->gridConfig
				->addComponent(GridFieldOrderableRows::create($sortField));
		return $result;
	}

	/**
	 * Enables bulk uploaded of files and images
	 * @param string $fileRelationName The relation name in the model to attach uploaded files to
	 * @param string $folderName Folder path to upload files to
	 * @return \GridBuilder
	 */
	public function addBulkUploader($fileRelationName = null, $folderName = null) {
		$gridFieldBulkUpload = Injector::inst()->create("GridFieldBulkUpload", $fileRelationName);
		if ($folderName) {
			$gridFieldBulkUpload->setUfSetup("setFolderName", $folderName);
		}
		$this->gridConfig->addComponent($gridFieldBulkUpload);
		return $this;
	}

	/**
	 * <p>
	 * Returns a new GridField instance preconfigured with options chosen from the GridConfigBuilder.
	 * </p>
	 * 
	 * @param string $name
	 * @param string $title
	 * @param SS_List $dataList
	 * @return GridField
	 */
	public function getGrid($name, $title = null, SS_List $dataList = null) {
		return GridField::create($name, $title, $dataList, $this->gridConfig);
	}

}
