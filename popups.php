<?php
include_once("session.php");
include_once("class/pages/DemoPage.php");
include_once("panels/ConfirmMessageDialog.php");

$page = new DemoPage();

$dialog = new ConfirmMessageDialog();

$field1 = DataInputFactory::CREATE(DataInputFactory::TEXT, "message1", "Message", false);
$field1->setValue("Sample message text");

$field2 = DataInputFactory::CREATE(DataInputFactory::TEXTAREA, "message2", "Confirmation Message", false);
$field2->setValue("Sample confirmation message text");


$page->startRender();

$field1->getRenderer()->render();
echo "<BR>";
ColorButton::RenderButton("Show Message", "javascript:onShowMessage(this)");

echo "<HR>";

$field2->getRenderer()->render();
echo "<BR>";
ColorButton::RenderButton("Show Confirm", "javascript:onShowConfirm(this)");
?>
    <script type='text/javascript'>
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