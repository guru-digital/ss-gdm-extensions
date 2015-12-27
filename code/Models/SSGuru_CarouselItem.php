<?php

/**
 * @property Varchar $Title
 * @property Text $Caption
 * @property Boolean $Archived
 * @property Int $SortID
 * @method Page Parent()
 * @method Image Image()
 * @method Link Link()
 * @method type methodName(type $paramName) Description
 */
class SSGuru_CarouselItem extends DataObject
{
    private static $singular_name = "Carousel Item";
    private static $plural_name   = "Carousel Items";
    public static $db             = array(
        'Title'    => 'Varchar(255)',
        'Caption'  => 'Text',
        'Archived' => 'Boolean',
        'SortID'   => 'Int'
    );
    public static $has_one        = array(
        'Parent' => 'Page',
        'Image'  => 'Image',
        'Link'   => 'Link'
    );
    public static $summary_fields = array(
        'ImageThumb'       => 'Image',
        'Title'            => 'Title',
        'Caption'          => 'Text',
        'Link.Title'       => 'Link',
        'ArchivedReadable' => 'Current Status'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->removeByName('SortID');

        $fields->removeByName('Archived');
        $fields->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Link'));
        $fields->addFieldToTab('Root.Main',
                               CompositeField::create(array(
                LabelField::create("LabelArchive", "Archive this carousel item?")->addExtraClass("left"),
                CheckboxField::create('Archived', '')
            ))->addExtraClass("field special")
        );
        $imageField = $fields->dataFieldByName('Image');
        if ($imageField) {
            $imageField->
                setAllowedFileCategories("image")->
                setAllowedMaxFileNumber(1);
            if ($this->Parent() && $this->Parent()->hasMethod("ImageFolder")) {
                $imageField->
                    setFolderName($this->Parent()->ImageFolder("carousel"));
            }
        }
        return $fields;
    }

    public function ImageThumb()
    {
        return $this->Image()->SetWidth(50);
    }

    public function ArchivedReadable()
    {
        return $this->Archived ? _t('GridField.Archived', 'Archived') : _t('GridField.Live',
                                                                           'Live');
    }
}