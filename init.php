<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/***************
*
* Initiliaze Our Plugin Here

 _ |. _ _ | _  _  _ _ '~)L~'~)
(_|||_\(_||(/_(/_| | | /__) /_

****************/

/* Add Menu and Stuff */
add_action( 'admin_menu','wooboaster_options');
function wooboaster_options(){
			add_submenu_page('woocommerce','Woo Sales Notify Options','Woo Sales Notify','manage_options','wooboast-scheule-event','wooboast_manage_options');
} //close function
function wooboast_manage_options(){
		if(isset($_POST['wooboaster_submit'])){
			$enable = isset($_POST['enable_wooboaster']) ? ($_POST['enable_wooboaster'] == 'yes' ? 'yes' : '') : '';
			update_option('enable_wooboaster',$enable);
			// Or generate the Original Json File
			create_wooboaster();
			
		}  //close if 
			
			
		?>
         <div id="wrap">
         <h2><?php _e('WooCommerce Sales Notify','woo-sales-notify') ?></h2>
         <small><?php _e('Notify Visitors About the Recent WooCommerce Sales','wooboaster') ?></small>
         <form method="post" action="">
		<table class="form-table">
         <tr>
<th scope="row"><label for="blogname"><?php _e('Enable Woo Sales Boaster','wooboaster') ?></label></th>
<td><input type="radio" name="enable_wooboaster" value="yes" <?php $option = get_option('enable_wooboaster'); echo ($option == 'yes' ? 'checked' : '');?>/> <label for="Yes"><?php _e('Yes','wooboaster') ?></label>
         <input type="radio" name="enable_wooboaster" value="no" <?php $option = get_option('enable_wooboaster'); echo ($option == 'no' ? 'checked' : '');?>/> <label for="No"><?php _e('No','wooboaster') ?></label>
         </td>
</tr>
         
         
         <tr>
         <td></td>
         <td><input type="submit" name="wooboaster_submit" class="button-primary" value="Save and Generate" /></td>
         
         </tr>
		<tr>
        <td></td>
        <td> <a href="https://webostock.com/market-item/woocommerce-sales-notify-pro/31345/" target="_blank">Buy Premium Version</a> </td>
        </tr>         
         </table>         

         </form>
         </div> 
        <?php
		
} //close function
	
	
/* Place the Script on Head if WooBoaster Enabled*/
if (get_option('enable_wooboaster') == 'yes')
add_action('wp_head','wooboaster_head');

function wooboaster_head(){ 
if (!is_cart() && !is_checkout()){			
?>
<script>
//<![CDATA[


var folder = "<?php echo plugins_url( '/json/',__FILE__)?>";

    (function() {
      function asyncLoad() {
		
        var urls = ["<?php echo plugins_url('/js/booster.min.js?v=1',__FILE__)?>"];
        for (var i = 0; i < urls.length; i++) {
          var s = document.createElement('script');
          s.type = 'text/javascript';
          s.async = true;
          s.src = urls[i];
          var x = document.getElementsByTagName('script')[0];
          x.parentNode.insertBefore(s, x);
        }
      }
      window.attachEvent ? window.attachEvent('onload', asyncLoad) : window.addEventListener('load', asyncLoad, false);
    })();

//]]>
</script>
<?php }} // function wooboaster_head
?>