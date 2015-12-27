<?php

class UploadFieldFactory
{

    /**
     * Return a new UploadField instance, preconfiguger to only allow one image
     *
     * @param string $name The internal field name, passed to forms.
     * @param string $title The field label.
     * @param SS_List $items If no items are defined, the field will try to auto-detect an existing relation on
     *                       @link $record}, with the same name as the field name.
     * @param Form $form Reference to the container form
     */
    public static function SingleImage($name, $title = null, SS_List $dataList = null)
    {
        $field = UploadField::create($name, $title, $dataList)
                ->setAllowedFileCategories('image')
                ->setConfig('allowedMaxFileNumber', 1);
        return $field;
    }
}
