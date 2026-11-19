<?php
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("forms/InputForm.php");
include_once("forms/renderers/FormRenderer.php");
include_once("forms/processors/FormProcessor.php");
include_once("iterators/ArrayDataIterator.php");
include_once("input/ArrayDataInput.php");
include_once("input/processors/InputProcessor.php");
include_once("input/validators/EmptyValueValidator.php");
include_once("input/validators/PhoneValidator.php");
include_once("input/validators/DateValidator.php");
include_once("input/validators/TimeValidator.php");
include_once("input/renderers/ArrayField.php");
include_once("input/renderers/TextField.php");
include_once("input/renderers/TextArea.php");
include_once("input/renderers/SelectField.php");
include_once("input/renderers/CheckField.php");
include_once("input/renderers/RadioField.php");
include_once("input/renderers/PhoneField.php");
include_once("input/renderers/DateField.php");
include_once("input/renderers/TimeField.php");

/**
 * ArrayField: an input the visitor repeats - add and remove its values (an ArrayDataInput of any field renderer)
 */
class ArrayControlsContent extends DemoContent
{
    protected InputForm $form;

    protected FormProcessor $processor;

    public function initialize() : void
    {
        $this->start("array_controls", "<p>An <code>ArrayDataInput</code> holds a list of values; <code>ArrayField</code> " .
            "around any field renderer lets the visitor add and remove them. Each value is validated on its own.</p>");

        $this->form = new InputForm();
        $this->form->addInput($this->arrayInput("text", "Text", new EmptyValueValidator(), fn(ArrayDataInput $i) => new TextField($i)));
        $this->form->addInput($this->arrayInput("textarea", "Text Area", new EmptyValueValidator(), fn(ArrayDataInput $i) => new TextArea($i)));
        $this->form->addInput($this->arrayInput("select", "Select", new EmptyValueValidator(), function (ArrayDataInput $i) {
            $field = new SelectField($i);
            $field->setIterator(new ArrayDataIterator(array("Select Item 1", "Select Item 2", "Select Item 3")));
            $field->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_ID);
            $field->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
            return $field;
        }));
        $this->form->addInput($this->arrayInput("check", "Checkbox", new EmptyValueValidator(), function (ArrayDataInput $i) {
            $field = new CheckField($i);
            $field->setIterator(new ArrayDataIterator(array("Check 1", "Check 2", "Check 3")));
            $field->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
            $field->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
            return $field;
        }));
        $this->form->addInput($this->arrayInput("radio", "Radio Button", new EmptyValueValidator(), function (ArrayDataInput $i) {
            $field = new RadioField($i);
            $field->setIterator(new ArrayDataIterator(array("Radio 1", "Radio 2", "Radio 3")));
            $field->getItemRenderer()->setValueKey(ArrayDataIterator::KEY_VALUE);
            $field->getItemRenderer()->setLabelKey(ArrayDataIterator::KEY_VALUE);
            return $field;
        }));
        $this->form->addInput($this->arrayInput("phone", "Phone", new PhoneValidator(), fn(ArrayDataInput $i) => new PhoneField($i)));
        $this->form->addInput($this->arrayInput("date", "Date", new DateValidator(), fn(ArrayDataInput $i) => new DateField($i)));
        $this->form->addInput($this->arrayInput("time", "Time", new TimeValidator(), fn(ArrayDataInput $i) => new TimeField($i)));

        $this->cmp->items()->append(new FormRenderer($this->form));
        $this->processor = new FormProcessor();
    }

    /**
     * An array input of the field '$field' with the validator '$validator'
     */
    protected function arrayInput(string $name, string $label, IInputValidator $validator, Closure $field) : ArrayDataInput
    {
        $input = new ArrayDataInput($name, $label, 1);
        $input->setValidator($validator);
        new ArrayField($field($input));
        new InputProcessor($input);
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
        return "Array Controls";
    }
}
