<?php

class SSGuru_SiteTree extends SiteTreeExtension
{
    public static $icon = 'silverstripe-gdm-extensions/assets/images/sitetree-images/page.png';
    private $menuChildren;

    public function MenuChildren()
    {
        if (!$this->menuChildren) {
            $this->menuChildren = $this->owner->Children()->filter('ShowInMenus',
                                                                   true);
        }
        return $this->menuChildren;
    }
}