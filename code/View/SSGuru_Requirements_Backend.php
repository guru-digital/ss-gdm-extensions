<?php

class SSGuru_Requirements_Backend extends Requirements_Backend {

	public function javascript($file) {
		if (!$this->isURL($file)) {
			if (!Director::fileExists($file)) {
				$file = $this->findRequirementFile($file, "js");
			}
		}
		return parent::javascript($file);
	}

	public function css($file, $media = null) {
		if (!$this->isURL($file)) {
			if (!Director::fileExists($file)) {
				$file = $this->findRequirementFile($file, "css");
			}
		}
		return parent::css($file, $media);
	}

//	public function css1($fileOrUrl) {
//		if (!$this->isURL($fileOrUrl)) {
//			if (!Director::fileExists($fileOrUrl)) {
//
//			}
//		}
//		return parent::css($fileOrUrl);
//	}

	public function themedCSS($name, $module = null, $media = null) {
		return parent::themedCSS($name, $module, $media);
	}

	protected function isURL($fileOrUrl) {
		return preg_match('{^//|http[s]?}', $fileOrUrl);
	}

	protected function findRequirementFile($fileToFind, $ext) {
		$result		 = $fileToFind;
		$folderList	 = $this->getFolderList($ext);
		$fileList	 = $this->getFileList($fileToFind, $ext);
		foreach ($folderList as $folder) {
			foreach ($fileList as $file) {
				if (Director::fileExists($folder . '/' . $file)) {
					$result = $folder . '/' . $file;
					break 2;
				}
			}
		}
		return $result;
	}

	protected function getFileList($fileToFind, $ext) {
		$cleanExt	 = "." . ltrim($ext, ".");
		$fileNoExt	 = preg_replace("/(.min)?" . $cleanExt . "$/", "", $fileToFind);
		// If dev mode .min has less priority
		return Director::isDev() ?
				array(
			$fileNoExt . $cleanExt,
			$fileNoExt . ".min" . $cleanExt
				) :
				array(
			$fileNoExt . ".min" . $cleanExt,
			$fileNoExt . $cleanExt,
		);
	}

	protected function getFolderList($ext) {
		$subFolders = array();
		if (strrpos($ext, "css", -strlen($ext)) !== false) {
			$subFolders[] = "css";
		} else if (strrpos($ext, "js", -strlen($ext)) !== false) {
			$subFolders[]	 = "javascript";
			$subFolders[]	 = "js";
		}

		$baseFolders = array(
			SSViewer::get_theme_folder(),
			project()
		);

		$result = array();
		foreach ($baseFolders as $baseFolder) {
			foreach ($subFolders as $subFolder) {
				$result[] = $baseFolder . '/' . $subFolder;
			}
		}

		return $result;
	}

	protected function path_for_file($fileOrUrl) {
//		Debug::message($fileOrUrl . " " . (Controller::curr()->IsCMS() ? "Admin" : "FrontEnd"));
		return parent::path_for_file($fileOrUrl);
	}

}
