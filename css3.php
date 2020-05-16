<?php
include_once("session.php");

include_once("class/pages/DemoPage.php");

$page = new DemoPage();
$page->addCSS(LOCAL . "css/css3.css");
$page->addJS("//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js");
$page->addJS(LOCAL . "js/jqplugins/jquery.mousewheel.min.js");
$page->addJS(LOCAL . "js/jqplugins/jquery.mCustomScrollbar.js");

$page->startRender();

// echo "<div class='gradient1 demo_custom'>";
// drawSampleText();
// echo "</div>";
// 

echo "<div class='scroll_custom'>";
drawSampleText();
echo "</div>";


$page->finishRender();

function drawSampleText()
{
    echo "The Quick Brown Fox Jumps Over The Lazy Dog";
    echo "The Quick Brown Fox Jumps Over The Lazy Dog";
    echo "The Quick Brown Fox Jumps Over The Lazy Dog";
    echo "The Quick Brown Fox Jumps Over The Lazy Dog";


}

?>