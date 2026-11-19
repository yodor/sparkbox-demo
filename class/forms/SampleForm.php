<?php
include_once("forms/InputForm.php");
include_once("input/DataInputFactory.php");

/**
 * The form of the JSONFormDialog of the dialogs page (SampleFormResponder)
 */
class SampleForm extends InputForm
{
    public function __construct()
    {
        parent::__construct();

        $input = DataInputFactory::Create(InputType::TEXT, "control1", "Text", 1);
        $this->addInput($input);

        $input = DataInputFactory::Create(InputType::TEXTAREA, "control2", "TextArea", 1);
        $this->addInput($input);

        $input = DataInputFactory::Create(InputType::SESSION_IMAGE, "control3", "SessionImage", 1);

        $input->getProcessor()->setTransactBeanItemLimit(4);

        $this->addInput($input);

    }
}
