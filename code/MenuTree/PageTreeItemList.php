<?php

class PageTreeItemList extends ArrayList
{

    public function AddByReference(&$item)
    {
        $this->items[$item->ID] = & $item;
    }
}