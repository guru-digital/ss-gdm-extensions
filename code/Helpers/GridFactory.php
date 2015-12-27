<?php

class GridFactory
{

    /**
     * <p>
     * Returns a new GridField instance preconfigured with GridFieldConfig_RelationEditor and GridFieldAddExistingSearchButton.
     * </p>
     * <p>
     * Allows to search for existing records to add to the relationship, detach
     * listed records from the relationship (rather than removing them from the
     * database), and automatically add newly created records to it.
     * </p>
     *
     * @param string $name
     * @param string $title
     * @param SS_List $dataList
     * @param GridFieldConfig $gridFieldConfig
     * @return GridField
     */
    public static function RelationGrid($name, $title = null, SS_List $dataList = null)
    {
        return GridBuilder::createRelation()->getGrid($name, $title, $dataList);
    }

    /**
     * <p>
     * Returns a new GridField instance preconfigured with GridFieldConfig_RelationEdito,  GridFieldAddExistingSearchButton and GridFieldOrderableRows.
     * </p>
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
     * @param string $name
     * @param string $title
     * @param SS_List $dataList
     * @param String $sortField The field to order by
     * @param GridFieldConfig $gridFieldConfig
     * @return GridField
     */
    public static function RelationSortableGrid($name, $title = null, SS_List $dataList = null, $sortField = "Sort")
    {
        return GridBuilder::createRelationSortableGrid($sortField)->getGrid($name, $title, $dataList);
    }

    /**
     * <p>
     * Returns a new GridField instance preconfigured with GridFieldConfig_RelationEditon,  GridFieldAddExistingSearchButton and GridFieldOrderableRows.
     * </p>
     *
     * <p>
     * Allows to search for existing records to add to the relationship, detach
     * listed records from the relationship (rather than removing them from the
     * database), and automatically add newly created records to it.
     * </p>
     *
     * @param string $name
     * @param string $title
     * @param SS_List $dataList
     * @return GridField
     */
    public static function RelationBulkUploadGrid($name, $title = null, SS_List $dataList = null, $fileRelationName = null, $folderName = null)
    {
        return GridBuilder::createRelation()->addBulkUploader($fileRelationName, $folderName)->getGrid($name, $title, $dataList);
    }

    /**
     * <p>
     * Returns a new GridField instance preconfigured with GridFieldConfig_RelationEditon,  GridFieldAddExistingSearchButton and GridFieldOrderableRows.
     * </p>
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
     * @param string $name
     * @param string $title
     * @param SS_List $dataList
     * @param String $sortField The field to order by
     * @param String $fileRelationName
     * @param String $folderName
     * @return GridField
     */
    public static function RelationSortableBulkUploadGrid($name, $title = null, SS_List $dataList = null, $sortField = "Sort", $fileRelationName = null, $folderName = null)
    {
        return GridBuilder::createRelationSortableGrid($sortField)->addBulkUploader($fileRelationName, $folderName)->getGrid($name, $title, $dataList);
    }
}
