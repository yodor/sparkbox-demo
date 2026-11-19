<?php
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("class/responders/json/SampleFormResponder.php");
include_once("dialogs/ConfirmMessageDialog.php");
include_once("dialogs/InputMessageDialog.php");
include_once("dialogs/json/JSONFormDialog.php");
include_once("components/InlineScript.php");
include_once("components/InputComponent.php");
include_once("components/Button.php");
include_once("components/renderers/IPageComponent.php");
include_once("input/DataInputFactory.php");

/**
 * The script of the dialogs page: a function per dialog
 */
class DemoDialogsScript extends InlineScript implements IPageComponent
{
    protected function finalize() : void
    {
        $this->setCode(<<<JS
function demoMessage() {
    showAlert(document.querySelector("[name='message']").value);
}
function demoConfirm() {
    const dialog = new ConfirmMessageDialog();
    dialog.setText(document.querySelector("[name='question']").value);
    dialog.buttonAction = function (action) {
        dialog.remove();
        showAlert(action === "confirm" ? "You pressed Confirm" : "You pressed Cancel");
    };
    dialog.show();
}
function demoInput() {
    const dialog = new InputMessageDialog();
    dialog.initialize();
    const field = document.querySelector("[name='answer']");
    dialog.input.value = field.value;
    dialog.buttonAction = function (action) {
        if (action === "confirm") {
            field.value = dialog.input.value;
            showAlert("Confirmed: " + field.value);
        }
        dialog.remove();
    };
    dialog.show();
}
function demoFormDialog() {
    const dialog = new JSONFormDialog();
    dialog.setResponder("SampleFormResponder");
    dialog.setTitle("A form in a dialog");
    dialog.show();
}
JS);
        parent::finalize();
    }
}

/**
 * The dialogs of the core: MessageDialog (showAlert), ConfirmMessageDialog, InputMessageDialog and a JSONFormDialog -
 * its form comes from SampleFormResponder and is validated there
 */
class DialogsContent extends DemoContent
{
    public function initialize() : void
    {
        $this->start("dialogs", "<p>The dialog templates are rendered once with the page (<code>&lt;template&gt;</code>) " .
            "and shown by JavaScript. <code>JSONFormDialog</code> loads its form from a <code>JSONFormResponder</code> of " .
            "the page (<code>SampleFormResponder</code>), posts it back and shows the validation errors in the dialog.</p>");

        //the templates of the dialogs (MessageDialog - showAlert - comes with every page)
        new ConfirmMessageDialog();
        new InputMessageDialog();
        $dialog = new JSONFormDialog();
        $dialog->setResponder(new SampleFormResponder());
        new DemoDialogsScript();

        $this->row(DataInputFactory::Create(InputType::TEXT, "message", "Message", 0), "Sample message text",
            Button::ActionButton("Show Message", "javascript:demoMessage()"));
        $this->row(DataInputFactory::Create(InputType::TEXT, "question", "Question", 0), "Do you confirm?",
            Button::ActionButton("Show Confirm", "javascript:demoConfirm()"));
        $this->row(DataInputFactory::Create(InputType::TEXT, "answer", "Answer", 0), "",
            Button::ActionButton("Show Input", "javascript:demoInput()"));

        $buttons = new Container(false);
        $buttons->setComponentClass("buttons");
        $buttons->items()->append(Button::ActionButton("Show Form Dialog", "javascript:demoFormDialog()"));
        $this->cmp->items()->append($buttons);
    }

    /**
     * An input and the button of its dialog
     */
    protected function row(DataInput $input, string $value, Button $button) : void
    {
        $input->setValue($value);
        $row = new Container(false);
        $row->setComponentClass("dialog_row");
        $row->items()->append(new InputComponent($input));
        $row->items()->append($button);
        $this->cmp->items()->append($row);
    }

    protected function getContentTitle() : string
    {
        return "Dialogs";
    }
}
