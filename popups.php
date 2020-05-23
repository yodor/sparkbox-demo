<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("dialogs/ConfirmMessageDialog.php");
include_once("dialogs/InputMessageDialog.php");

$page = new DemoPage();

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
//$field1->getRenderer()->render();
echo "<BR>";
ColorButton::RenderButton("Show Message", "javascript:onShowMessage(this)");

echo "<HR>";

$cmp->setDataInput($field2);
$cmp->render();
echo "<BR>";
ColorButton::RenderButton("Show Confirm", "javascript:onShowConfirm(this)");

echo "<HR>";

$cmp->setDataInput($field3);
$cmp->render();
echo "<BR>";

ColorButton::RenderButton("Show Input", "javascript:user_input.show()");

?>
    <script type='text/javascript'>

        let user_input = new MessageDialog("<?php echo $input_dialog->getID();?>");
        user_input.buttonAction = function (action) {
            user_input.remove();
            if (action == "confirm") {

                showAlert("Confirmed: <BR>Value: " + user_input.input.value);
                $("[name='message3']").val(user_input.input.value);
            }
            else if (action == "cancel") {

                showAlert("Canceled");
            }
        }
        user_input.showFinished = function() {
            user_input.input.value = $("[name='message3']").val();
        }

        function onShowMessage() {
            var message_text = $(".TextField input[type='text']").val();
            showAlert(message_text);

        }

        function onShowConfirm() {
            var message_text = $(".TextArea textarea").val();
            showConfirm(message_text, onSampleConfirmOK, onSampleConfirmCancel);
        }



        function onSampleConfirmCancel(confirm_dialog) {

            showAlert("You pressed 'Cancel'", function (alert_dialog) {
                alert("cancel");
                alert_dialog.modal_pane.pane().remove();
                confirm_dialog.modal_pane.pane().remove();
            });
        }

        function onSampleConfirmOK(elm) {
            showAlert("You pressed 'OK'");
        }
    </script>
<?php

$page->finishRender();

?>