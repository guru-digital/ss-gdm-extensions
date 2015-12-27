<?php

/**
 * @property Controller $owner
 */
class SSGuru_Controller extends Extension
{

    /**
     * This function will return true if the current controller .
     * For information about environment types, see {@link Director::set_environment_type()}.
     *
     * @return bool
     */
    public function IsCMS()
    {
        return $this->owner instanceof LeftAndMain;
    }

    /**
     * This function will return true if the site is in a development environment.
     * For information about environment types, see {@link Director::set_environment_type()}.
     *
     * @return bool
     */
    public function IsDev()
    {
        return Director::isDev();
    }

    /**
     * This function will return true if the site is in a test environment.
     * For information about environment types, see {@link Director::set_environment_type()}.
     *
     * @return bool
     */
    public function IsTest()
    {
        return Director::isTest();
    }

    /**
     * This function will return true if the site is in a live environment.
     * For information about environment types, see {@link Director::set_environment_type()}.
     *
     * @return bool
     */
    public function IsLive()
    {
        return Director::isLive();
    }
}