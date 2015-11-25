<?php

/**
 * @property Page $owner
 */
class SSGuru_CarouselPage extends DataExtension {

	static $has_many = array(
		'CarouselItems' => 'SSGuru_CarouselItem',
	);

	public function updateCMSFields(\FieldList $fields) {
		$fields->addFieldToTab('Root.Carousel', GridFactory::RelationSortableBulkUploadGrid('CarouselItems', 'Carousel', $this->owner->CarouselItems()->sort('Archived'), "SortID", "Image", $this->owner->ImageFolder("carousel")));
	}

}
