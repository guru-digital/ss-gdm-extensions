<?php

class SSGuru_PageUtilities extends DataExtension
{

    private $forceLeft  = false;
    private $forceRight = false;

    // Get name - will be wrapped in anchor HTML if $linkl isset
    public function GetNamedLink($name, $link, $target = null)
    {
        $result = '';
        if (strlen($name) != 0) {
            $result = $name;
            if (strlen($link) != 0) {
                $result = "<a href=\"" . $link . "\"" . (is_null($target) ? "" : " target=\"" . $target . "\"") . ">" . $result . "</a>";
            }
        }
        return $result;
    }

    public function setHasLeft($value)
    {
        $this->forceLeft = $value;
    }

    public function setHasRight($value)
    {
        $this->forceRight = $value;
    }

    public function GetHasSide($side)
    {
        $widgetArea = null;
        $result     = false;
        if ($this->forceLeft && (strtolower($side) == "left")) {
            $result = true;
        } elseif ($this->forceRight && (strtolower($side) == "right")) {
            $result = true;
        } elseif ($this->owner->hasExtension("WidgetPage")) {
            if (strtolower($side) == "right") {
                $widgetArea = $this->owner->WidgetArea("RightSideBar");
            } elseif (strtolower($side) == "left") {
                $widgetArea = $this->owner->WidgetArea("LeftSideBar");
            }
            $result = $widgetArea && $widgetArea->exists();
        }
        return $result;
    }

    public function GetLeftCssClass()
    {
        $cssClass = "side left";
        if ($this->GetHasSide("right")) {
            $cssClass .= " has-right";
        }
        return $cssClass;
    }

    public function GetCenterCssClass()
    {
        $cssClass = "center";
        if ($this->GetHasSide("right")) {
            $cssClass .= " has-right";
        }
        if ($this->GetHasSide("left")) {
            $cssClass .= " has-left";
        }
        return $cssClass;
    }

    public function GetRightCssClass()
    {
        $cssClass = "side right";
        if ($this->GetHasSide("left")) {
            $cssClass .= " has-left";
        }
        return $cssClass;
    }

    public function getAssetFolder($subfolder = "")
    {
        return $this->SanitizePath($this->owner->MenuTitle . "/" . $subfolder);
    }

    public function ImageFolder($subfolder = "")
    {
        return $this->getAssetFolder($subfolder);
    }

    private function SanitizePath($string)
    {
        // Make path lower case and replace back slashes with forward slashes
        $result  = strtolower(str_replace("\\", '/', $string));
        $dash    = preg_quote("-");
        $search  = array(
            // Remove duplicate slashes
            "@/+@",
            // Remove non alpha numeric characters ( except forward slashes )
            "@[^a-z0-9/]@i",
            // Remove duplicate dashes
            "@${dash}+@",
            // Replace instances of -/ or /- with /
            "@${dash}/|/${dash}@"
        );
        $replace = array(
            "/",
            "-",
            "-",
            "/"
        );
        //Trim any forward slashes or dashes from the start/end
        return trim(preg_replace($search, $replace, $result), "/-");
    }

    public function FindChildrenOfType($objectType, $all = false, $limit = null)
    {
        $result   = new ArrayList();
        $children = $all ? $this->owner->AllChildren() : $this->owner->Children();
        foreach ($children as $child) {
            if (!is_null($limit) && $result->count() >= $limit) {
                break;
            }
            if ($child->ClassName == $objectType) {
                $result->add($child);
            }
            if ($child->hasMethod('FindChildrenOfType')) {
                $result->merge($child->FindChildrenOfType($objectType, $all, is_null($limit) ? null : $limit - $result->count()));
            }
        }
        return $result;
    }

    public function GetAllChildrenOfType($objectType, $limit = null)
    {
        return $this->FindChildrenOfType($objectType, true, $limit);
    }

    public function GetChildrenOfType($objectType, $limit = null)
    {
        return $this->FindChildrenOfType($objectType, false, $limit);
    }

    public function GetFirstParentOfType($objectType)
    {
        $parent = $this->owner->Parent();
        while ($parent->ClassName !== $objectType && $parent->ParentID !== 0 && $parent->exists()) {
            $parent = $parent->Parent();
        }
        return $parent->ClassName === $objectType ? $parent : false;
    }
}
