<?php
include_once("class/beans/GalleryPhotosBean.php");
include_once("forms/PhotoForm.php");
include_once("templates/content/BeanEditor.php");
include_once("templates/content/BeanGallery.php");

if (URL::Current()->contains("editID")) {
    $config = BeanEditor::Configure(GalleryPhotosBean::class, PhotoForm::class);
    $config->title = tr("Photo");
}
else {
    $config = BeanGallery::Configure(GalleryPhotosBean::class);
    $config->title = tr("Gallery");
    $config->clearNavigation = true;
}
