
<?php

/**
 * @property int $ID
 * @property string $URLSegment
 * @property string $Title
 * @property string $MenuTitle
 * @property bool $ShowInMenus
 * @property int $Sort
 * @property string $CanViewType
 * @property int $ParentID
 */
class PageTreeItem extends Page implements HiddenClass
{
    private static $ancestorIDCache = array();

    /**
     *
     * @var MenuItem
     */
    public $Parent = null;

    /**
     *
     * @var ArrayList|MenuItem[]
     */
    public $Children = array();

    public function __construct($record = null, $isSingleton = false, $model = null)
    {
        parent::__construct($record, $isSingleton, $model);
        $this->Children = new PageTreeItemList();
    }

    public function getChildren()
    {

        return $this->Children;
    }

    public function getChildNodes()
    {
        return $this->Children;
    }

    public function getParent()
    {
        return $this->Parent;
    }

    public function isOrphaned()
    {
        return $this->Parent == null;
    }

    public function getAncestorIDs()
    {
        if (!isset(static::$ancestorIDCache[$this->ID])) {
            static::$ancestorIDCache[$this->ID] = array();
            $object                             = $this;
            while ($object                             = $object->Parent) {
                static::$ancestorIDCache[$this->ID][] = $object->ID;
            }
        }
        return static::$ancestorIDCache[$this->ID];
    }

    public function isSection()
    {
        $isSection       = $this->isCurrent();
        $currentPage     = Director::get_current_page();
        $menuTree        = PageMenuTree::Instance();
        /* @var $currentMenuItems PageTreeItem */
        $currentMenuItem = $menuTree->byID($currentPage->ID);
        if (!$isSection && $currentMenuItem) {
            $currentAncestors = $currentMenuItem->getAncestorIDs();
            $isSection        = in_array($this->ID, $currentAncestors);
        }
        return $isSection;
    }

    public function Parent()
    {
    return $this->Parent;





    }
}