<?php
include_once("session.php");

include_once("class/pages/DemoPage.php");
include_once("class/beans/GalleryPhotosBean.php");

$page = new DemoPage();
$page->addCSS(SPARK_LOCAL . "/css/GalleryTape.css");
$page->addJS(SPARK_LOCAL . "/js/GalleryTape.js");

$bean = new GalleryPhotosBean();
$qry = $bean->query();
$qry->select->order_by = " position ASC ";
$qry->select->fields()->set($bean->key());


$qry->exec();

$page->startRender();

echo "<div class='image_gallery GalleryTape'>";

echo "<div class='button left'></div>";

echo "<div class='viewport'>";
echo "<div class='slots'>";

$pos = 0;
$image_popup = new ImagePopup();
$image_popup->setBean($bean);
$image_popup->setAttribute("rel", "collection2");
$image_popup->setPhotoSize(-1,160);

while ($row = $qry->next()) {

    echo "<div class='slot'>";
    $itemID = $row[$bean->key()];

    $image_popup->setAttribute("name", "gallery_tape.".$pos);
    $image_popup->setID($itemID);

    $image_popup->render();

    echo "</div>";
    $pos++;
}
echo "</div>";//viewport
echo "</div>"; //slots
echo "<div class='button right' ></div>";
echo "</div>";
?>
<script type='text/javascript'>
    onPageLoad(function () {

        var gallery_tape = new GalleryTape(".image_gallery");
        gallery_tape.connectGalleryView("collection2");

    });

</script>
<?php
$page->finishRender();
?>
