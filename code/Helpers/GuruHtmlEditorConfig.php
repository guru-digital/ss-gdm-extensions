<?php

class GuruHtmlEditorConfig extends HtmlEditorConfig
{

    /**
     * Clones the HtmlEditorConfig named $toClone to a new config calles $newName.
     * Returns an instance of the newly cloned config
     * 
     * @param string $toClone
     * @param string  $newName
     * @return HtmlEditorField
     */
    public static function cloneConfig($toClone, $newName)
    {
        $refProperty       = new \ReflectionProperty('HtmlEditorConfig', 'configs'); // = $refObject->getProperty('configs');
        $refProperty->setAccessible(true);
        $configs           = $refProperty->getValue();
        $configs[$newName] = clone HtmlEditorConfig::get($toClone);
        $refProperty->setValue(null, $configs);
        $refProperty->setAccessible(false);
        return HtmlEditorConfig::get($newName);
    }
}