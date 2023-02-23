<?php
include_once("forms/InputForm.php");

class SampleForm extends InputForm {
    public function __construct()
    {
        parent::__construct();

        $input = DataInputFactory::Create(DataInputFactory::TEXT, "control1", "Text", 1);
        $this->addInput($input);

        $input = DataInputFactory::Create(DataInputFactory::TEXTAREA, "control2", "TextArea", 1);
        $this->addInput($input);

        $input = DataInputFactory::Create(DataInputFactory::SESSION_IMAGE, "control3", "SessionImage", 1);
        $this->addInput($input);

    }
}
?>