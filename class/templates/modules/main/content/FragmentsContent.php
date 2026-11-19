<?php
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("components/InlineScript.php");
include_once("components/Button.php");
include_once("components/renderers/IPageComponent.php");

/**
 * The script of the fragments page: loads the content of a path into the box
 */
class DemoFragmentsScript extends InlineScript implements IPageComponent
{
    protected function finalize() : void
    {
        $this->setCode(<<<JS
function demoFragment(url) {
    const box = document.querySelector(".demo.fragments .fragment_box");
    box.innerHTML = "";
    new ContentFragment(url).load(box).catch((error) => showAlert("Not loaded: " + (error.description || error)));
}
JS);
        parent::finalize();
    }
}

/**
 * ContentFragment: the content of another module path loaded into this page - with the css and js it needs
 */
class FragmentsContent extends DemoContent
{
    public function initialize() : void
    {
        $this->start("fragments", "<p>Any module path answers its content alone to a JSON request " .
            "(<code>ContentFragmentResponder</code>) - the frame is not sent. <code>ContentFragment</code> in the browser " .
            "loads it into an element, with the stylesheets and scripts the page does not have yet. The buttons load the " .
            "content of other pages of this site into the box.</p>");

        new DemoFragmentsScript();
        $local = Spark::Get(Config::LOCAL);

        $buttons = new Container(false);
        $buttons->setComponentClass("buttons");
        foreach (array("/gallery" => "Image Gallery", "/tree" => "Tree View", "/news/" => "News", "/controls" => "Input Controls") as $path => $title) {
            $buttons->items()->append(Button::ActionButton("Load: $title", "javascript:demoFragment('" . $local . $path . "')"));
        }
        $this->cmp->items()->append($buttons);

        $box = new Container(false);
        $box->setComponentClass("fragment_box");
        $this->cmp->items()->append($box);
    }

    protected function getContentTitle() : string
    {
        return "Fragments";
    }
}
