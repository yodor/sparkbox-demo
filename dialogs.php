<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("dialogs/ConfirmMessageDialog.php");
include_once("dialogs/InputMessageDialog.php");
include_once("class/responders/json/SampleFormResponder.php");
include_once("components/PageScript.php");

class DialogScript extends PageScript
{

    public function code(): string
    {
        return <<<JS

        let confirm_dialog = new ConfirmMessageDialog();
        let user_input = new InputMessageDialog();
        
        function showUserInputDialog() {
            user_input.show();
            user_input.input().val($("[name='message3']").val());
        }
    
        function showMessageDialog() {
            let message_text = $(".TextField input[type='text']").val();
            showAlert(message_text);
        }
    
        function showConfirmDialog() {
            let message_text = $(".TextArea textarea").val();
            confirm_dialog.setText(message_text);
            confirm_dialog.show();
        }
        function showJSONFormDialog() {
            let dialog = new JSONFormDialog();
            dialog.setResponder("SampleFormResponder");
            dialog.show();
        }
        
        onPageLoad(function(){
                
                confirm_dialog.initialize();
            
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
            
                }
            
                
                user_input.initialize();
            
                user_input.buttonAction = function (action, dialog) {
            
                    let input_value = user_input.input().val();
                    $("[name='message3']").val(input_value);
            
                    if (action == "confirm") {
            
                        showAlert("Confirmed: <BR>Value: " + input_value);
            
                    } else if (action == "cancel") {
            
                        showAlert("Canceled");
                    }
            
                    user_input.remove();
                }
            
            
                
        });
JS;
    }
}

$page = new DemoPage();

$dialogScript = new DialogScript();

$responder = new SampleFormResponder();

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

