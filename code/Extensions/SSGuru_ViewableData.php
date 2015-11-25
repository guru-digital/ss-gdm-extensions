<?php

/**
 * @property ViewableData $owner
 */
class SSGuru_ViewableData extends Extension {

    public function IsDev() {
        return Director::isDev();
    }

    public function IsTest() {
        return Director::isTest();
    }

    public function IsLive() {
        return Director::isLive();
    }

    public function getCSSClass() {
        return strtolower(preg_replace("/([a-z]+)([A-Z])/", "$1-$2", $this->owner->class));
    }

}
