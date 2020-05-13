<?php
include_once("forms/InputForm.php");


class FAQItemInputForm extends InputForm
{

    public function __construct()
    {

        parent::__construct();

        $field = DataInputFactory::Create(DataInputFactory::SELECT, "section", "Section", 1);

        $enm = new DBEnumIterator("faq_items", "section");
        $rend = $field->getRenderer();
        $rend->setItemIterator($enm);
        $rend->getItemRenderer()->setValueKey("section");
        $rend->getItemRenderer()->setLabelKey("section");

        $this->addInput($field);

        $field = DataInputFactory::Create(DataInputFactory::TEXT, "question", "Question", 1);
        $this->addInput($field);

        $field = DataInputFactory::Create(DataInputFactory::TEXTAREA, "answer", "Answer", 1);
        $this->addInput($field);

    }

}

?>