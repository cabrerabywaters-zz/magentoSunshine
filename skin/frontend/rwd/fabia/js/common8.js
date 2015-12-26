
jQuery(document).ready(function() {
	"use strict";
	jQuery('.toggle').click(function() {
	if (jQuery('.submenu').is(":hidden"))
	{
	jQuery('.submenu').slideDown("fast");
	} else {
	jQuery('.submenu').slideUp("fast");
	}
	return false;
	});

/*Phone Menu*/
jQuery(".topnav").accordion({
	accordion:false,
	speed: 300,
	closedSign: '+',
	openedSign: '-'
	});
	
	jQuery("#nav > li").hover(function() {
	var el = jQuery(this).find(".level0-wrapper");
	el.hide();
	el.css("left", "0");
	el.stop(true, true).delay(150).fadeIn(300, "easeOutCubic");
	}, function() {
	jQuery(this).find(".level0-wrapper").stop(true, true).delay(300).fadeOut(300, "easeInCubic");
	});	
	var scrolled = false;
	
jQuery("#nav li.level0.drop-menu").mouseover(function(){
	if(jQuery(window).width() >= 740){
	jQuery(this).children('ul.level1').fadeIn(100);
	}
	return false;
	}).mouseleave(function(){
	if(jQuery(window).width() >= 740){
jQuery(this).children('ul.level1').fadeOut(100);
	}
	return false;
	});
	jQuery("#nav li.level0.drop-menu li").mouseover(function(){
	if(jQuery(window).width() >= 740){
	jQuery(this).children('ul').css({top:0,left:"165px"});
	var offset = jQuery(this).offset();
	if(offset && (jQuery(window).width() < offset.left+325)){
	jQuery(this).children('ul').removeClass("right-sub");
	jQuery(this).children('ul').addClass("left-sub");
	jQuery(this).children('ul').css({top:0,left:"-167px"});
	} else {
	jQuery(this).children('ul').removeClass("left-sub");
	jQuery(this).children('ul').addClass("right-sub");
	}
	jQuery(this).children('ul').fadeIn(100);
	}
	}).mouseleave(function(){
	if(jQuery(window).width() >= 740){
	jQuery(this).children('ul').fadeOut(100);
	}
	});				
	
	jQuery("#best-seller-slider .slider-items").owlCarousel({
	items : 4, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false
});

jQuery("#featured-slider .slider-items").owlCarousel({
	items : 4, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false
	});
jQuery("#bag-seller-slider .slider-items").owlCarousel({
	items : 3, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false
	});
jQuery("#shoes-slider .slider-items").owlCarousel({
	items : 3, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false
	});
jQuery("#recommend-slider .slider-items").owlCarousel({
	items : 6, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false
	});
jQuery("#brand-logo-slider .slider-items").owlCarousel({
	autoplay : true,
	items : 6, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false			
	});
jQuery("#category-desc-slider .slider-items").owlCarousel({
	autoplay : true,
	items : 1, //10 items above 1000px browser width
	itemsDesktop : [1024,1], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,1], // 3 items betweem 900px and 601px
	itemsTablet: [600,1], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false			
	});
jQuery("#more-views-slider .slider-items").owlCarousel({
	autoplay : true,
	items : 3, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false
	});
jQuery("#more-views-slider1 .slider-items").owlCarousel({
        autoplay : true,
        items : 3, //10 items above 1000px browser width
        itemsDesktop : [1024,4], //5 items between 1024px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : [320,1],
        navigation : true,
        navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
        slideSpeed : 500,
        pagination : false
        });
jQuery("#related-products-slider .slider-items").owlCarousel({
	items : 4, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false
	});
jQuery("#upsell-products-slider .slider-items").owlCarousel({
	items : 4, //10 items above 1000px browser width
	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0;
	itemsMobile : [320,1],
	navigation : true,
	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	slideSpeed : 500,
	pagination : false
	});
	jQuery("#more-views-slider .slider-items").owlCarousel({
			autoplay : true,
			items : 3, //10 items above 1000px browser width
	    	itemsDesktop : [1024,4], //5 items between 1024px and 901px
	      	itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
	      	itemsTablet: [600,2], //2 items between 600 and 0;
	      	itemsMobile : [320,1],
	      	navigation : true,
	      	navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
	      	slideSpeed : 500,
	      	pagination : false
			
    	});
jQuery("ul.accordion li.parent, ul.accordion li.parents, ul#magicat li.open").each(function(){
jQuery(this).append('<em class="open-close">&nbsp;</em>');
});

jQuery('ul.accordion, ul#magicat').accordionNew();

jQuery("ul.accordion li.active, ul#magicat li.active").each(function(){
jQuery(this).children().next("div").css('display','block');
});
});

	var isTouchDevice = ('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0);
	jQuery(window).on("load", function() {
	
	if (isTouchDevice)
	{
	jQuery('#nav a.level-top').click(function(e) {
	jQueryt = jQuery(this);
	jQueryparent = jQueryt.parent();
	if (jQueryparent.hasClass('parent'))
	{
	if ( !jQueryt.hasClass('menu-ready'))
	{                    
		jQuery('#nav a.level-top').removeClass('menu-ready');
		jQueryt.addClass('menu-ready');
		return false;
	}
	else
	{
		jQueryt.removeClass('menu-ready');
	}
	}
	});
	}
	//on load
	jQuery().UItoTop();


}); //end: on load

//]]>

jQuery(window).scroll(function() {
if (jQuery(this).scrollTop() > 1){  
jQuery('nav').addClass("sticky");
}
else{
jQuery('nav').removeClass("sticky");
}
});

 /*========== Left Nav ===========*/
 
jQuery(document).ready(function(){      
                   
        //increase/ decrease product qunatity buttons +/- in cart.html table
        if(jQuery('.subDropdown')[0]){
                jQuery('.subDropdown').click(function(){
                        jQuery(this).toggleClass('plus');
                        jQuery(this).toggleClass('minus');
                        jQuery(this).parent().find('ul').slideToggle();
                });
        }
        
});

/*=============End Left Nav=============*/

/*--------| UItoTop jQuery Plugin 1.1-------------------*/
(function(jQuery){
	jQuery.fn.UItoTop = function(options) {
	
	var defaults = {
	text: '',
	min: 200,
	inDelay:600,
	outDelay:400,
	containerID: 'toTop',
	containerHoverID: 'toTopHover',
	scrollSpeed: 1200,
	easingType: 'linear'
	};
	
	var settings = jQuery.extend(defaults, options);
	var containerIDhash = '#' + settings.containerID;
	var containerHoverIDHash = '#'+settings.containerHoverID;
	
	jQuery('body').append('<a href="#" id="'+settings.containerID+'">'+settings.text+'</a>');
	jQuery(containerIDhash).hide().click(function(){
	jQuery('html, body').animate({scrollTop:0}, settings.scrollSpeed, settings.easingType);
	jQuery('#'+settings.containerHoverID, this).stop().animate({'opacity': 0 }, settings.inDelay, settings.easingType);
	return false;
	})
	.prepend('<span id="'+settings.containerHoverID+'"></span>')
	.hover(function() {
	jQuery(containerHoverIDHash, this).stop().animate({
	'opacity': 1
	}, 600, 'linear');
	}, function() { 
	jQuery(containerHoverIDHash, this).stop().animate({
	'opacity': 0
	}, 700, 'linear');
	});
	
	jQuery(window).scroll(function() {
	var sd = jQuery(window).scrollTop();
	if(typeof document.body.style.maxHeight === "undefined") {
	jQuery(containerIDhash).css({
	'position': 'absolute',
	'top': jQuery(window).scrollTop() + jQuery(window).height() - 50
	});
	}
	if ( sd > settings.min ) 
	jQuery(containerIDhash).fadeIn(settings.inDelay);
	else 
	jQuery(containerIDhash).fadeOut(settings.Outdelay);
	});
	
	};
})(jQuery);


/*--------| End UItoTop -------------------*/

function deleteCartInCheckoutPage(){ 	
	jQuery(".checkout-cart-index a.btn-remove2,.checkout-cart-index a.btn-remove").click(function(event) {
	event.preventDefault();
	if(!confirm(confirm_content)){
	return false;
	}	
	});	
	return false;
	}
function slideEffectAjax() {
	jQuery('.top-cart-contain').mouseenter(function() {
	jQuery(this).find(".top-cart-content").stop(true, true).slideDown();
	});
	
	jQuery('.top-cart-contain').mouseleave(function() {
	jQuery(this).find(".top-cart-content").stop(true, true).slideUp();
	});
	}
function deleteCartInSidebar() {
	if(is_checkout_page>0) return false;
	jQuery('#cart-sidebar a.btn-remove, #mini_cart_block a.btn-remove').each(function(){});
	}  
	
	jQuery(document).ready(function(){
	slideEffectAjax();
	});


/*-------- End Cart js -------------------*/


jQuery.extend( jQuery.easing,
	{	
	easeInCubic: function (x, t, b, c, d) {
	return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
	return c*((t=t/d-1)*t*t + 1) + b;
	},	
	});

(function(jQuery){
	jQuery.fn.extend({
	accordion: function() {       
	return this.each(function() {

function activate(el,effect){	
	jQuery(el).siblings( panelSelector )[(effect || activationEffect)](((effect == "show")?activationEffectSpeed:false),function(){
	jQuery(el).parents().show();	
	});	
	}	
	});
	}
	}); 
})(jQuery);

jQuery(function(jQuery) {
	jQuery('.accordion').accordion();	
	jQuery('.accordion').each(function(index){
	var activeItems = jQuery(this).find('li.active');
	activeItems.each(function(i){
	jQuery(this).children('ul').css('display', 'block');
	if (i == activeItems.length - 1)
	{
	jQuery(this).addClass("current");
	}
	});
	});

});



/*-------- End Nav js -------------------*/	
/*============= Responsive Nav =============*/
(function(jQuery){
	jQuery.fn.extend({	
	accordion: function(options) {	
	var defaults = {
	accordion: 'true',
	speed: 300,
	closedSign: '[+]',
	openedSign: '[-]'
	};	
	var opts = jQuery.extend(defaults, options);	
	var jQuerythis = jQuery(this);	
	jQuerythis.find("li").each(function() {
	if(jQuery(this).find("ul").size() != 0){
	jQuery(this).find("a:first").after("<em>"+ opts.closedSign +"</em>");	
	if(jQuery(this).find("a:first").attr('href') == "#"){
	jQuery(this).find("a:first").click(function(){return false;});
	}
	}
	});	
	jQuerythis.find("li em").click(function() {
	if(jQuery(this).parent().find("ul").size() != 0){
	if(opts.accordion){
	//Do nothing when the list is open
	if(!jQuery(this).parent().find("ul").is(':visible')){
	parents = jQuery(this).parent().parents("ul");
	visible = jQuerythis.find("ul:visible");
	visible.each(function(visibleIndex){
	var close = true;
	parents.each(function(parentIndex){
	if(parents[parentIndex] == visible[visibleIndex]){
		close = false;
		return false;
	}
	});
	if(close){
	if(jQuery(this).parent().find("ul") != visible[visibleIndex]){
		jQuery(visible[visibleIndex]).slideUp(opts.speed, function(){
			jQuery(this).parent("li").find("em:first").html(opts.closedSign);
		});		
	}
	}
	});
	}
	}
	if(jQuery(this).parent().find("ul:first").is(":visible")){
	jQuery(this).parent().find("ul:first").slideUp(opts.speed, function(){
	jQuery(this).parent("li").find("em:first").delay(opts.speed).html(opts.closedSign);
	});	
	}else{
	jQuery(this).parent().find("ul:first").slideDown(opts.speed, function(){
	jQuery(this).parent("li").find("em:first").delay(opts.speed).html(opts.openedSign);
	});
	}
	}
	});
	}
	});
})(jQuery);

/*============= End Responsive Nav =============*/

(function(jQuery){
	jQuery.fn.extend({
	accordionNew: function() {       
	return this.each(function() {	
	var jQueryul			= jQuery(this),
	elementDataKey			= 'accordiated',
	activeClassName			= 'active',
	activationEffect 		= 'slideToggle',
	panelSelector			= 'ul, div',
	activationEffectSpeed 	= 'fast',
	itemSelector			= 'li';	
	if(jQueryul.data(elementDataKey))
	return false;							
	jQuery.each(jQueryul.find('ul, li>div'), function(){
	jQuery(this).data(elementDataKey, true);
	jQuery(this).hide();
	});	
	jQuery.each(jQueryul.find('em.open-close'), function(){
	jQuery(this).click(function(e){
	activate(this, activationEffect);
	return void(0);
	});	
	jQuery(this).bind('activate-node', function(){
	jQueryul.find( panelSelector ).not(jQuery(this).parents()).not(jQuery(this).siblings()).slideUp( activationEffectSpeed );
	activate(this,'slideDown');
	});
	});	
	var active = (location.hash)?jQueryul.find('a[href=' + location.hash + ']')[0]:jQueryul.find('li.current a')[0];	
	if(active){
	activate(active, false);
	}	
	function activate(el,effect){	
	jQuery(el).parent( itemSelector ).siblings().removeClass(activeClassName).children( panelSelector ).slideUp( activationEffectSpeed );	
	jQuery(el).siblings( panelSelector )[(effect || activationEffect)](((effect == "show")?activationEffectSpeed:false),function(){	
	if(jQuery(el).siblings( panelSelector ).is(':visible')){
	jQuery(el).parents( itemSelector ).not(jQueryul.parents()).addClass(activeClassName);
	} else {
	jQuery(el).parent( itemSelector ).removeClass(activeClassName);
	}	
	if(effect == 'show'){
	jQuery(el).parents( itemSelector ).not(jQueryul.parents()).addClass(activeClassName);
	}	
	jQuery(el).parents().show();	
	});	
	}	
	});
	}
	}); 
})(jQuery);


/*============= End Left Nav =============*/


jQuery()
.ready(function()
{
(function(element){
	jQueryelement = jQuery(element);
	itemNav = jQuery('.item-nav',jQueryelement);
	itemContent = jQuery('.pdt-content',jQueryelement);
	btn_loadmore = jQuery('.btn-loadmore',jQueryelement);
	ajax_url="http://www.magikcommerce.com/producttabs/index/ajax";
	catids = '39';
	label_allready = 'All Ready';
	label_loading = 'Loading ...';
	function setAnimate(el){
	jQuery_items = jQuery('.item-animate',el);
	jQuery('.btn-loadmore',el).fadeOut('fast');
	jQuery_items.each(function(i){
	jQuery(this).attr("style", "-webkit-animation-delay:" + i * 300 + "ms;"
		  + "-moz-animation-delay:" + i * 300 + "ms;"
		  + "-o-animation-delay:" + i * 300 + "ms;"
		  + "animation-delay:" + i * 300 + "ms;");
	if (i == jQuery_items.size() -1) {
	  jQuery(".pdt-list", el).addClass("play");
	  jQuery('.btn-loadmore', el).fadeIn(i*0.3);
	}
	});
	}
	setAnimate(jQuery('.tab-content-actived',jQueryelement));
	
	itemNav.click(function(){
	var jQuerythis = jQuery(this);
	if(jQuerythis.hasClass('tab-nav-actived')) return false;
	itemNav.removeClass('tab-nav-actived');
	jQuerythis.addClass('tab-nav-actived');
	var itemActive = '.'+jQuerythis.attr('data-href');
	itemContent.removeClass('tab-content-actived');
	jQuery(".pdt-list").removeClass("play");jQuery(".pdt-list .item").removeAttr('style');
	jQuery('.item',jQuery(itemActive, jQueryelement)).addClass('item-animate').removeClass('animated');
	jQuery(itemActive, jQueryelement).addClass('tab-content-actived');
	
	contentLoading = jQuery('.content-loading',jQuery(itemActive, jQueryelement));
	isLoaded = jQuery(itemActive, jQueryelement).hasClass('is-loaded');
	if(!isLoaded && !jQuery(itemActive, jQueryelement).hasClass('is-loading')){
	jQuery(itemActive, jQueryelement).addClass('is-loading');
	contentLoading.show();
	pdt_type = jQuerythis.attr('data-type');
	catid = jQuerythis.attr('data-catid');
	orderby = jQuerythis.attr('data-orderby');
	jQuery.ajax({
	  type: 'POST',
	  url: ajax_url,
	  data:{
		  numberstart: 0,
		  catid: catid,
		  orderby: orderby,
		  catids: catids,
		  pdt_type: pdt_type
	  },
	  success: function(result){
		  if(result.listProducts !=''){
			  jQuery('.pdt-list',jQuery(itemActive, jQueryelement)).html(result.listProducts);
			  jQuery(itemActive, jQueryelement).addClass('is-loaded').removeClass('is-loading');
			  contentLoading.remove();
			  setAnimate(jQuery(itemActive, jQueryelement));
			  setResult(jQuery(itemActive, jQueryelement));
		  }
	  },
	  dataType:'json'
	});
	}else{
	jQuery('.item', itemContent ).removeAttr('style');
	setAnimate(jQuery(itemActive, jQueryelement));
	}
});
function setResult(content){
	jQuery('.btn-loadmore', content).removeClass('loading');
	itemDisplay = jQuery('.item', content).length;
	jQuery('.btn-loadmore', content).parent('.pdt-loadmore').attr('data-start', itemDisplay);
	total = jQuery('.btn-loadmore', content).parent('.pdt-loadmore').attr('data-all');
	loadnum = jQuery('.btn-loadmore', content).parent('.pdt-loadmore').attr('data-loadnum');
	if(itemDisplay < total){
	jQuery('.load-number', content).attr('data-total', (total - itemDisplay));
	if((total - itemDisplay)< loadnum ){
	jQuery('.load-number',  content).attr('data-more', (total - itemDisplay));
	}
	}
	if(itemDisplay == total){
	jQuery('.load-number', content).css({display: 'none'});
	jQuery('.btn-loadmore', content).addClass('loaded');
	jQuery('.load-text', content).text(label_allready);
	}else{
	jQuery('.load-text', content).text(label_loadmore);
	}
	}
	btn_loadmore.on('click.loadmore', function(){
	var jQuerythis = jQuery(this);
	itemActive = '.'+jQuerythis.parent('.pdt-loadmore').attr('data-href');
	jQuery(".pdt-list").removeClass("play");jQuery(".pdt-list .item").removeAttr('style');
	jQuery('.item',jQuery(itemActive, jQueryelement)).addClass('animated').removeClass('item-animate');
	if (jQuerythis.hasClass('loaded') || jQuerythis.hasClass('loading')){
	return false;
	}else{
	jQuerythis.addClass('loading'); jQuery('.load-text', jQuerythis).text(label_loading);
	numberstart = jQuerythis.parent('.pdt-loadmore').attr('data-start');
	catid = jQuerythis.parent('.pdt-loadmore').attr('data-catid');
	pdt_type = jQuerythis.parent('.pdt-loadmore').attr('data-type');
	orderby = jQuerythis.parent('.pdt-loadmore').attr('data-orderby');
	jQuery.ajax({
	type: 'POST',
	url: ajax_url,
	data:{
	numberstart: numberstart,
	catid: catid,
	orderby: orderby,
	catids: catids,
	pdt_type: pdt_type
	},
	success: function(result){
	if(result.listProducts !=''){
	animateFrom = jQuery('.item',jQuery(itemActive, jQueryelement)).size();
	jQuery(result.listProducts).insertAfter(jQuery('.item',jQuery(itemActive, jQueryelement)).nextAll().last());
	setAnimate(jQuery(itemActive, jQueryelement));
	setResult(jQuery(itemActive, jQueryelement));
	}
	},
	dataType:'json'
	});
	}
	return false;
	});
	})('#magik_producttabs1');
});
//]]>

function callQuickView(qurl) { 
    jQuery('#mgkquickview').show();
    jQuery('#magikloading').show();
    jQuery.get(qurl, function(data) {
      jQuery.fancybox(data);
      jQuery('#magikloading').hide();
jQuery('#mgkquickview').hide();
    });
 }