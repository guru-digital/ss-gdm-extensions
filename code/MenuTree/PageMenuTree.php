<?php

class PageMenuTree extends ViewableData implements ArrayAccess
{
    /**
     *
     * @var PageMenuTree
     */
    private static $instance;

    /**
     * @return PageMenuTree
     */
    public static function Instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     *
     * @var ArrayList
     */
    private $list = array();

    /**
     *
     * @var ArrayList
     */
    private $nodeList = array();

    public function __construct()
    {
        $this->getList();
        $this->getTree();
    }

    /**
     *

     * @return collection
     */
    public function getList()
    {
        if (!$this->nodeList) {
            $this->nodeList = $this->getRows();
        }

        return $this->nodeList;
    }

    /**
     *

     * @return collection
     */
    public function getTree()
    {

        if (!$this->list) {
            $result     = array();
            $this->getList();
            $this->list = new PageTreeItemList();
            foreach ($this->nodeList as $nodeId => &$node) {
                /* @var $node PageTreeItem */
                if (!$node->ParentID) {// || !array_key_exists($node->ParentID, $nodeList)) {
                    $result[$nodeId] = &$node;
                } else if (isset($this->nodeList[$node->ParentID]) && !isset($this->nodeList[$node->ParentID]->Children[$node->ID])) {
                    $node->Parent = &$this->nodeList[$node->ParentID];
                    $this->nodeList[$node->ParentID]->Children->AddByReference($node);
                }
            }
            $this->list = new PageTreeItemList($result);
        }

        return $this->list;
    }

    /**
     *
     * @return PageTreeItem[]
     */
    public function getRows()
    {
        $sqlQuery = new SQLQuery();
        $sqlQuery->setFrom('SiteTree_Live');
        $sqlQuery->setSelect(array('ID', 'URLSegment', 'Title', 'MenuTitle', 'ShowInMenus', 'ParentID'));
        $sqlQuery->setOrderBy("Sort");
        $sqlQuery->setWhere("ShowInMenus = 1");
        $result   = array();
        foreach ($sqlQuery->execute() as $row) {
            /* @var $menuItem PageTreeItem */
            $result[$row["ID"]] = Injector::inst()->create("PageTreeItem", $row);
        }
        return $result;
    }

    public function offsetExists($offset)
    {
        return isset($this->nodeList[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->nodeList[$offset];
    }

    public function offsetSet($offset, $value)
    {
        return $this->nodeList[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->nodeList[$offset]);
    }

    public function byID($id)
    {

        return isset($this->nodeList[$id]) ? $this->nodeList[$id] : null;
    }

    public function ForTemplate()
    {
        $menu  = '<ul class="nav navbar-nav">';
        $nodes = $this->getTree();
        foreach ($nodes as $node) {
            $menu .= $this->MenuItemFromNodes($node);
        }
        $menu .= "</ul>";
        $resule = new HTMLText();
        $resule->setValue($menu);
        return $resule;
    }

    public function MenuItemFromNodes(PageTreeItem $item)
    {
        $cssClasses   = array();
        $cssClasses[] = $item->LinkingMode();

        if (in_array($item->LinkingMode(), array("current", "section"))) {
            $cssClasses[] = "active";
        }

        $hasChildren = $item->Children->count() > 0;
        $hasParent   = $item->Parent !== null;
        if ($hasChildren) {
            if ($hasParent) {
                $cssClasses[] = "dropdown-submenu";
            } else {
                $cssClasses[] = "dropdown";
            }
        }
        $attr = array(
            "id"    => "dropdown-".$item->ID,
            "class" => implode(" ", $cssClasses)
        );
        $res  = '<li '.implode(' ',
                               array_map(
                    function ($k, $v) {
                    return $k.'="'.$v.'"';
                }, array_keys($attr), array_values($attr))).'>';
        $res .='<a href="'.$item->Link().'" title='.htmlentities($item->Title).'>'.htmlentities($item->MenuTitle);
        if ($hasChildren) {
            $res .= '<span class="caret" data-toggle="dropdown" data-target="#dropdown-'.$item->ID.'" aria-expanded="false"><i></i></span>';
        }
        $res .= '</a>';

        if ($hasChildren) {
            $res .= '<ul class="dropdown-menu" role="menu">';
            foreach ($item->Children as $child) {
                $res .= $this->MenuItemFromNodes($child);
            }
            $res .= "</ul>";
        }
        $res .= "</li>";
        return $res;
    }
}