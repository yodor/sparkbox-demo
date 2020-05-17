<?php
include_once("session.php");

include_once("class/pages/DemoPage.php");

include_once("class/beans/GalleryPhotosBean.php");

$page = new DemoPage();
$page->addCSS(SPARK_LOCAL . "/css/GalleryTape.css");
$page->addJS(SPARK_LOCAL . "/js/GalleryTape.js");

$bean = new GalleryPhotosBean();
$qry = $bean->query();

$qry->select->fields = $bean->key();
$qry->select->where = 1;

$qry->exec();

$page->startRender();

echo "<div class='custom_gallery GalleryTape'>";

echo "<div class='button left'></div>";

echo "<div class='viewport'>";
echo "<div class='slots'>";
$image_popup = new ImagePopup();
$image_popup->setBean($bean);
$image_popup->setAttribute("rel", "collection1");
$image_popup->setPhotoSize(-1,160);

while ($row = $qry->next()) {

    echo "<div class='slot'>";
    $itemID = $row[$bean->key()];

    $image_popup->setID($itemID);
    $image_popup->render();

    echo "</div>";

}
echo "</div>";//viewport
echo "</div>"; //slots
echo "<div class='button right' ></div>";
echo "</div>";
?>
    <script type='text/javascript'>
        onPageLoad(function () {

            var gallery_tape = new GalleryTape(".custom_gallery");
            gallery_tape.connectGalleryView("collection1");

        });

    </script>
<?php
?>
    <style>

        .ImagePopupPanel .Button[action="CloseImagePopup"] {
            left: 100%;
            top: 0px;
            width: 20px;
            height: 20px;
            margin-left: -30px;
            margin-top: -30px;
        }

        .ImagePopupPanel .Contents {
            padding: 0px;
            box-sizing: border-box;
            position: relative;
            -moz-box-sizing: border-box;
        }

        .top_frame {
            position: absolute;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            border: 10px solid rgba(200, 200, 200, 0.5);
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
    </style>
    <script type='text/javascript'>
        ImagePopup.prototype.processPopupContents = function (html) {

            var contents = $(html);
            contents.find(".Inner .Contents").prepend("<a class='Button' action='CloseImagePopup'>X</a>");

            contents.find(".Inner .Contents").append("<div class='top_frame'></div>");

            var result = contents.get(0).outerHTML;

            return result;
        }

    </script>
<?php
$page->finishRender();
?>