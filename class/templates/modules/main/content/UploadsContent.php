<?php
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("forms/InputForm.php");
include_once("forms/renderers/FormRenderer.php");
include_once("forms/processors/FormProcessor.php");
include_once("input/DataInputFactory.php");

/**
 * The uploads of the core: images and files uploaded over AJAX into the session (up to 4 images), and the chunked
 * upload of a large file
 */
class UploadsContent extends DemoContent
{
    protected InputForm $form;

    protected FormProcessor $processor;

    public function initialize() : void
    {
        $this->start("uploads", "<p>The session uploads: the files go to the session over AJAX while the form is open " .
            "(<code>SESSION_IMAGE</code> - here up to 4 images, <code>SESSION_FILE</code>) and are stored with the form " .
            "on submit. <code>SESSION_CHUNKED_FILE</code> sends a large file in parts, past the upload size limit of PHP. " .
            "Nothing is stored in this demo.</p>");

        $this->form = new InputForm();
        $photo = DataInputFactory::Create(InputType::SESSION_IMAGE, "photo", "Photos", 1);
        $photo->getProcessor()->setTransactBeanItemLimit(4);
        $this->form->addInput($photo);
        $this->form->addInput(DataInputFactory::Create(InputType::SESSION_FILE, "document", "Document", 0));
        $this->form->addInput(DataInputFactory::Create(InputType::SESSION_CHUNKED_FILE, "large_file", "Large File (chunked)", 0));

        $renderer = new FormRenderer($this->form);
        $this->form->setRenderer($renderer);
        $this->cmp->items()->append($renderer);
        $this->processor = new FormProcessor();
    }

    public function processInput() : void
    {
        parent::processInput();
        $this->processor->process($this->form);
        if ($this->processor->getStatus() === IFormProcessor::STATUS_OK) {
            Session::SetAlert("The uploads are valid - nothing is stored in this demo");
        }
    }

    protected function getContentTitle() : string
    {
        return "Uploads";
    }
}
