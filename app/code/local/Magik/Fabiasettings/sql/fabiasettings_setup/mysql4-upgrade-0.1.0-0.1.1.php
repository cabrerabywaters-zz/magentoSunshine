<?php


$installer = $this;
$installer->startSetup();
$installer->endSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('catalog_product', 'magikfeatured', array(
        'group'             => 'General',
        'type'              => 'int',
        'backend'           => '',
        'frontend'          => '',
        'label'             => 'Featured Product On Home',
        'input'             => 'boolean',
        'class'             => '',
        'source'            => '',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'           => true,
        'required'          => false,
        'user_defined'      => true,
        'default'           => '0',
        'searchable'        => false,
        'filterable'        => false,
        'comparable'        => false,
        'visible_on_front'  => false,
        'unique'            => false,
        'apply_to'          => 'simple,configurable,virtual,bundle,downloadable',
        'is_configurable'   => false
    ));

try {
//create pages and blocks programmatically

//Custom Tab1
$staticBlock = array(
    'title' => 'Custom Tab1',
    'identifier' => 'fabia_custom_tab1',
    'content' => "<p><strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Custom Tab2
$staticBlock = array(
    'title' => 'Custom Tab2',
    'identifier' => 'fabia_custom_tab2',
    'content' => "<p><strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Empty Category
$staticBlock = array(
    'title' => 'Empty Category',
    'identifier' => 'fabia_empty_category',
    'content' => "<p>There are no products matching the selection.<br /> This is a static CMS block displayed if category is empty. You can put your own content here.</p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Logo Brand block
 $staticBlock = array(
     'title' => 'Fabia Logo Brand block',
     'identifier' => 'fabia_logo_brand_block',
     'content' => '<div class="brand-logo wow bounceInUp animated">
<div class="container">
<div class="new_title center">
<h2>TOP BRANDS</h2>
</div>
<div class="slider-items-products">
<div id="brand-logo-slider" class="product-flexslider hidden-buttons">
<div class="slider-items slider-width-col6">
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo1.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo2.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo3.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo4.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo5.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo6.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo2.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo3.png"}}" alt="brand-logo" /></a></div>
</div>
</div>
</div>
</div>
</div>',
     'is_active' => 1,
     'stores' => array(0)
 );
 Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Store Logo
$staticBlock = array(
    'title' => 'Fabia Store Logo',
    'identifier' => 'fabia_logo',
    'content' => '<div><img src="{{skin url="images/logo.png"}}" alt="Fabia Store" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


// fabia navigation block
$staticBlock = array(
    'title' => 'Custom',
    'identifier' => 'fabia_navigation_block',
    'content' => '<div class="grid12-3">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<div class="heart-icon">&nbsp;</div>
<p>Our designed to deliver almost everything you want to do online.</p>
<div><img src="{{skin url="images/custom-img1.jpg"}}" alt="custom-image" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<div class="icon-star">&nbsp;</div>
<p>Responsive design is a Web design to provide an optimal navigation.</p>
<div><img src="{{skin url="images/custom-img2.jpg"}}" alt="custom-image" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<div class="custom-icon">&nbsp;</div>
<p>Our font delivery service is built upon a reliable, global network of servers.</p>
<div><img src="{{skin url="images/custom-img3.jpg"}}" alt="custom-image" /></div>
</div>
<div class="grid12-3">
<h4 class="heading">GET 20% OFF, 48 HOURS ONLY!</h4>
<div class="icon-custom-grid">&nbsp;</div>
<p>Smart Product Grid is uses maximum available width of the screen.</p>
<div><img src="{{skin url="images/custom-img4.jpg"}}" alt="custom-image" /></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

// fabia navigation block
$staticBlock = array(
    'title' => 'Custom',
    'identifier' => 'fabia_navigation5_block',
    'content' => '<div class="normal-text">
<div class="custom_link">
<div class="grid3"><a href="#">OUR RECOMMENDATIONS</a></div>
</div>
<div class="grid4 a-right"><a style="color: #cd2122; font-style: italic;" href="#">SEE MORE</a></div>
</div>
<div>{{block type="catalog/product" name="topmenulist" as="topmenulist" num_products="3" template="catalog/product/top-menu-list.phtml" }}</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();



//Fabia Home Banner Block
$staticBlock = array(
    'title' => 'Fabia Home Offer Banner Block',
    'identifier' => 'fabia_home_offer_banner_block',
    'content' => '<div class="top-banner-section">
<div class="container">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/block1.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/block2.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="ccol-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/bloc3.jpg"}}" alt="offer banner3" /></a></div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Home Header Block
$staticBlock = array(
    'title' => 'Fabia Header Block',
    'identifier' => 'fabia_header_block',
    'content' => '<div class="header-banner">
<div class="assetBlock">
<div id="slideshow" style="height: 20px; overflow: hidden;">
<p>Final DAYS! - <span>50%</span> OFF NEW SEASON ARRIVALS &gt;</p>
<p><span>5%</span> Discount! - on selected items &gt;</p>
</div>
</div>
<div class="our-features-box">
<div class="container">
<ul>
<li>
<div class="feature-box">
<div class="icon-truck">&nbsp;</div>
<div class="content">FREE SHIPPING on order over $99</div>
</div>
</li>
<li>
<div class="feature-box">
<div class="icon-support">&nbsp;</div>
<div class="content">Need Help +1 800 123 1234</div>
</div>
</li>
<li>
<div class="feature-box">
<div class="icon-money">&nbsp;</div>
<div class="content">Money Back Guarantee</div>
</div>
</li>
<li class="last">
<div class="feature-box">
<div class="icon-return">&nbsp;</div>
<div class="content">30 days return Service</div>
</div>
</li>
</ul>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


//Fabia Listing Page Block
$staticBlock = array(
    'title' => 'Fabia Listing Page Block',
    'identifier' => 'fabia_listing_page_block',
    'content' => '<div class="hot-banner"><img src="{{skin url="images/hot-trends-banner.jpg"}}" alt="banner" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


//Fabia Home Slider Banner Block
$staticBlock = array(
    'title' => 'Fabia Home Slider Banner Block',
    'identifier' => 'fabia_home_slider_banner_block',
    'content' => '<div id="magik-slideshow" class="magik-slideshow">
<div class="container">
<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
<div id="rev_slider_4" class="rev_slider fullwidthabanner">
<ul>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-img1.jpg"}}" alt="" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="165" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>New Season</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="220" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Summer Sale</span></div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="410" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Shop Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
</div>
</li>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-img2.jpg"}}" alt="" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft slide2  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;" data-x="45" data-y="165" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Women Sale</div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="220" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Go Lightly</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="400" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Buy Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</div>
</li>
</ul>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Footer Information Links Block
$staticBlock = array(
    'title' => 'Fabia Footer Information Links Block',
    'identifier' => 'fabia_footer_information_links_block',
    'content' => '<div class="footer-column pull-left">
<h4>Shopping Guide</h4>
<ul class="links">
<li class="first"><a title="How to buy" href="{{store_url=blog}}">Blog</a></li>
<li><a title="FAQs" href="#">FAQs</a></li>
<li><a title="Payment" href="#">Payment</a></li>
<li><a title="Shipment" href="#">Shipment</a></li>
<li><a title="Where is my order?" href="#">Where is my order?</a></li>
<li class="last"><a title="Return policy" href="#">Return policy</a></li>
</ul>
</div>
<div class="footer-column pull-left">
<h4>Style Advisor</h4>
<ul class="links">
<li class="first"><a title="Your Account" href="{{store_url=customer/account/}}">Your Account</a></li>
<li><a title="Information" href="#">Information</a></li>
<li><a title="Addresses" href="#">Addresses</a></li>
<li><a title="Addresses" href="#">Discount</a></li>
<li><a title="Orders History" href="#">Orders History</a></li>
<li class="last"><a title=" Additional Information" href="#"> Additional Information</a></li>
</ul>
</div>
<div class="footer-column pull-left">
<h4>Information</h4>
<ul class="links">
<li class="first"><a title="Site Map" href="{{store_url=catalog/seo_sitemap/category/}}">Site Map</a></li>
<li><a title="Search Terms" href="{{store_url=catalogsearch/term/popular/}}">Search Terms</a></li>
<li><a title="Advanced Search" href="{{store_url=catalogsearch/advanced/}}">Advanced Search</a></li>
<li><a title="History" href="{{store_url=about-us}} ">About Us</a></li>
<li><a title="History" href="{{store_url=contacts}} ">Contact Us</a></li>
<li><a title="Suppliers" href="#">Suppliers</a></li>
</ul>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Home Latest Blog Block
$staticBlock = array(
    'title' => 'Fabia Home Latest Blog Block',
    'identifier' => 'fabia_home_latest_blog_block',
    'content' => '<div class="latest-blog wow bounceInUp animated">{{block type="blogmate/index" name="blog_home" template="blogmate/right/home_right.phtml"}}</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Blog Banner Text Block
$staticBlock = array(
    'title' => 'Fabia Blog Banner Text Block',
    'identifier' => 'fabia_blog_banner_text_block',
    'content' => '<div class="text-widget widget widget__sidebar">
<h3 class="widget-title">Text Widget</h3>
<div class="widget-content">Mauris at blandit erat. Nam vel tortor non quam scelerisque cursus. Praesent nunc vitae magna pellentesque auctor. Quisque id lectus.<br /> <br /> Massa, eget eleifend tellus. Proin nec ante leo ssim nunc sit amet velit malesuada pharetra. Nulla neque sapien, sollicitudin non ornare quis, malesuada.</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Blog Banner Ad Block
$staticBlock = array(
    'title' => 'Fabia Blog Banner Ad Block',
    'identifier' => 'fabia_blog_banner_ad_block',
    'content' => '<div class="ad-spots widget widget__sidebar">
<h3 class="widget-title">Ad Spots</h3>
<div class="widget-content"><a title="" href="#" target="_self"><img src="{{skin url="images/block-banner.png"}}" alt="offer banner" /></a></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Home 1 Tab Dropdown Block
$staticBlock = array(
    'title' => 'Fabia Home Tab Dropdown Block',
    'identifier' => 'fabia_home_tab_dropdown_block',
    'content' => '<ul class="level1" style="display: none;">
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabia"><span>Home Version 1</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo2"><span>Home Version 2</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo3"><span>Home Version 3</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo4"><span>Home Version 4</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo5"><span>Home Version 5</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo6"><span>Home Version 6</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo7"><span>Home Version 7</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo8"><span>Home Version 8</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo9"><span>Home Version 9</span></a></li>
<li class="level1 parent"><a href="http://demo.magikthemes.com/index.php/fabiademo10"><span>RTL</span></a></li>
</ul>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Home 1 Tab Dropdown Block
$staticBlock = array(
    'title' => 'Fabia Home7 Tab Dropdown Block',
    'identifier' => 'fabia_home7_tab_dropdown_block',
    'content' => '<ul class="submenu">
<li><a href="http://demo.magikthemes.com/index.php/fabia">Home Version 1</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo2">Home Version 2</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo3">Home Version 3</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo4">Home Version 4</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo5">Home Version 5</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo6">Home Version 6</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo7">Home Version 7</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo8">Home Version 8</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo9">Home Version 9</a></li>
<li><a href="http://demo.magikthemes.com/index.php/fabiademo10">RTL</a></li>
</ul>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


//Fabia Footer Contact Us
$staticBlock = array(
    'title' => 'Fabia Footer Contact Us',
    'identifier' => 'fabia_footer_contact_us',
    'content' => '<div class="row">
<div style="text-align: center;"><img src="{{skin url="images/footer-logo.png"}}" alt="footer logo" /></div>
<address><em class="icon-location-arrow"></em> 123 Main Street, Anytown, CA 12345 USA <em class="icon-mobile-phone"></em><span> +(408) 394-7557</span> <em class="icon-envelope"></em><span> support@magikcommerce.com</span></address></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Detail Page Static Block',
    'identifier' => 'fabia_detail_page_static_block',
    'content' => '<div class="col-sm-3 col-xs-12 hot-banner"><img src="{{skin url="images/hot-trends-banner.jpg"}}" alt="banner-image" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home3 Offer Banner Block',
    'identifier' => 'fabia_home3_offer_banner_block',
    'content' => '<div class="offer-section">
<div class="container">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated">
<div class="col"><a href="#"><img src="{{skin url="images/offer-img1.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated">
<div class="col"><a href="#"><img src="{{skin url="images/offer-img2.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated">
<div class="col"><a href="#"><img src="{{skin url="images/offer-img3.jpg"}}" alt="offer banner3" /></a></div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();




$staticBlock = array(
    'title' => 'Fabia Contact Us Block',
    'identifier' => 'fabia_contact_us_block',
    'content' => '<div class="block block-company">
<div class="block-title">Company</div>
<div class="block-content"><ol id="recently-viewed-items">
<li class="item odd"><a href="{{store_url=about-us}}">About Us</a></li>
<li class="item even"><a href="{{store_url=catalog/seo_sitemap/category/}}">Sitemap</a></li>
<li class="item  odd"><a href="#">Terms of Service</a></li>
<li class="item last"><a href="{{store_url=catalogsearch/term/popular/}}">Search Terms</a></li>
<li class="item last"><a href="{{store_url=contacts/}}"><strong>Contact Us</strong></a></li>
</ol></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Custom Slider Block',
    'identifier' => 'fabia_custom_slider_block',
    'content' => '<div class="offer-slider wow animated parallax parallax-2">
<div class="container">
<ul class="bxslider">
<li>
<h2>NEW ARRIVALS</h2>
<h1>Sale up to 30% off</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat.</p>
<a class="shop-now" href="#">Shop now</a></li>
<li>
<h2>Hello hotness!</h2>
<h1>Summer collection</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat.</p>
<a class="shop-now" href="#">View More</a></li>
<li>
<h2>New launch</h2>
<h1>Designer dresses on sale</h1>
<p>Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Integer sed arcu massa.</p>
<a class="shop-now" href="#">Learn More</a></li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home Sidebar Block',
    'identifier' => 'fabia_home_sidebar_block',
    'content' => '<div class="sale-offer-box">
<div class="sale-offer-left"><img src="{{skin url="images/sale-offer.png"}}" alt="sale-offer" /></div>
<div class="sale-offer-right"><img src="{{skin url="images/sale-offer1.png"}}" alt="sale-offer1" /></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Footer Payment Links',
    'identifier' => 'fabia_footer_payment_links',
    'content' => '<div class="payment-accept">
<div><img src="{{skin url="images/payment-1.png"}}" alt="payment1" /> <img src="{{skin url="images/payment-2.png"}}" alt="payment2" /> <img src="{{skin url="images/payment-3.png"}}" alt="payment3" /> <img src="{{skin url="images/payment-4.png"}}" alt="payment4" /></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Offer Bottom Banner Block',
    'identifier' => 'fabia_offer_bottom_banner_block',
    'content' => '<div class="our-features-box wow bounceInUp animated">
<ul>
<li>
<div class="feature-box">
<div class="icon-truck">&nbsp;</div>
<div class="content">FREE SHIPPING on order over $99</div>
</div>
</li>
<li>
<div class="feature-box">
<div class="icon-support">&nbsp;</div>
<div class="content">Need Help +1 800 123 1234</div>
</div>
</li>
<li>
<div class="feature-box">
<div class="icon-money">&nbsp;</div>
<div class="content">Money Back Guarantee</div>
</div>
</li>
<li class="last">
<div class="feature-box">
<div class="icon-return">&nbsp;</div>
<div class="content">30 days return Service</div>
</div>
</li>
</ul>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Store Logo3',
    'identifier' => 'fabia_logo3',
    'content' => '<div><img src="{{skin url="images/logo3.png"}}" alt="Fabia Store" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home3 Header Offer Banner Block',
    'identifier' => 'fabia_home3_header_offer_banner_block',
    'content' => '<div class="header-banner">
<div class="assetBlock">
<div id="slideshow" style="height: 20px; overflow: hidden;">
<p style="display: block;">Final DAYS! - <span>50%</span> OFF NEW SEASON ARRIVALS &gt;</p>
<p style="display: none;"><span>5%</span> Discount! - on selected items &gt;</p>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home3 Slider Banner Block',
    'identifier' => 'fabia_home3_slider_banner_block',
    'content' => '<div id="magik-slideshow" class="magik-slideshow">
<div class="container">
<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
<div id="rev_slider_4" class="rev_slider fullwidthabanner">
<ul>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-img1-home2.jpg"}}" alt="" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="165" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Get 50% off on all items</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="220" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>HANDBAGS</span></div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="410" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Shop Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
</div>
</li>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-img2-home2.jpg"}}" alt="" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;" data-x="45" data-y="165" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>hot offer</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="220" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">OUR Fabia SHOP</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="400" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Buy Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</div>
</li>
</ul>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Listing Page Block2',
    'identifier' => 'fabia_listing_page_block2',
    'content' => '<div class="custom-slider">
<div>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel"><ol class="carousel-indicators">
<li class="active" data-target="#carousel-example-generic" data-slide-to="0"></li>
<li data-target="#carousel-example-generic" data-slide-to="1"></li>
<li data-target="#carousel-example-generic" data-slide-to="2"></li>
</ol>
<div class="carousel-inner">
<div class="item active"><img src="{{skin url="images/slide3.jpg"}}" alt="slide3" />
<div class="carousel-caption">
<h3><a title=" Sample Product" href="product-detail.html">50% OFF</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<a class="link" href="#">Buy Now</a></div>
</div>
<div class="item"><img src="{{skin url="images/slide1.jpg"}}" alt="slide1" />
<div class="carousel-caption">
<h3><a title=" Sample Product" href="product-detail.html">Hot collection</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>
</div>
<div class="item"><img src="{{skin url="images/slide2.jpg"}}" alt="slide2" />
<div class="carousel-caption">
<h3><a title=" Sample Product" href="product-detail.html">Summer collection</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>
</div>
</div>
<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"> <span class="sr-only">Next</span> </a></div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home4 Header Block',
    'identifier' => 'fabia_home4_header_block',
    'content' => '<div class="header-banner">
<div class="assetBlock">
<p><a href="#">Final Days ! - <span>50%</span> OFF NEW SEASON ARRIVALS &gt; </a></p>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home4 Slider Banner Block',
    'identifier' => 'fabia_home4_slider_banner_block',
    'content' => '<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
<div id="rev_slider_4" class="rev_slider fullwidthabanner">
<ul>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-home4-img1.jpg"}}" alt="slider img" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="105" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">New Season</div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="150" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Hot Deal</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Shop Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="250" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
</div>
</li>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-home4-img2.jpg"}}" alt="slider img" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft slide2  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;" data-x="45" data-y="105" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">laptop Sale</div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="150" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Mega Sale</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Buy Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="250" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</div>
</li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home4 RHS Banner Block',
    'identifier' => 'fabia_home4_rhs_banner_block',
    'content' => '<div class="offer-banner"><a href="#"><img src="{{skin url="images/RHS-banner.jpg"}}" alt="offer banner3" /></a></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home4 Offer Banner Block',
    'identifier' => 'fabia_home4_offer_banner_block',
    'content' => '<div class="top-banner-section">
<div class="container">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/block1-home4.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/block2-home4.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/block3-home4.jpg"}}" alt="offer banner3" /></a></div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home4 Sidebar Block',
    'identifier' => 'fabia_home4_sidebar_block',
    'content' => '<div class="offer-banner"><a href="#"><img src="{{skin url="images/side-banner.jpg"}}" alt="offer banner3" /></a></div>
<div class="offer-banner"><a href="#"><img src="{{skin url="images/electronic-banner.jpg"}}" alt="offer banner3" /></a></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home4 Banner Bottom Block',
    'identifier' => 'fabia_home4_banner_bottom_block',
    'content' => '<div class="full-width-banner home-rhs">
<div class="container offer-banner"><a href="#"><img src="{{skin url="images/full-width-banner.jpg"}}" alt="offer banner3" /></a></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home6 Slider Banner Block',
    'identifier' => 'fabia_home6_slider_banner_block',
    'content' => '<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
<div id="rev_slider_4" class="rev_slider fullwidthabanner">
<ul>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-home6-img1.jpg"}}" alt="image1" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="165" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>New Season</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="220" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Summer Sale</span></div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="380" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Shop Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
</div>
</li>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-home6-img2.jpg"}}" alt="image2" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft slide2  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;" data-x="45" data-y="165" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><span>Hot Sale</span></div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="220" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Go Lightly</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="380" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Buy Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="45" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</div>
</li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home6 LHS Block',
    'identifier' => 'fabia_home6_lhs_block',
    'content' => '<div class="side-banner"><img src="{{skin url="images/side-banner.png"}}" alt="side banner" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home6 Offer Banner Block',
    'identifier' => 'fabia_home6_offer_banner_block',
    'content' => '<div class="top-banner-section wow bounceInUp animated">
<div class="container">
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/block1-home6.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/block2-home6.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/bloc3-home6.jpg"}}" alt="offer banner3" /></a></div>
</div>
<div class="ccol-lg-3 col-md-3 col-sm-3 col-xs-12 wow bounceup animated" style="visibility: visible;">
<div class="col"><a href="#"><img src="{{skin url="images/block3-home6.jpg"}}" alt="offer banner3" /></a></div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home6 Sidebar Block',
    'identifier' => 'fabia_home6_sidebar_block',
    'content' => '<div class="sidebar-banner"><img src="{{skin url="images/RHS-banner-home6.jpg"}}" alt="home banner" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home6 Sidebar1 Block',
    'identifier' => 'fabia_home6_sidebar1_block',
    'content' => '<div class="sidebar-banner wow bounceInUp animated"><img src="{{skin url="images/RHS-banner1-home6.jpg"}}" alt="home banner" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Footer4 Contact Us',
    'identifier' => 'fabia_footer4_contact_us',
    'content' => '<div class="row">
<div style="text-align: center;"><img src="{{skin url="images/footer4-logo.png"}}" alt="footer logo" /></div>
<address><em class="icon-location-arrow"></em> 123 Main Street, Anytown, CA 12345 USA <em class="icon-mobile-phone"></em><span> +(408) 394-7557</span> <em class="icon-envelope"></em><span> support@magikcommerce.com</span></address></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Store Logo8',
    'identifier' => 'fabia_logo8',
    'content' => '<div><img src="{{skin url="images/logo8.png"}}" alt="Fabia Store" /></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home8 Slider Banner Block',
    'identifier' => 'fabia_home8_slider_banner_block',
    'content' => '<div id="magik-slideshow" class="magik-slideshow">
<div class="container">
<div>
<div class="wow bounceInUp animated">
<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
<div id="rev_slider_4" class="rev_slider fullwidthabanner">
<ul>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-home8-img1.jpg"}}" alt="banner" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; white-space: nowrap;" data-x="0" data-y="80" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Incredible!</div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; white-space: nowrap;" data-x="0" data-y="130" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Sofa Bed</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; white-space: nowrap;" data-x="0" data-y="360" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="view-more" href="#">View More</a> <a class="buy-btn" href="#">Buy Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; white-space: nowrap;" data-x="0" data-y="250" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">In augue urna, nunc, tincidunt, augue,<br /> augue facilisis facilisis.</div>
<div class="tp-caption Title sft  tp-resizeme-small " style="z-index: 4; white-space: nowrap; font-size: 11px;" data-x="0" data-y="400" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</li>
<li class="black-text" data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-home8-img2.jpg"}}" alt="banner" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; white-space: nowrap;" data-x="0" data-y="120" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">New launch</div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; white-space: nowrap;" data-x="0" data-y="180" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Go Lightly</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; white-space: nowrap;" data-x="0" data-y="360" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="view-more" href="#">View More</a> <a class="buy-btn" href="#">Buy Now</a></div>
<div class="tp-caption Title sft  tp-resizeme-small " style="z-index: 4; white-space: nowrap; font-size: 11px;" data-x="0" data-y="400" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</li>
</ul>
<div class="tp-bannertimer">&nbsp;</div>
</div>
</div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home8 Offer Banner Block',
    'identifier' => 'fabia_home8_offer_banner_block',
    'content' => '<div class="offer-banner-section">
<div class="container">
<div class="row">
<div class="col-lg-4 col-xs-12 col-sm-4 wow bounceInUp animated"><a href="#"><img src="{{skin url="images/banner3-home8.jpg"}}" alt="offer banner1" /></a></div>
<div class="col-lg-4 col-xs-12 col-sm-4 wow bounceInUp animated"><a href="#"><img src="{{skin url="images/banner2-home8.jpg"}}" alt="offer banner2" /></a></div>
<div class="col-lg-4 col-xs-12 col-sm-4 wow bounceInUp animated"><a href="#"><img src="{{skin url="images/banner1-home8.jpg"}}" alt="offer banner3" /></a></div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home8 Logo Brand Block',
    'identifier' => 'fabia_home8_logo_brand_block',
    'content' => '<div class="brand-logo ">
<div class="container">
<div class="slider-items-products">
<div id="brand-logo-slider" class="product-flexslider hidden-buttons">
<div class="slider-items slider-width-col6">
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo1.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo2.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo3.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo4.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo5.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo6.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo2.png"}}" alt="brand-logo" /></a></div>
<div class="item"><a href="#x"><img src="{{skin url="images/b-logo3.png"}}" alt="brand-logo" /></a></div>
</div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home8 Footer About Us',
    'identifier' => 'fabia_home8_footer_about_us',
    'content' => '<div class="footer-logo"><a title="Logo" href="#"><img src="{{skin url="images/footer-logo8.png"}}" alt="logo" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus diam arcu.</p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home8 Offer Bottom Banner Block',
    'identifier' => 'fabia_home8_offer_bottom_banner_block',
    'content' => '<div class="our-features-box ">
<div class="container">
<div class="row">
<ul>
<li class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="feature-box">
<div class="icon-truck">&nbsp;</div>
<div class="content">FREE SHIPPING on order over $99</div>
</div>
</li>
<li class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="feature-box">
<div class="icon-support">&nbsp;</div>
<div class="content">Need Help +1 800 123 1234</div>
</div>
</li>
<li class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="feature-box">
<div class="icon-money">&nbsp;</div>
<div class="content">Money Back Guarantee</div>
</div>
</li>
<li class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="feature-box">
<div class="icon-return">&nbsp;</div>
<div class="content">30 days return Service</div>
</div>
</li>
</ul>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home5 Footer Links',
    'identifier' => 'fabia_home5_footer_links',
    'content' => '<div class="col-lg-3 col-sm-6 col-xs-12 coppyright">&copy; Copyright 2015. All Rights Reserved.</div>
<div class="col-lg-2 col-sm-6 col-xs-12 company-links">
<ul class="links">
<li><a title="Magento Themes" href="#">Blog</a></li>
<li><a title="Premium Themes" href="#">About Us</a></li>
<li><a title="Premium Themes" href="#">Contact Us</a></li>
</ul>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


$staticBlock = array(
    'title' => 'Fabia Home5 Slider Banner Block',
    'identifier' => 'fabia_home5_slider_banner_block',
    'content' => '<ol class="carousel-indicators">
<li data-target="#myCarousel" data-slide-to="0"></li>
<li data-target="#myCarousel" data-slide-to="1"></li>
<li data-target="#myCarousel" data-slide-to="2"></li>
</ol>
<div class="carousel-inner">
<div class="item active">
<div class="fill" style="background-image: url("{{skin url="images/slide-home5-img1.jpg"}}");">&nbsp;</div>
<div class="carousel-caption">
<h3>Celebrate!</h3>
<h2>Huge Discount</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.</p>
</div>
</div>
<div class="item">
<div class="fill" style="background-image: url("{{skin url="images/slide-home5-img2.jpg"}}");">&nbsp;</div>
<div class="carousel-caption">
<h3>Hot Point</h3>
<h2>10% OFF on Fabia</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.</p>
</div>
</div>
<div class="item">
<div class="fill" style="background-image: url("{{skin url="images/slide-home5-img3.jpg"}}");">&nbsp;</div>
<div class="carousel-caption">
<h3>Event</h3>
<h2>10% OFF on Fabia</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.</p>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home5 Footer About Us',
    'identifier' => 'fabia_home5_footer_about_us',
    'content' => '<div class="col-md-3 col-sm-4">
<div class="footer-logo"><a title="Logo" href="#"><img src="{{skin url="images/footer-home5-logo.png"}}" alt="" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus diam arcu, placerat ut odio vel, ultrices vehicula erat. Ut mauris diam, egestas nec lacus sit amet.</p>
<a class="buy-theme" title="Buy this theme" href="#">Buy this theme<em class="icon-angle-right">&nbsp;</em></a></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Footer5 Contact Us',
    'identifier' => 'fabia_footer5_contact_us',
    'content' => '<div class="col-md-3 col-sm-4">
<h4>Contact us</h4>
<div class="contacts-info"><address><em class="add-icon">&nbsp;</em>123 Main Street, Anytown, <br /> &nbsp;CA 12345 USA</address>
<div class="phone-footer"><em class="phone-icon">&nbsp;</em> +1 800 123 1234</div>
<div class="email-footer"><em class="email-icon">&nbsp;</em> <a href="#">support@magikcommerce.com</a></div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home5 Footer Information Links Block',
    'identifier' => 'fabia_home5_footer_information_links_block',
    'content' => '<div class="col-md-2 col-sm-4">
<h4>Shopping Guide</h4>
<ul class="links">
<li class="first"><a title="How to buy" href="{{store_url=blog}}">Blog</a></li>
<li><a title="FAQs" href="#">FAQs</a></li>
<li><a title="Payment" href="#">Payment</a></li>
<li><a title="Shipment" href="#">Shipment</a></li>
<li><a title="Where is my order?" href="#">Where is my order?</a></li>
<li class="last"><a title="Return policy" href="#">Return policy</a></li>
</ul>
</div>
<div class="col-md-2 col-sm-4">
<h4>Style Advisor</h4>
<ul class="links">
<li class="first"><a title="Your Account" href="{{store_url=customer/account/}}">Your Account</a></li>
<li><a title="Information" href="#">Information</a></li>
<li><a title="Addresses" href="#">Addresses</a></li>
<li><a title="Addresses" href="#">Discount</a></li>
<li><a title="Orders History" href="#">Orders History</a></li>
<li class="last"><a title=" Additional Information" href="#"> Additional Information</a></li>
</ul>
</div>
<div class="col-md-2 col-sm-4">
<h4>Information</h4>
<ul class="links">
<li class="first"><a title="Site Map" href="{{store_url=catalog/seo_sitemap/category/}}">Site Map</a></li>
<li><a title="Search Terms" href="{{store_url=catalogsearch/term/popular/}}">Search Terms</a></li>
<li><a title="Advanced Search" href="{{store_url=catalogsearch/advanced/}}">Advanced Search</a></li>
<li><a title="History" href="{{store_url=about-us}} ">About Us</a></li>
<li><a title="History" href="{{store_url=contacts}} ">Contact Us</a></li>
<li><a title="Suppliers" href="#">Suppliers</a></li>
</ul>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home7 Slider Banner Block',
    'identifier' => 'fabia_home7_slider_banner_block',
    'content' => '<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
<div id="rev_slider_4" class="rev_slider fullwidthabanner">
<ul>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-home7-img1.jpg"}}" alt="slider img" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="105" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">New Season</div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="150" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Hot Deal</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Shop Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="250" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">In augue urna, nunc, tincidunt, augue, augue facilisis facilisis.</div>
</div>
</li>
<li data-transition="random" data-slotamount="7" data-masterspeed="1000"><img src="{{skin url="images/slide-home7-img2.jpg"}}" alt="slider img" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" />
<div class="info">
<div class="tp-caption ExtraLargeTitle sft slide2  tp-resizeme " style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; padding-right: 0px;" data-x="0" data-y="105" data-endspeed="500" data-speed="500" data-start="1100" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Mens</div>
<div class="tp-caption LargeTitle sfl  tp-resizeme " style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="150" data-endspeed="500" data-speed="500" data-start="1300" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Mega Sale</div>
<div class="tp-caption sfb  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="320" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Linear.easeNone" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1"><a class="buy-btn" href="#">Buy Now</a></div>
<div class="tp-caption Title sft  tp-resizeme " style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;" data-x="0" data-y="250" data-endspeed="500" data-speed="500" data-start="1500" data-easing="Power2.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</div>
</li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home7 Footer Information Links Block',
    'identifier' => 'fabia_home7_footer_information_links_block',
    'content' => '<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Shopping Guide</h4>
<ul class="links">
<li class="first"><a title="How to buy" href="#">How to buy</a></li>
<li><a title="FAQs" href="#">FAQs</a></li>
<li><a title="Payment" href="#">Payment</a></li>
<li><a title="Shipment" href="#">Shipment</a></li>
<li><a title="Where is my order?" href="#">Where is my order?</a></li>
<li class="last"><a title="Return policy" href="#">Return policy</a></li>
</ul>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Style Advisor</h4>
<ul class="links">
<li class="first"><a title="Your Account" href="#">Your Account</a></li>
<li><a title="Information" href="#">Information</a></li>
<li><a title="Addresses" href="#">Addresses</a></li>
<li><a title="Addresses" href="#">Discount</a></li>
<li><a title="Orders History" href="#">Orders History</a></li>
<li class="last"><a title=" Additional Information" href="#">Additional Information</a></li>
</ul>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Information</h4>
<ul class="links">
<li class="first"><a title="Site Map" href="#">Site Map</a></li>
<li><a title="Search Terms" href="#">Search Terms</a></li>
<li><a title="Advanced Search" href="#">Advanced Search</a></li>
<li><a title="Contact Us" href="contact-us.html">Contact Us</a></li>
<li><a title="Suppliers" href="#">Suppliers</a></li>
<li class=" last"><a class="link-rss" title="Our stores" href="#">Our stores</a></li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Fabia Home5 Offer Bottom Banner Block
$staticBlock = array(
    'title' => 'Fabia Home5 Offer Bottom Banner Block',
    'identifier' => 'fabia_home5_offer_bottom_banner_block',
    'content' => '<div class="our-features-box bounceInUp animated">
<div class="container">
<div class="row">
<div class="col-md-4 col-xs-12 col-sm-4">
<div class="feature-box">
<div class="icon-truck">&nbsp;</div>
<div class="content">Free Shipping</div>
<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span></div>
</div>
<div class="col-md-4 col-xs-12 col-sm-4">
<div class="feature-box">
<div class="icon-love">&nbsp;</div>
<div class="content">Customer Support</div>
<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span></div>
</div>
<div class="col-md-4 col-xs-12 col-sm-4">
<div class="feature-box">
<div class="icon-return">&nbsp;</div>
<div class="content">30 days money back</div>
<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span></div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home7 Footer Information Links Block',
    'identifier' => 'fabia_home7_footer_information_links_block',
    'content' => '<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Shopping Guide</h4>
<ul class="links">
<li class="first"><a title="How to buy" href="#">How to buy</a></li>
<li><a title="FAQs" href="#">FAQs</a></li>
<li><a title="Payment" href="#">Payment</a></li>
<li><a title="Shipment" href="#">Shipment</a></li>
<li><a title="Where is my order?" href="#">Where is my order?</a></li>
<li class="last"><a title="Return policy" href="#">Return policy</a></li>
</ul>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Style Advisor</h4>
<ul class="links">
<li class="first"><a title="Your Account" href="#">Your Account</a></li>
<li><a title="Information" href="#">Information</a></li>
<li><a title="Addresses" href="#">Addresses</a></li>
<li><a title="Addresses" href="#">Discount</a></li>
<li><a title="Orders History" href="#">Orders History</a></li>
<li class="last"><a title=" Additional Information" href="#">Additional Information</a></li>
</ul>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="footer-column">
<h4>Information</h4>
<ul class="links">
<li class="first"><a title="Site Map" href="#">Site Map</a></li>
<li><a title="Search Terms" href="#">Search Terms</a></li>
<li><a title="Advanced Search" href="#">Advanced Search</a></li>
<li><a title="Contact Us" href="contact-us.html">Contact Us</a></li>
<li><a title="Suppliers" href="#">Suppliers</a></li>
<li class=" last"><a class="link-rss" title="Our stores" href="#">Our stores</a></li>
</ul>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Left Navigation Block',
    'identifier' => 'fabia_left_navigation_block',
    'content' => '<div class="row">
<div class="mega-col col-sm-88 " data-colwidth="8" data-widgets="wid-1">
<div class="mega-col-inner">
<div class="magik-widget">
<div class="product-block">
<div class="image"><a href="#"><img src="{{skin url="images/custom-img1.jpg"}}" alt="Fauxwaii Shirt-Oldss" width="240" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
</div>
</div>
</div>
</div>
<div class="mega-col col-sm-88 " data-colwidth="8" data-widgets="wid-2">
<div class="mega-col-inner">
<div class="magik-widget">
<div class="widget-product">
<div class="widget-inner">
<div class="product-block">
<div class="image"><a href="#"><img src="{{skin url="images/custom-img2.jpg"}}" alt="Framed-Sleeve Mid" width="240" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="mega-col col-sm-88 " data-colwidth="8" data-widgets="wid-1">
<div class="mega-col-inner">
<div class="magik-widget">
<div class="product-block">
<div class="image"><a href="#"><img src="{{skin url="images/custom-img3.jpg"}}" alt="Fauxwaii Shirt - Oldss" width="240" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
</div>
</div>
</div>
</div>
<div class="mega-col col-sm-88 " data-colwidth="8" data-widgets="wid-2">
<div class="mega-col-inner">
<div class="magik-widget">
<div class="widget-product">
<div class="widget-inner">
<div class="product-block">
<div class="image"><a href="#"><img src="{{skin url="images/custom-img4.jpg"}}" alt="Framed-Sleeve Mid" width="240" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


$staticBlock = array(
    'title' => 'Fabia Header Phone Number Block',
    'identifier' => 'fabia_header_phone_number_block',
    'content' => '<div class="phone hidden-xs">
<div class="phone-box"><strong>Call:</strong> <span>+1 800 123 1234</span></div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Store Logo5',
    'identifier' => 'fabia_logo5',
    'content' => '<p><img src="{{skin url="images/logo5.png"}}" alt="Fabia Store" /></p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Store Logo7',
    'identifier' => 'fabia_logo7',
    'content' => '<p><img src="{{skin url="images/logo7.png"}}" alt="Fabia Store" /></p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Custom',
    'identifier' => 'fabia_navigation8_block',
    'content' => '<div class="grid12-5">
<div class="custom_img"><a href="#"><img src="{{skin url="images/custom-img81.jpg"}}" alt="custom-image" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
<button class="learn_more_btn" title="Add to Cart" type="button"><span>Learn More</span></button></div>
<div class="grid12-5">
<div class="custom_img"><a href="#"><img src="{{skin url="images/custom-img82.jpg"}}" alt="custom-image" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
<button class="learn_more_btn" title="Add to Cart" type="button"><span>Learn More</span></button></div>
<div class="grid12-5">
<div class="custom_img"><a href="#"><img src="{{skin url="images/custom-img83.jpg"}}" alt="custom-image" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
<button class="learn_more_btn" title="Add to Cart" type="button"><span>Learn More</span></button></div>
<div class="grid12-5">
<div class="custom_img"><a href="#"><img src="{{skin url="images/custom-img84.jpg"}}" alt="custom-image" /></a></div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue.</p>
<button class="learn_more_btn" title="Add to Cart" type="button"><span>Learn More</span></button></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Top Menu Left Position Static Block',
    'identifier' => 'fabia_top_menu_left_position_static_block',
    'content' => '<p><a href="#"><img class="fade-on-hover" src="{{skin url="images/nav-img.jpg"}}" alt="nav image" /></a></p>
<h3 class="heading">Responsive Magento Theme</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<p><a class="btn-button-st" title="Shop collection now" href="#">Shop collection now</a></p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Top Menu Image With Text Static Block',
    'identifier' => 'fabia_top_menu_image_with_text_static_block',
    'content' => '<p><a href="#"><img class="fade-on-hover" src="{{skin url="images/nav-img1.jpg"}}" alt="nav image" /></a></p>
<h3 class="heading">Fabia Sale!</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<p><a class="btn-button-st" title="Shop collection now" href="#">Shop collection now</a></p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

$staticBlock = array(
    'title' => 'Fabia Home7 Logo Brand block',
    'identifier' => 'fabia_home7_logo_brand_block',
    'content' => '<div class="brand-logo wow bounceInUp animated">
<div class="container">
<div class="new_title center">
<h2>Top Brands</h2>
</div>
<div class="slider-items-products">
<div id="brand-logo-slider" class="product-flexslider hidden-buttons">
<div class="slider-items slider-width-col6">
<div class="item"><a href="#"><img src="{{skin url="images/b-logo3.png"}}" alt="Image" /></a></div>
<div class="item"><a href="#"><img src="{{skin url="images/b-logo2.png"}}" alt="Image" /></a></div>
<div class="item"><a href="#"><img src="{{skin url="images/b-logo1.png"}}" alt="Image" /></a></div>
<div class="item"><a href="#"><img src="{{skin url="images/b-logo4.png"}}" alt="Image" /></a></div>
<div class="item"><a href="#"><img src="{{skin url="images/b-logo5.png"}}" alt="Image" /></a></div>
<div class="item"><a href="#"><img src="{{skin url="images/b-logo5.png"}}" alt="Image" /></a></div>
<div class="item"><a href="#"><img src="{{skin url="images/b-logo1.png"}}" alt="Image" /></a></div>
<div class="item"><a href="#"><img src="{{skin url="images/b-logo4.png"}}" alt="Image" /></a></div>
</div>
</div>
</div>
</div>
</div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

}
catch (Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while installing Fabia theme pages and cms blocks.'));
}