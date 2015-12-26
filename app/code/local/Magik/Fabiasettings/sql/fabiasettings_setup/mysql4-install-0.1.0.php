<?php


$installer = $this;
$installer->startSetup();

$installer->endSetup();

try {
//create pages and blocks programmatically
//home page 1
$cmsPage = array(
    'title' => 'Fabia Home Page1',
    'identifier' => 'fabia_home_one',
    'content' => "<div>{{block type=\"catalog/product_list\" num_products=\"6\" name=\"homelistproduct\" as=\"homelistproduct\" template=\"catalog/product/home-list.phtml\" }}</div>
<div>{{block type=\"cms/block\" block_id=\"fabia_custom_slider_block\"}}</div>
<div>{{block type=\"catalog/product_new\"column_count=\"6\" products_count=\"12\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }}</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_one'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 2
$cmsPage = array(
    'title' => 'Fabia Home Page2',
    'identifier' => 'fabia_home_two',
    'content' => "<div>{{block type=\"catalog/product_list\" num_products=\"6\" name=\"homelistproduct\" as=\"homelistproduct\" template=\"catalog/product/home-list.phtml\" }}</div>
<div>{{block type=\"cms/block\" block_id=\"fabia_custom_slider_block\"}}</div>
<div>{{block type=\"catalog/product_new\"column_count=\"6\" products_count=\"12\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }}</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_two'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 3
$cmsPage = array(
    'title' => 'Fabia Home Page3',
    'identifier' => 'fabia_home_three',
    'content' => "<div>{{block type=\"catalog/product_list\" num_products=\"6\" name=\"homelistproduct\" as=\"homelistproduct\" template=\"catalog/product/home-list.phtml\" }}</div>
<div>{{block type=\"cms/block\" block_id=\"fabia_custom_slider_block\"}}</div>
<div>{{block type=\"catalog/product_new\"column_count=\"6\" products_count=\"12\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }}</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_three'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 4
$cmsPage = array(
    'title' => 'Fabia Home Page4',
    'identifier' => 'fabia_home_four',
    'content' => "<div class=\"main-pro container\">
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12\">
<div class=\"home-tabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">best seller</span></li>
<li class=\"item-nav\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured Products</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-4\">{{block type=\"catalog/product_list\" num_products=\"6\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller.phtml\"}} {{block type=\"catalog/product_list\" num_products=\"6\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/featured.phtml\"}}</div>
</div>
</div>
</div>
</div>
<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated home-rhs\">{{block type=\"cms/block\" block_id=\"fabia_home4_sidebar_block\"}}</div>
</div>
<div>{{block type=\"cms/block\" block_id=\"fabia_home4_banner_bottom_block\"}}</div>
<div>{{block type=\"catalog/product_new\"column_count=\"6\" products_count=\"12\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }}</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_four'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 5
$cmsPage = array(
    'title' => 'Fabia Home Page5',
    'identifier' => 'fabia_home_five',
    'content' => "<div class=\"main-pro container\">
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12\">
<div class=\"home-tabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">best seller</span></li>
<li class=\"item-nav\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured Products</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-4\">{{block type=\"catalog/product_list\" num_products=\"6\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller.phtml\"}} {{block type=\"catalog/product_list\" num_products=\"6\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/featured.phtml\"}}</div>
</div>
</div>
</div>
</div>
<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated home-rhs\">{{block type=\"cms/block\" block_id=\"fabia_home4_sidebar_block\"}}</div>
</div>
<div>{{block type=\"cms/block\" block_id=\"fabia_home4_banner_bottom_block\"}}</div>
<div>{{block type=\"catalog/product_new\"column_count=\"6\" products_count=\"12\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }}</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_five'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 6
$cmsPage = array(
    'title' => 'Fabia Home Page6',
    'identifier' => 'fabia_home_six',
    'content' => "<div class=\"main-container col2-right-layout wow bounceInUp animated\">
<div class=\"main container\">
<div class=\"row\">
<div class=\"col-main col-sm-9 col-xs-12\">
<div>{{block type=\"catalog/product_list\" num_products=\"6\" name=\"homelistproduct\" as=\"homelistproduct\" template=\"catalog/product/home6-list.phtml\" }}</div>
<div>{{block type=\"catalog/product_new\"column_count=\"4\" products_count=\"12\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new-home6.phtml\" }}</div>
<div>{{block type=\"cms/block\" block_id=\"fabia_home_latest_blog_block\"}}</div>
</div>
<div class=\"col-right sidebar col-sm-3 col-xs-12\">
<div>{{block type=\"cms/block\" block_id=\"fabia_home6_sidebar_block\"}}</div>
<div>{{block type=\"catalog/product_list\" num_products=\"6\" name=\"featuredproduct\" as=\"featuredproduct\" template=\"catalog/product/featured-home6.phtml\" }}</div>
<div>{{block type=\"cms/block\" block_id=\"fabia_home6_sidebar1_block\"}}</div>
</div>
</div>
</div>
</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_six'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 7
$cmsPage = array(
    'title' => 'Fabia Home Page7',
    'identifier' => 'fabia_home_seven',
    'content' => "<div class=\"main-pro container\">
<div class=\"home-tabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">best seller</span></li>
<li class=\"item-nav\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured Products</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-5\">{{block type=\"catalog/product_list\" num_products=\"10\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller-home7.phtml\"}} {{block type=\"catalog/product_list\" num_products=\"10\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/featured-home7.phtml\"}}</div>
</div>
</div>
</div>
</div>
<div>{{block type=\"cms/block\" block_id=\"fabia_home4_banner_bottom_block\"}}</div>
<div>{{block type=\"catalog/product_new\"column_count=\"6\" products_count=\"12\" name=\"newproduct\" as=\"newproduct\" template=\"catalog/product/new.phtml\" }}</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_seven'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//home page 8
$cmsPage = array(
    'title' => 'Fabia Home Page8',
    'identifier' => 'fabia_home_eight',
    'content' => "<div class=\"home-tabs\">
<div class=\"producttabs\">
<div id=\"magik_producttabs1\" class=\"magik-producttabs\">
<div class=\"magik-pdt-container\">
<div class=\"magik-pdt-nav\">
<ul class=\"pdt-nav\">
<li class=\"item-nav tab-loaded tab-nav-actived\" data-href=\"pdt_best_sales\" data-orderby=\"best_sales\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">best seller</span></li>
<li class=\"item-nav\" data-href=\"pdt_new_arrivals\" data-orderby=\"new_arrivals\" data-catid=\"\" data-type=\"order\"><span class=\"title-navi\">Featured Products</span></li>
</ul>
</div>
<div class=\"magik-pdt-content wide-4\">{{block type=\"catalog/product_list\" num_products=\"8\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/bestseller-home8.phtml\"}} {{block type=\"catalog/product_list\" num_products=\"8\" name=\"bestsellerproduct\" as=\"bestsellerproduct\" template=\"catalog/product/featured-home8.phtml\"}}</div>
</div>
</div>
</div>
</div>",
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'custom_static_page_eight'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();

//404 page
$cmsPage = array(
    'title' => 'Fabia 404 No Route',
    'identifier' => 'fabia_no_route',
    'content' => '<div class="container">
<div class="std">
<div class="page-not-found wow bounceInRight animated">
<h2>404</h2>
<h3><img src="{{skin url="images/signal.png"}}" alt="" />Oops! The Page you requested was not found!</h3>
<div><a class="btn-home" type="button" href="{{store direct_url="fabia_home_one"}}"><span>Back To Home</span></a></div>
</div>
</div>
</div>
',
    'is_active' => 1,
    'sort_order' => 0,
    'stores' => array(0),
    'root_template' => 'one_column'
);
Mage::getModel('cms/page')->setData($cmsPage)->save();


//footer links
$staticBlock = array(
    'title' => 'Fabia Footer links',
    'identifier' => 'fabia_footer_links',
    'content' => '<div class="col-sm-5 col-xs-12 coppyright">&copy; 2015 Magikcommerce. All Rights Reserved.</div>
<div class="col-sm-7 col-xs-12 company-links">
<ul class="links">
<li><a title="Magento Themes" href="http://www.magikcommerce.com/magento-themes-templates">Magento Themes</a></li>
<li><a title="Premium Themes" href="#">Premium Themes</a></li>
<li><a title="Responsive Themes" href="http://www.magikcommerce.com/magento-themes-templates/responsive-themes">Responsive Themes</a></li>
<li class="last"><a title="Magento Extensions" href="http://www.magikcommerce.com/magento-extensions">Magento Extensions</a></li>
</ul>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();
}
catch (Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while installing fabia theme pages and cms blocks.'));
}