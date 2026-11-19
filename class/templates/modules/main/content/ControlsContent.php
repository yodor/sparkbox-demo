<?php
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("forms/InputForm.php");
include_once("forms/renderers/FormRenderer.php");
include_once("forms/processors/FormProcessor.php");
include_once("input/DataInputFactory.php");
include_once("iterators/ArrayDataIterator.php");
include_once("components/Button.php");
include_once("utils/url/URL.php");

/**
 * The input types of DataInputFactory in one InputForm: required ones, the data source of the select, check and
 * radio inputs (an ArrayDataIterator), the validation on submit; ?layout=hbox - the horizontal layout
 */
class ControlsContent extends DemoContent
{
    protected InputForm $form;

    protected FormRenderer $renderer;

    protected FormProcessor $processor;

    public function initialize() : void
    {
        $this->start("controls", "<p>An <code>InputForm</code> with the input types of <code>DataInputFactory</code>. " .
            "The <code>FormProcessor</code> validates it on submit - the required inputs and the e-mail are checked, the " .
            "errors are shown at their inputs. The select, check and radio inputs take their items from an iterator " .
            "(<code>ArrayDataIterator</code> here, a bean query usually).</p>");

        $this->form = new InputForm();
        $this->form->addInput(DataInputFactory::Create(InputType::TEXT, "text", "Text", 1));
        $this->form->addInput(DataInputFactory::Create(InputType::EMAIL, "email", "E-mail", 1));
        $this->form->addInput(DataInputFactory::Create(InputType::PASSWORD, "password", "Password", 0));
        $this->form->addInput($this->listInput(InputType::SELECT, "select", "Select", 1, "Option", 5, ArrayDataIterator::KEY_ID));
        $this->form->addInput($this->listInput(InputType::SELECT_MULTI, "select_multi", "Select Multiple", 0, "Option", 8, ArrayDataIterator::KEY_ID));
        $this->form->addInput(DataInputFactory::Create(InputType::TEXTAREA, "textarea", "Text Area", 0));
        $this->form->addInput(DataInputFactory::Create(InputType::CHECKBOX, "single_check", "Checkbox", 0));

        $accept = DataInputFactory::Create(InputType::CHECKBOX, "accept", "Accept", 1);
        $accept->getRenderer()->setCaption("I accept the terms (required)");
        $this->form->addInput($accept);

        $this->form->addInput($this->listInput(InputType::CHECKBOX, "checks", "Checkboxes", 0, "Check", 5, ArrayDataIterator::KEY_VALUE));
        $this->form->addInput($this->listInput(InputType::RADIO, "radio", "Radio Buttons", 1, "Radio", 3, ArrayDataIterator::KEY_VALUE));

        $this->renderer = new FormRenderer($this->form);
        if (strcmp((string)($_GET["layout"] ?? ""), "hbox") === 0) {
            $this->renderer->setLayout(FormRenderer::LAYOUT_HBOX);
        }

        $layouts = new Container(false);
        $layouts->setComponentClass("buttons");
        $layouts->items()->append(Button::LocationButton("Vertical Layout", new URL("?layout=vbox")));
        $layouts->items()->append(Button::LocationButton("Horizontal Layout", new URL("?layout=hbox")));
        $this->cmp->items()->append($layouts);

        $this->cmp->items()->append($this->renderer);
        $this->processor = new FormProcessor();
    }

    /**
     * An input with items: '$count' items '<prefix> 1' ... from an ArrayDataIterator
     */
    protected function listInput(InputType $type, string $name, string $label, int $required, string $prefix, int $count, string $valueKey) : DataInput
    {
        $items = array();
        for ($i = 1; $i <= $count; $i++) $items[] = "$prefix $i";
        $input = DataInputFactory::Create($type, $name, $label, $required);
        $input->getRenderer()->setIterator(new ArrayDataIterator($items));
        $input->getRenderer()->getItemRenderer()->setValueKey($valueKey);
        $input->getRenderer()->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
        return $input;
    }

    public function processInput() : void
    {
        parent::processInput();
        $this->processor->process($this->form);
        if ($this->processor->getStatus() === IFormProcessor::STATUS_OK) {
            Session::SetAlert("The form is valid - nothing is stored in this demo");
        }
    }

    protected function getContentTitle() : string
    {
        return "Input Controls";
    }
}
