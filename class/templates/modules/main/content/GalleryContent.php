<?php
include_once("utils/ImageSizes.php");
include_once("class/templates/modules/main/content/DemoContent.php");
include_once("class/beans/GalleryPhotosBean.php");
include_once("components/ImageSlider.php");
include_once("objects/OrderColumn.php");

/**
 * An ImageSlider strip of the photos of GalleryPhotosBean (in their order), the large photo in the ImagePopup
 */
class GalleryContent extends DemoContent
{
    public function initialize() : void
    {
        $this->start("gallery", "<p><code>ImageSlider</code> shows the rows of a bean query as a strip of photos - " .
            "swipe or the arrows move it, a photo opens in the <code>ImagePopup</code> with the others of its slider. " .
            "The photos are served by the storage of SparkBox in the size the page asks for. " .
            "Upload them in the admin: <a href='" . Spark::Get(Config::LOCAL) . "/admin/demo/gallery'>Demo &gt; Gallery</a>.</p>");

        $bean = new GalleryPhotosBean();
        $query = $bean->query($bean->key(), "caption");
        $query->stmt->order("position", OrderDirection::ASC);

        $slider = new ImageSlider();
        $slider->setName("demo_gallery");
        $slider->setStrip(true);
        $slider->setDots(SliderDots::NONE);
        $slider->setPhotoSize(0, ImageSize::Thumbnail);
        $slider->addRows($query, GalleryPhotosBean::class, null, "caption");
        $this->cmp->items()->append($slider);
    }

    protected function getContentTitle() : string
    {
        return "Image Gallery";
    }
}
