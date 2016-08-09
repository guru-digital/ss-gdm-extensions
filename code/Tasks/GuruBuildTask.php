<?php

abstract class GuruBuildTask extends BuildTask
{
    protected $renderer;
    protected $isCLI;
    protected $eol;
    protected $indent;

    public function __construct()
    {
        parent::__construct();
        $this->isCLI    = Director::is_cli();
        $this->eol      = $this->isCLI ? PHP_EOL : "<br/>";
        $this->indent   = $this->isCLI ? "    " : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $this->renderer = DebugView::create();
    }

    public function renderHeader()
    {
        if (!$this->isCLI) {
            ini_set('max_execution_time', 1800); //1800 seconds = 30 minutes
            ini_set('memory_limit', '1204M');
            $this->renderer = DebugView::create();
            $this->renderer->writeHeader();
            $this->renderer->writeInfo($this->title, Director::absoluteBaseURL());
            echo "<div class=\"build\">";
        }
    }

    public function renderFooter()
    {
        if (!$this->isCLI) {
            echo "</div>";
            $this->renderer->writeFooter();
        }
    }


//    public function run($request)
//    {
//        $result = true;
//        if (!Director::isDev() && !$this->isCLI && !Permission::check("ADMIN")) {
//            $result = Security::permissionFailure();
//        } else {
//            $this->renderHeader();
//            //Run task code...
//            $this->renderFooter();
//        }
//        return $result;
//    }
}