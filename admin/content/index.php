<?php
include_once("session.php");
include_once("class/pages/AdminPage.php");

$page = new AdminPage();

$menu = array(new MenuItem("Menu Items", "menus/index.php", "menu"),
              new MenuItem("Gallery Photos", "photo_gallery/list.php", "gallery"),

              new MenuItem("Dynamic Pages", "pages/list.php", "pages"),

              new MenuItem("News", "news/list.php", "news"),
              new MenuItem("FAQ", "faq/list.php", "faq"),

);

$page->setPageMenu($menu);

$page->startRender();

echo "Content Management";

$page->finishRender();
?>