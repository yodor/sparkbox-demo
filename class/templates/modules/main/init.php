<?php
//
// main module - the demo pages (scripts of the old demo → paths): /controls, /controls/arrays, /controls/uploads,
// /controls/editor, /dialogs, /gallery, /tree, /menus, /fragments
//
include_once("class/pages/DemoPage.php");

$module = Module::Active();
$module->pageClass = DemoPage::class;

//the old scripts
$module->addRedirect("controls.php", "controls");
$module->addRedirect("array_controls.php", "controls/arrays");
$module->addRedirect("ajax_upload.php", "controls/uploads");
$module->addRedirect("ajax_chunkupload.php", "controls/uploads");
$module->addRedirect("mce_browser.php", "controls/editor");
$module->addRedirect("dialogs.php", "dialogs");
$module->addRedirect("gallery.php", "gallery");
$module->addRedirect("tree.php", "tree");
$module->addRedirect("menu.php", "menus");
$module->addRedirect("news.php", "/news/");
