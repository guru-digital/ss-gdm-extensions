<?php

/**
 * @property Controller $owner
 */
class SSGuru_Controller extends Extension
{

    public function onBeforeInit()
    {
        SSGuru_Requirements_Backend::enable();
    }

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

    /**
     * This function will return the string 'dev', 'test' or 'live' depending on the current site mode
     * Can also be checked with {@link Director::get_environment_type()}.
     *
     * @return string 'dev', 'test' or 'live'
     */
    public function getSiteMode()
    {
        return Director::get_environment_type();
    }
}