<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("dialogs/ConfirmMessageDialog.php");
include_once("dialogs/InputMessageDialog.php");
include_once("dialogs/json/JSONFormDialog.php");

include_once("class/responders/json/SampleFormResponder.php");
include_once("components/PageScript.php");

class DialogScript extends PageScript
{

    public function code(): string
    {
        return <<<JS

        function showUserInputDialog() {
            let user_input = new InputMessageDialog();

            const message3 = document.querySelector("[name='message3']");
            user_input.input.value = message3.value;
            
            user_input.buttonAction = function (action) {

                    message3.value = user_input.input.value;
            
                    if (action == "confirm") {
            
                        showAlert("Confirmed: <BR>Value: " + message3.value);
            
                    } else if (action == "cancel") {
            
                        showAlert("Canceled");
                    }
                    user_input.remove();
            };
            user_input.show();
            
        }
    
        function showMessageDialog() {
            let message_text = $(".TextField input[type='text']").val();
            showAlert(message_text);
        }
    
        function showConfirmDialog() {
                    
            let confirm_dialog = new ConfirmMessageDialog();

            let message_text = $(".TextArea textarea").val();
            confirm_dialog.setText(message_text);
            
            confirm_dialog.buttonAction = function (action) {
    
                if (action == "confirm") {
        
                    let dialog = showAlert("You pressed confirm");
                    dialog.buttonAction = function (action) {
                        dialog.remove();
                        confirm_dialog.remove();
                    }
        
                } else if (action == "cancel") {
                    showAlert("You pressed cancel");
                }
            };
            
            confirm_dialog.show();
            
        }
        
        function showJSONFormDialog() {
            let dialog = new JSONFormDialog();
            dialog.setResponder("SampleFormResponder");
            dialog.setTitle("SampleFormResponder");
            dialog.show();
        }
JS;
    }
}

$page = new DemoPage();

$responder = new SampleFormResponder();

$json_dialog = new JSONFormDialog();
$json_dialog->setResponder($responder);

$dialogScript = new DialogScript();



$confirm_dialog = new ConfirmMessageDialog();
$input_dialog = new InputMessageDialog();

$field1 = DataInputFactory::CREATE(DataInputFactory::TEXT, "message1", "Message", FALSE);
$field1->setValue("Sample message text");

$field2 = DataInputFactory::CREATE(DataInputFactory::TEXTAREA, "message2", "Confirmation Message", FALSE);
$field2->setValue("Sample confirmation message text");

$field3 = DataInputFactory::CREATE(DataInputFactory::TEXT, "message3", "User Input", FALSE);
$field3->setValue("");

$cmp = new InputComponent();

$page->startRender();

$cmp->setDataInput($field1);
$cmp->render();

Button::ActionButton("Show Message", "javascript:showMessageDialog()")->render();

$cmp->setDataInput($field2);
$cmp->render();

Button::ActionButton("Show Confirm", "javascript:showConfirmDialog()")->render();

$cmp->setDataInput($field3);
$cmp->render();

Button::ActionButton("Show Input", "javascript:showUserInputDialog()")->render();

Button::ActionButton("Show JSONFormDialog", "javascript:showJSONFormDialog()")->render();

$page->finishRender();
