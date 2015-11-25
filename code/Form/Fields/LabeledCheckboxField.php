<?php

class LabeledCheckboxField extends CompositeField {

	/**
	 *
	 * @var LabelField
	 */
	protected $labelField;

	/**
	 *
	 * @var CheckboxField
	 */
	protected $checkboxField;

	public function getLabelField() {
		return $this->labelField;
	}

	public function getCheckboxField() {
		return $this->checkboxField;
	}

	public function setLabelField(LabelField $labelField) {
		$this->labelField = $labelField;
		return $this;
	}

	public function setCheckboxField(CheckboxField $checkboxField) {
		$this->checkboxField = $checkboxField;
		return $this;
	}

	public function __construct($name, $title = null, $value = null) {
		$this->labelField	 = LabelField::create($name . "Label", self::name_to_label($name))->addExtraClass("left");
		$this->checkboxField = CheckboxField::create($name, "", $value);
		$this->labelField->setTemplate("LabeledCheckboxLabelField");
		$this->addExtraClass("field");
		parent::__construct(array(
			$this->labelField,
			$this->checkboxField
		));
	}

	public function FieldHolder($properties = array()) {
		$this->labelField->setAttribute("for", $this->checkboxField->ID());
		return parent::FieldHolder($properties);
	}

	public function forTemplate() {
		$this->labelField->setAttribute("for", $this->checkboxField->ID());
		return parent::forTemplate();
	}

	public function setForm($form) {
		$result = parent::setForm($form);
		$this->labelField->setAttribute("for", $this->checkboxField->ID());
		return $result;
	}

	public function setCheckboxDescription($description) {
		$this->checkboxField->setDescription($description);
		return $this;
	}

}
