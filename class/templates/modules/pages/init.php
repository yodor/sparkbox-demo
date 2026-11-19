<?php
//pages module - the demo frame
include_once("class/pages/DemoPage.php");

Module::Active()->pageClass = DemoPage::class;
