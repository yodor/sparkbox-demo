<?php
include_once("forms/InputForm.php");
include_once("input/DataInputFactory.php");


class StoreColorInputForm extends InputForm
{

    public function __construct()
    {

        $field = DataInputFactory::Create(DataInputFactory::TEXT, "color", "Color Name", 1);
        $this->addInput($field);
        $field->enableTranslator(true);

        $field = DataInputFactory::Create(DataInputFactory::COLOR_CODE, "color_code", "Color Code", 0);

        $this->addInput($field);

    }

}

?>
