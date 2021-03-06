<?php

class SSGuru_Requirements_Backend extends Requirements_Backend
{

    public function combine_files($combinedFileName, $files, $media = null)
    {
        if (is_array($files)) {
            $result = array();
            foreach ($files as $file) {
                if (substr($combinedFileName, -3) == 'css') {
                    $result[] = $this->findRequirementFile($file, "css");
                } else if (substr($combinedFileName, -2) == 'js') {
                    $result[] = $this->findRequirementFile($file, "js");
                }
            }
            if ($result) {
                $files = $result;
            }
        }
        parent::combine_files($combinedFileName, $files, $media);
    }

    public function javascript($file)
    {
        return parent::javascript($this->findRequirementFile($file, "js"));
    }

    public function css($file, $media = null)
    {
        return parent::css($this->findRequirementFile($file, "css"), $media);
    }

    public function themedCSS($name, $module = null, $media = null)
    {
        return parent::themedCSS($name, $module, $media);
    }

    protected function isURL($fileOrUrl)
    {
        return preg_match('{^//|http[s]?}', $fileOrUrl);
    }

    protected function findRequirementFile($fileToFind, $ext)
    {
        $result = $fileToFind;
        if (!$this->isURL($result) && !Director::fileExists($result)) {
            $lookedIn   = array();
            $folderList = $this->getFolderList($ext);
            $fileList   = $this->getFileList($fileToFind, $ext);
            foreach ($folderList as $folder) {
                foreach ($fileList as $file) {
                    $lookedIn[] = $folder.'/'.$file;
                    if (Director::fileExists($folder.'/'.$file)) {
                        $result = $folder.'/'.$file;
                        break 2;
                    }
                }
            }
            if (!Director::fileExists($result) && Director::fileExists($result.".".$ext)) {
                $result     = $result.".".$ext;
                $lookedIn[] = $result;
            }

            if (Config::inst()->forClass(get_called_class())->get("WarnOnNotFound") && !Director::fileExists($result) && Director::isDev()) {
                Debug::message("Requirement file \"".$fileToFind."\" not found");
                $lookedIn[] = Director::getAbsFile($fileToFind);
                Debug::dump($lookedIn);
            }
        }
        return $result;
    }

    protected function getFileList($fileToFind, $ext)
    {
        $cleanExt  = ".".ltrim($ext, ".");
        $fileNoExt = preg_replace("/(.min)?".$cleanExt."$/", "", $fileToFind);
        // If dev mode .min has less priority
        return Director::isDev() ?
            array(
            $fileNoExt.$cleanExt,
            $fileNoExt.".min".$cleanExt
            ) :
            array(
            $fileNoExt.".min".$cleanExt,
            $fileNoExt.$cleanExt,
        );
    }

    protected function getFolderList($ext)
    {
        $subFolders = array();
        if (strrpos($ext, "css", -strlen($ext)) !== false) {
            $subFolders[] = "css";
        } else if (strrpos($ext, "js", -strlen($ext)) !== false) {
            $subFolders[] = "javascript";
            $subFolders[] = "js";
        }

        $baseFolders = array(
            SSViewer::get_theme_folder(),
            project()
        );

        $result = array();
        foreach ($baseFolders as $baseFolder) {
            foreach ($subFolders as $subFolder) {
                $result[] = $baseFolder.'/'.$subFolder;
            }
        }
        return $result;
    }

    protected function path_for_file($fileOrUrl)
    {
        return parent::path_for_file($fileOrUrl);
    }

    public static function enable()
    {
        if (!Requirements::backend() instanceof SSGuru_Requirements_Backend) {
            Requirements::set_backend(SSGuru_Requirements_Backend::createFromExisting(Requirements::backend()));
        }
    }

    public static function createFromExisting($sourceObject)
    {

        $result                = new static();
        $sourceReflection      = new ReflectionObject($sourceObject);
        $destinationReflection = new ReflectionObject($result);
        $sourceProperties      = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            $name  = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);
            if ($destinationReflection->hasProperty($name)) {
                $propDest = $destinationReflection->getProperty($name);
                $propDest->setAccessible(true);
                $propDest->setValue($result, $value);
            } else {
                $result->$name = $value;
            }
        }
        return $result;
    }
}