<?php
include_once("utils/ImageSizes.php");
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("class/beans/GalleryPhotosBean.php");
include_once("components/GalleryTape.php");
include_once("objects/OrderColumn.php");

/**
 * GalleryTape of the photos of GalleryPhotosBean (in their order), the large photo in the ImagePopup
 */
class GalleryContent extends DemoContent
{
    public function initialize() : void
    {
        $this->start("gallery", "<p><code>GalleryTape</code> shows the rows of a bean query as a tape of photos - " .
            "swipe or the arrows move it, a photo opens in the <code>ImagePopup</code> with the others of its tape. " .
            "The photos are served by the storage of SparkBox in the size the page asks for. " .
            "Upload them in the admin: <a href='" . Spark::Get(Config::LOCAL) . "/admin/demo/gallery'>Demo &gt; Gallery</a>.</p>");

        $bean = new GalleryPhotosBean();
        $query = $bean->query($bean->key(), "caption");
        $query->stmt->order("position", OrderDirection::ASC);

        $item = new GalleryTapeItem();
        $item->setPhotoSize(0, ImageSize::Thumbnail);
        $item->setBeanClass(GalleryPhotosBean::class);

        $tape = new GalleryTape();
        $tape->setItemRenderer($item);
        $tape->setName("demo_gallery");
        $tape->setIterator($query);
        $this->cmp->items()->append($tape);
    }

    protected function getContentTitle() : string
    {
        return "Image Gallery";
    }
}
