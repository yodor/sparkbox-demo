<?php
include_once("forms/InputForm.php");
include_once("input/DataInputFactory.php");


class StoreSizeInputForm extends InputForm
{

    public function __construct()
    {

        $field = DataInputFactory::Create(DataInputFactory::TEXT, "size_value", "Size Code", 1);
        $this->addInput($field);
        $field->enableTranslator(true);

    }

}

?>
