<?php

/*******************

 _ |. _ _ | _  _  _ _ '~)L~'~)
(_|||_\(_||(/_(/_| | | /__) /_
                              

********************/
if ( ! defined( 'ABSPATH' ) ) exit;

//add_action('init','create_jsonfile');
add_action('woocommerce_new_order','create_wooboaster');
function create_wooboaster(){
$args = array('post_type' => 'shop_order', 'posts_per_page' => -1, 'post_status' => 'wc-completed');
$shop_orders = get_posts($args);
//print_r($shop_orders);
$pargs = array('post_type' => 'product', 'posts_per_page' => -1, 'post_status'      => 'publish');
$products = get_posts($pargs);
global $wpdb;
if(is_array($shop_orders)){
	$parsePurchases = array();
	//$parsePurchases = '([';
	$countorders = count($shop_orders);
	$counter = 0;
	foreach($shop_orders as $shop_order){
		$counter++;
//print_r($shop_order);              
$results = $wpdb->get_results('
SELECT t1.order_item_id, t2.* FROM               
'.$wpdb->prefix.'woocommerce_order_items as t1 
JOIN '.$wpdb->prefix.'woocommerce_order_itemmeta as t2 
ON t1.order_item_id = t2.order_item_id              
WHERE t1.order_id='.$shop_order->ID);
$city = get_post_meta($shop_order->ID,'_billing_city',true);
$country = get_post_meta($shop_order->ID,'_billing_country',true);
$billingstate = get_post_meta($shop_order->ID,'_billing_state',true);
$createat = $shop_order->post_date;
$createat = strtotime($createat);
//get_post_meta($shop_order,'post_date',true);
$address1 = get_post_meta($shop_order->ID,'_billing_address_1',true);
$address2 = get_post_meta($shop_order->ID,'_billing_address_2',true);

foreach($results as $result){
	if(($result->meta_key) == '_product_id'){
		//print_r($count);
		$productid = $result->meta_value;
		$producttitle = get_the_title($productid);
		$productimages = wp_get_attachment_url(get_post_thumbnail_id($productid));
		//$productimages = wp_get_attachment_thumb_url($productid);
		//print_r($productimages);
		$producturl = get_permalink($productid);
		$parsePurchases[] = array('id' => $productid, 'country' => $country, 'province' => $billingstate, 'city' => $city, 'created_at' => $createat, 'product_title' => $producttitle, 'image' => $productimages, 'url' => $producturl);
				
	}//close if
} //close foreach reasult
//print_r($productids);
} //close foreach loop
//$parsePurchases .= '])';
$parsePurchases = json_encode($parsePurchases);
	
	$filename = WOOBOASTERPATH.'/json/file.json';
	$file = fopen($filename, 'w');
	fwrite($file,'parsePurchases('.$parsePurchases.')');
	fclose($file);
}// close if shop_orders array
} //close function