<?php
include_once("forms/InputForm.php");
include_once("class/beans/BrandsBean.php");
include_once("input/validators/URLValidator.php");

class BrandInputForm extends InputForm
{


    public function __construct()
    {
        $field = DataInputFactory::Create(DataInputFactory::TEXT, "brand_name", "Brand Name", 1);
        $this->addInput($field);

        $field = DataInputFactory::Create(DataInputFactory::TEXT, "url", "Brand URL", 0);
        $field->setValidator(new URLValidator());
        $this->addInput($field);

        $field = DataInputFactory::Create(DataInputFactory::MCE_TEXTAREA, "summary", "Brand Summary", 0);
        $this->addInput($field);


        $field = DataInputFactory::Create(DataInputFactory::SESSION_IMAGE, "photo", "Photo", 0);
        $this->addInput($field);

    }

}

?>
