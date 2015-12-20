<?php

/**
 * @property ViewableData $owner
 */
class SSGuru_ViewableData extends Extension
{

    public function getCSSClass()
    {
        return strtolower(preg_replace("/([a-z]+)([A-Z])/", "$1-$2", $this->owner->class));
    }
}
