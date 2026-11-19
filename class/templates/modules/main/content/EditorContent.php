<?php
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("forms/InputForm.php");
include_once("forms/renderers/FormRenderer.php");
include_once("forms/processors/FormProcessor.php");
include_once("input/DataInputFactory.php");

/**
 * MCETextArea: the HTML editor of the admin with its image browser (images of the section 'demo'); 'Preview' shows
 * the HTML under the form
 */
class EditorContent extends DemoContent
{
    protected InputForm $form;

    protected FormProcessor $processor;

    protected Component $preview;

    public function initialize() : void
    {
        $this->start("editor", "<p><code>MCE_TEXTAREA</code> - the HTML editor of the admin. Its image browser keeps the " .
            "images of a section of the site (<code>MCEImagesBean</code>); the text is cleaned of tags the site does not " .
            "allow when it is posted. 'Preview' shows the result.</p>");

        $this->form = new InputForm();
        $text = DataInputFactory::Create(InputType::MCE_TEXTAREA, "text", "Text", 1);
        $text->getRenderer()->getImageBrowser()->getResponder()->setSection("mce_image_demo", "text");
        $text->getRenderer()->getImageBrowser()->getResponder()->setOwnerID(-1);
        $this->form->addInput($text);

        $renderer = new FormRenderer($this->form);
        $renderer->getSubmitButton()->setContents("Preview");
        $this->cmp->items()->append($renderer);

        $this->heading("Preview");
        $this->preview = new Component(false);
        $this->preview->setComponentClass("preview");
        $this->cmp->items()->append($this->preview);

        $this->processor = new FormProcessor();
    }

    public function processInput() : void
    {
        parent::processInput();
        $this->processor->process($this->form);
        if ($this->processor->getStatus() === IFormProcessor::STATUS_OK) {
            //the HTML of the editor - sanitized by the input processor
            $this->preview->setContents((string)$this->form->getInput("text")->getValue());
        }
    }

    protected function getContentTitle() : string
    {
        return "Text Editor";
    }
}
