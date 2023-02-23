<?php
include_once("responders/json/JSONFormResponder.php");
include_once("class/forms/SampleForm.php");

class SampleFormResponder extends JSONFormResponder
{
    public function __construct()
    {
        parent::__construct(get_class($this));

    }

    protected function createForm(): InputForm
    {
        return new SampleForm();
    }

    protected function onProcessSuccess(JSONResponse $resp)
    {
        parent::onProcessSuccess($resp);
        //no output here means the operation is finished and dialog should be closed
        $this->form->getRenderer()->render();
        $resp->message = "Operation Success";
    }
}
?>