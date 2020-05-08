<?php
include_once("class/pages/ProductsPage.php");
include_once("class/utils/ProductsQuery.php");

class ProductListPage extends ProductsPage
{

    public function __construct()
    {
        parent::__construct();
        $this->addCSS(LOCAL . "css/related_tree.css?ver=1.0");
        $this->addJS(LOCAL . "js/product_list.js?ver=1.2");
    }

}

?>
