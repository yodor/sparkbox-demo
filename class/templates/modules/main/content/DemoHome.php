<?php
include_once("class/templates/modules/main/content/DemoContent.php");

/**
 * The home of the demo: what SparkBox is and the list of the demo pages
 */
class DemoHome extends DemoContent
{
    public function initialize() : void
    {
        $local = Spark::Get(Config::LOCAL);
        $this->start("home", "<p>SparkBox is an object oriented PHP library for web sites, web applications and their admin. " .
            "This site is a core site (no store layer): each page shows a group of the core components, built as a content " .
            "of the module engine. The source is on <a href='https://github.com/yodor/sparkbox'>GitHub</a>; " .
            "this demo is <a href='https://github.com/yodor/sparkbox-demo'>sparkbox-demo</a>.</p>");

        $pages = array(
            array("/controls", "Input Controls", "InputForm with every input type of DataInputFactory, its validation and the vertical / horizontal layout of FormRenderer"),
            array("/controls/arrays", "Array Controls", "ArrayField: inputs the visitor adds and removes - text, select, check, radio, phone, date, time"),
            array("/controls/uploads", "Uploads", "SessionImage and SessionFile uploads over AJAX, and the chunked upload of large files"),
            array("/controls/editor", "Text Editor", "MCETextArea - the HTML editor of the admin with its image browser"),
            array("/dialogs", "Dialogs", "MessageDialog, ConfirmMessageDialog, InputMessageDialog and a JSONFormDialog answered by its JSONFormResponder"),
            array("/gallery", "Image Gallery", "GalleryTape and ImagePopup over a bean of photos (uploaded in the admin)"),
            array("/tree", "Tree View", "NestedSetTreeView of a NestedSetBean, with checkboxes and the selected node"),
            array("/menus", "Menus", "MenuBar of a MenuItemList built in code, and of the menu of the admin (BeanMenuFactory)"),
            array("/fragments", "Fragments", "ContentFragment - the content of another module path loaded into this page"),
            array("/news/", "News", "The news module of the core (publications, archive) in the demo frame"),
            array("/admin/", "Admin", "The admin module of the core: lists, editors, galleries, menus, settings"),
        );
        $list = new Container(false);
        $list->setComponentClass("pages");
        foreach ($pages as [$href, $title, $text]) {
            $item = new Container(false);
            $item->setTagName("a");
            $item->setComponentClass("page");
            $item->setAttribute("href", $local . $href);
            $name = new Component(false);
            $name->setComponentClass("title");
            $name->setText($title);
            $item->items()->append($name);
            $about = new Component(false);
            $about->setComponentClass("text");
            $about->setText($text);
            $item->items()->append($about);
            $list->items()->append($item);
        }
        $this->cmp->items()->append($list);
    }

    protected function getContentTitle() : string
    {
        return "SparkBox Demo";
    }
}
