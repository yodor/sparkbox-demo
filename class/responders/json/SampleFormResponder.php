<?php
include_once("responders/json/JSONFormResponder.php");
include_once("class/forms/SampleForm.php");

/**
 * The responder of the JSONFormDialog of the dialogs page: the form of the dialog, validated on submit - nothing is
 * stored
 */
class SampleFormResponder extends JSONFormResponder
{
    protected function createForm(): InputForm
    {
        return new SampleForm();
    }

    protected function onProcessSuccess(JSONResponse $resp) : void
    {
        parent::onProcessSuccess($resp);
        $resp->message = "The form is valid - nothing is stored in this demo";
    }
}
