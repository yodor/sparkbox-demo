<?php
include_once("templates/TemplateContent.php");
include_once("components/Container.php");
include_once("components/Component.php");

/**
 * A page of the demo: its caption, a short text about the components it shows (the class names in it are code),
 * then the showcase - section.demo.<name> > h1.Caption, .intro, the components
 */
abstract class DemoContent extends TemplateContent
{
    /**
     * Start the page: the container, the caption (the title of the path config), the text
     * @param string $name css class of the page
     * @param string $intro HTML text about the page
     * @return void
     */
    protected function start(string $name, string $intro) : void
    {
        $this->cmp = new Container(false);
        $this->cmp->setTagName("section");
        $this->cmp->setComponentClass("demo");
        $this->cmp->addClassName($name);

        $caption = new Component(false);
        $caption->setTagName("h1");
        $caption->setComponentClass("Caption");
        $caption->setText($this->config->title);
        $this->cmp->items()->append($caption);

        $text = new Component(false);
        $text->setComponentClass("intro");
        $text->setContents($intro);
        $this->cmp->items()->append($text);
    }

    /**
     * A sub heading of the page
     * @param string $text
     * @return Component
     */
    protected function heading(string $text) : Component
    {
        $heading = new Component(false);
        $heading->setTagName("h2");
        $heading->setComponentClass("heading");
        $heading->setText($text);
        $this->cmp->items()->append($heading);
        return $heading;
    }
}
