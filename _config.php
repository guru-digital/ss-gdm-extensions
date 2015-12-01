<?php

Requirements::set_backend(new SSGuru_Requirements_Backend());
define('SS_GDM_EXTENSIONS_DIR', basename(dirname(__FILE__)));
Deprecation::notification_version("0.1.3", SS_GDM_EXTENSIONS_DIR);
