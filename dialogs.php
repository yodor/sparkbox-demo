<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("dialogs/ConfirmMessageDialog.php");
include_once("dialogs/InputMessageDialog.php");
include_once("class/responders/json/SampleFormResponder.php");

$page = new DemoPage();

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

ColorButton::RenderButton("Show Message", "javascript:showMessageDialog()");

$cmp->setDataInput($field2);
$cmp->render();

ColorButton::RenderButton("Show Confirm", "javascript:showConfirmDialog()");

$cmp->setDataInput($field3);
$cmp->render();

ColorButton::RenderButton("Show Input", "javascript:showUserInputDialog()");

ColorButton::RenderButton("Show JSONFormDialog", "javascript:showJSONFormDialog()");

$page->finishRender();

?>
<!--render after all page scripts are loaded -->
<script type='text/javascript'>

    let confirm_dialog = new ConfirmMessageDialog()
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

    let user_input = new InputMessageDialog();
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

</script>
