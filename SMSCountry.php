<?php
/*
	Plugin Name:  Woocommerce SMScountry integration 
	Plugin URI :  http://www.smscountry.com/woocommerce-sms-plugin.aspx
	Description: SMSCountry Plugin for sending SMS
	Author:SMScountry
	Author URI:http://www.smscountry.com/woocommerce-sms-plugin.aspx
	Version: 1.1.0
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	*/
	// Check if plugin is licence after plugin load

	if ( ! class_exists( 'WC_SMSCountry' ) ) 
	{
			class WC_SMSCountry 

			{
				 /**
				 * Class instance
				 */
				private static $instance;
				/**
				 * Flag for indicating that we are on a SMSCountry plugin page
				 */
				private $is_woocommerce_SMSCountry_page = false;
				/**
				 * String name of the main plugin file
				 */
				private static $file = __FILE__;
				/**
				 * Our plugin version
				 */
				public static $version = '2.1';
				 /**
				 * Our array of SMSCountry admin pages. These are used to conditionally load scripts
				 */
				public $SMSCountrylist = array();
				/**
				 * Our plugin database version
				 */
				public static $SMSCountry_db_version  = '2.1';
				
				public   $order_status_flag  = 'false';
				/**
				 * SMSCountry Authorize URI
				 */
				public static $SMSCountry_auth_url  = '';
				/**
				 * SMSCountry Application Setup URI
				 */
				public static $SMSCountry_app_setup_url  = 'http://www.smscountry.com/registration.aspx';
				/**  
				 * Plugin prefix for options
				 */

				public static $meta_prefix = '_WC_SMSCountry_';
				/** Is Debug log */
				public static $isDebuglog  = 1;
				/** Debug log */
				public static $log;	
							
				public static $SMSCountryConfiginstance;
				/** Class SMSCountry Instance */
				public static $clsCBObj;

				public static $isClearsycLog;

				public function __construct() {  

				// called to add admin Menu. 

				add_action( 'admin_menu', array( &$this, 'add_menus' ), 99 );
				
				//when activate plugin to create table in db
				 if ( is_multisite() )
					  register_activation_hook( __FILE__, array( $this, 'do_network_activation' ) );
				 else
				      register_activation_hook(__FILE__,array($this,'load_history_table'));

				// called to add js/css.

				add_action('admin_head', array( &$this,'include_js_css'));
			
				// called for user login verification popup.

				add_action("wp_head",array($this,"check_user_verification"));

				//called for user registration user

				add_action('register_form',array($this,'show_phone_no_field'));

				add_action('register_post',array($this,'check_fields'),10,3);

				add_action( 'user_register', array($this,'user_registers'), 100 );

				//ajax request for send test sms
			    add_action('wp_ajax_send_test_sms', array($this,'send_test_sms'));

  				add_action('wp_ajax_nopriv_send_test_sms',  array($this,'send_test_sms'));
				
				//ajax request for smscountrycall back
				/*add_action('wp_ajax_SMSCountyCallBack', array($this,'send_test_sms_callback'));

  				add_action('wp_ajax_nopriv_SMSCountyCallBack',  array($this,'send_test_sms_callback'));*/
				add_action('wp_ajax_DailySMSCron', array($this,'daily_sms_cron'));
				add_action('wp_ajax_nopriv_DailySMSCron',  array($this,'daily_sms_cron'));
				add_action('wp_ajax_WeekllySMSCron', array($this,'weekly_sms_cron'));
				add_action('wp_ajax_nopriv_WeekllySMSCron',  array($this,'weekly_sms_cron'));
				add_action('wp_ajax_MonthlySMSCron', array($this,'monthly_sms_cron'));
				add_action('wp_ajax_nopriv_MonthlySMSCron',  array($this,'monthly_sms_cron'));
				
				add_action( 'init', array($this,'send_test_sms_callback') );

				//called for order status chnage

				add_action( 'woocommerce_order_status_changed', array( &$this,'send_order_status_sms'),10,2);

				//add_action( 'woocommerce_order_status_changed', array( &$this,'send_order_status_sms'),10,2);

				//called for order place 

				add_action( 'woocommerce_checkout_order_processed', array($this,'send_new_order_place_sms'));
				add_action('woocommerce_payment_complete', array( $this,'send_new_order_place_sms'), 10,2);

				// called for sending mail function

				$contact_inquiry	= get_option( 'woocommerce_admin_template_contact_inquiry' );

				if($contact_inquiry['chk_admin_contact_inquiry'])

				{
					add_action( 'wpcf7_before_send_mail', array( $this,'send_contact_enquiry_sms') );
				}
				
				//add one field on checkout page
				$user_template_checkput= get_option( 'woocommerce_user_template_checkout' );
				if($user_template_checkput['chk_user_checkcut'])
				{
					add_filter( 'woocommerce_checkout_fields' ,  array( $this,'add_otp_field') );
					add_action('woocommerce_checkout_process', array( $this,'check_otp_field'));
					add_filter( 'wp_head' , array( $this,'my_checkout_code') );
					add_action('wp_ajax_send_checkout_sms_callback', array( $this,'send_checkout_sms_callback'));
					add_action('wp_ajax_nopriv_send_checkout_sms_callback',  array( $this,'send_checkout_sms_callback'));
			    }

				// called for registering all styles

				add_action( 'init', array( $this, 'register_all_SMSCountry_styles' ) );

				// called for enqueue all styles

				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_SMSCountry_admin_styles' ) );

				$settings_gen     = get_option( 'woocommerce_SMSCountry_settings_general' );

				if( @$settings_gen['WC_SMSCountry_activate'] == 'enabled' )
				{
					//Add the required class files
					add_action ( 'init' , array( $this, 'class_loader' ) );
				}
				//called user authetication
				//add_action( 'wp_authenticate_user' , array( $this,'check_custom_authentication'),30, 3);
				// add_action('init', array($this,'register_popup_init'));

				//called to display pop_up
			    add_action('login_form', array($this,'display_pop_up'));
				//called for start sesstion

				add_action('init', array($this,'myStartSession'), 1);
				
				//add custom box on order page for refund order reason
				add_action('add_meta_boxes', array($this,'create_product_des_meta_box'));
				add_action('save_post', array($this,'build_prod_desc_meta'));
			  }
		
			/**
			 * Executes a network activation
			 *
			 * @since 2.0
			 */
			public static function do_network_activation() { //die('In do_network_activation');
				/** Get all of the blogs */
				$blogs = self::get_instance()->get_multisite_blogs();
		
				/** Execute acivation for each blog */
				foreach ( $blogs as $blog_id ) {
					@switch_to_blog( $blog_id );
					self::get_instance()->load_history_table();
					restore_current_blog();
				}
			}
			/**
			 * Returns the ids of the various multisite blogs. Returns false if not a multisite installation.
			 *
			 * @since 2.0
			 */
			public function get_multisite_blogs() {
		
				global $wpdb;
		
				/** Bail if not multisite */
				if ( !is_multisite() )
					return false;
		
				/** Get the blogs ids from database */
				$query = "SELECT blog_id from $wpdb->blogs";
				$blogs = $wpdb->get_col($query);
		
				/** Push blog ids to array */
				$blog_ids = array();
				foreach ( $blogs as $blog )
					$blog_ids[] = $blog;
		
				/** Return the multisite blog ids */
				return $blog_ids;
		
			}	
			
		   function create_product_des_meta_box()
		   {
				  add_meta_box('woocommerce-order-my-custom', 'Refund Reason',  array($this,'build_product_desc_meta'), 'shop_order',
				'side',
				'default');
		   }
		   
		   function build_product_desc_meta($post)
		   {
				  $desc 	= get_post_meta($post->ID, '_refund_reason', true);
		  ?>
		  
		  <form  method="post">
			<table>
			  <tr>
				<td><textarea cols="22" name="desc" id="desc" rows="5" ><?php  echo esc_attr($desc); ?></textarea></td>
			  </tr>
			</table>
		  </form>
		  <?php
		  }
		   function build_prod_desc_meta($post_id)
			  {
		  
				  if(isset($_POST['desc']))
				  {
					  update_post_meta($post_id, '_refund_reason', strip_tags($_POST['desc']));
				  }
			  }
			    function send_checkout_sms_callback()
				{
					 if ( $_POST['phone']!='')
  				 {
					 $name 						= $_POST['billing_first_name'];
					 $last_name					= $_POST['billing_last_name'];
					 $email						= $_POST['billing_email'];
					 $hide						= $_POST['rand_no'];
					  $phone						= $_POST['phone'];
					  $settings_general     		= get_option( 'woocommerce_SMSCountry_settings_general' );
					  $today    					= date("Y-m-d H:i:s"); 
					  $site_title    				= $settings_general['txt_site_title'];
					  $admin_mobile_number			= $settings_general['txt_admin_mob_number'];
					  $admin_email					= $settings_general['txt_admin_Email'];
					  $domain     					= $_SERVER['HTTP_HOST'];
					  $user_template_checkput		= get_option( 'woocommerce_user_template_checkout' );
					  $chk_user_checkcut 			= $user_template_checkput['user_txt_checkout'];
					  $search     					= array("[shop_name]","[shop_domain]","[customer_firstname]","[customer_lastname]","[customer_email]","[verification]");
					  $replace   					= array($site_title,$domain,$name,$last_name,$email,$hide);   
					  $new_message   				= str_replace($search, $replace,$chk_user_checkcut);
					  $text_count   				= strlen($new_message);
					  $subject   		   			= 'Order Verification on checkout page';
					  $mail_status 					= $this->send_test_email($email,$phone,$subject,$new_message);
					  $mail_staus_string			= explode(":",$mail_status);
					   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
					   {
					  		$this->insert_history_data($today,"",$new_message,$text_count,$name." ".$last_name,'checkout order vefity','Checkout Order Vefity','','user_order', $phone,$mail_staus_string[1]);
							echo "We have send verification code please check it..";
	 				   }
					   else if($mail_staus_string[0]	==	'ERROR')
					   {
							$this->insert_history_data($today,"",$new_message,$text_count,$name." ".$last_name,'checkout order vefity','','','user_order', $phone,$mail_staus_string[1]);
					   }
  				 }
					wp_die();
				}
			  function my_checkout_code()
			  {
				?>
				<style>
				#otp_field_btn
				{
					background-color:green;
					cursor:pointer;
					color:white;
					width:50%;
				}
				#otp_field_hidden_field
				{
					display:none;
				}
				</style>
				<script>
				 var ajaxurl = '<?php echo esc_url( home_url( '/' ));?>wp-admin/admin-ajax.php';
				 jQuery(document).ready(function() 
				{
					jQuery('#otp_field_btn').prop('readonly', true);
					var rand_no = Math.floor((Math.random() * 100000000) + 1);
					jQuery("#otp_field_hidden").val(rand_no);
					jQuery("#otp_field_btn").click(function(){
						var phone = jQuery("#billing_phone").val();
						var billing_first_name = jQuery("#billing_first_name").val();
						var billing_last_name = jQuery("#billing_last_name").val();
						var billing_email = jQuery("#billing_email").val();
						if(phone =='')
						{
							alert("enter no please");
							return false;
						}
						if(phone !='')
						{
						jQuery.ajax
						({ 
							 data: {action: 'send_checkout_sms_callback', rand_no:rand_no,phone:phone,billing_first_name:billing_first_name,billing_last_name:billing_last_name,billing_email:billing_email},
							 type: 'post',
							 url: ajaxurl,
							 success: function(data) 
							 {
								alert(data); //should print out the name since you sent it along
								return false;
							 }
							});
						}
			});
				});
				</script>
				<?php
		
		}
				//function for send test sms
				function send_test_sms()
				{
				
					if($_POST['mobile_no'] !='')
					{
					    $mobile_no 				= $_POST['mobile_no'];
						$message 				= $_POST['message'];
						$today   				= date("Y-m-d H:i:s"); 
                      	$settings_general   	= get_option( 'woocommerce_SMSCountry_settings_general' );
						$site_title    			= $settings_general['txt_site_title'];
						$domain     			= $_SERVER['HTTP_HOST'];
						//user details
						$current_user 			= wp_get_current_user();
						$subject				= "Preview SMS ";
						$to     				= $settings_general['txt_admin_Email'];
					    $search    				= array("[customer_firstname]", "[customer_lastname]","[shop_name]","[shop_domain]");
						$replace    		    = array($current_user->user_login,"",$site_title,$domain);  
						$new_message  		    = str_replace($search, $replace,$message);
						$text_count   			=  strlen($new_message);
					    $mail_status 			= $this->send_test_email($to,$mobile_no ,$subject,$new_message);
					    $mail_staus_string			= explode(":",$mail_status);
						//print_r($mail_staus_string);die;
					   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
					   {
							$this->insert_history_data($today,"",$new_message,$text_count,"",'Test SMS','Test sms','','test_sms', $mobile_no,$mail_staus_string[1]);
							echo "please check you will get sms and Message UUID : ".$mail_staus_string[1];
					   }
					   else if($mail_staus_string[0]	==	'ERROR')
					   {
							$this->insert_history_data($today,"",$new_message,$text_count,"",'Test SMS','Test sms','','test_sms', $mobile_no,$mail_staus_string[1]);
							//echo "No Balance error";
							echo $mail_staus_string[1];
					   }
					}
					wp_die();
				}
				
                               public function send_test_sms_callback(){
//echo $_SERVER["HTTP_REFERER"];exit;
                                         global $wpdb;
                                         $rawData = file_get_contents('php://input');
                                         $smsResponse = json_decode($rawData,TRUE);
//var_dump($smsResponse);exit;
//                                       echo $data['SMS']['UUID'];echo $data['SMS']['Number'];exit;
//                                       $smsResponse['SMS']['Number']
//                                       $smsResponse['SMS']['UUID']
//                                       $smsResponse['SMS']['StatusCode']
//                                       $smsResponse['SMS']['Status']

//                                       $smsResponse['SMS']['StatusTime']
//                                       $smsResponse['SMS']['SenderId']
//                                       $smsResponse['SMS']['Cost']


                                        if(isset($smsResponse['SMS']['UUID']) && $smsResponse['SMS']['UUID'] != '' && $smsResponse['SMS']['Number'] != ''){
                                #Send email when call back runs
                                        $str = '<br>Get Array :';
                                        $isSend = 0;
                                        foreach($smsResponse['SMS'] as $gkey => $gval)
                                        {
                                            $isSend = 1;
                                            $str .= '<br>'.$gkey.' => '.$gval;
                                        }
                                        $str .= "ip address:-".$_SERVER['REMOTE_ADDR'];
                                        $str .= "Host name:-".$_SERVER['HTTP_HOST'];


                                                // multiple recipients
//                                              $to  = 'farooqabdulla4u@yahoo.com';
//                                                $to1  = 'swarup.ondranki@gmail.com';
//                                                $to2  ="sarani.201088@gmail.com";
                                               // subject
                                                $subject = 'Response for message send for Message UUID : '.$smsResponse['SMS']['UUID'];

                                                // To send HTML mail, the Content-type header must be set
                                               $headers  = 'MIME-Version: 1.0' . "\r\n";
                                               $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  //                                       mail($to2, $subject, $str, $headers);
    //                                        wp_mail( $to, $subject, $str, $headers);
      //                                      wp_mail( $to2, $subject, $str, $headers);
                                                #Send email when call back runs - ends

                                //====code for updating status value in histroy table===//
                                         $message_status =  $smsResponse['SMS']['Status'];
                                         $jobno                 = $smsResponse['SMS']['UUID'];
                                         $mobilenumber  = $smsResponse['SMS']['Number'];
                                         $wpdb->query("UPDATE ".$wpdb->prefix."smscountry_history SET `dynamic_delivery_report` = '".maybe_serialize($smsResponse)."',`message_status`='".$message_status."'  WHERE `job_no` ='".$jobno."' AND `mobile_no` = '".$mobilenumber."'");

                                        }


                                }

				//function for smscallback
				public function send_test_sms_callback2()
				{
					global $wpdb;
					//echo "herre";die;
					//echo "<pre>"; print_r($_GET); echo "</pre>";
					$jobno						=	trim($_GET['jobno']);
					$mobilenumber				=	trim($_GET['mobilenumber']);
					$status						=	trim($_GET['status']);
					$doneTime 					=	trim($_GET['doneTime']);
					$messagepart				=	trim($_GET['messagepart']);
					$message_status				=	null;
					$ip							= $_SERVER['REMOTE_ADDR'];
					$domain     			    = $_SERVER['HTTP_HOST'];
					
					if($jobno != '')
					{
						$smsResponse = array();
						$smsResponse[$jobno] 		= $jobno;
						$smsResponse[$mobilenumber] = $mobilenumber;
						$smsResponse[$status] 		= $status;
						$smsResponse[$doneTime] 	= $doneTime;
						$smsResponse[$messagepart]	= $messagepart;
						echo "OK";
						
						#Send email when call back runs - start
						$str = '<br>Get Array :';
						$isSend = 0;
						foreach($_GET as $gkey => $gval)
						{
						 $isSend = 1;
						 $str .= '<br>'.$gkey.' => '.$gval;
						}
						$str .= "ip address:-".$ip;
						$str .= "Host name:-".$domain;
						// multiple recipients
						$to  = 'mapweb.sse1@gmail.com';
						$to1  = 'farooqabdulla4u@yahoo.com';
						$to2  = 'swarup.ondranki@gmail.com';
						// subject
						$subject = 'Response for message send for Job No : '.$_GET['jobno'];
						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						// Additional headers
						//$headers .= 'To: Mapweb <mapwebtech@gmail.com>' . "\r\n";
					//	$headers .= 'From: <mapwebtech@gmail.com>' . "\r\n";
					//	$headers .= 'Cc: puppavan@gmail.com' . "\r\n";
						//mail($to, $subject, $str, $headers);
						wp_mail( $to1, $subject, $str, $headers);
						wp_mail( $to2, $subject, $str, $headers);
						#Send email when call back runs - ends
						
						//====code for updating status value in histroy table===//
						switch($status)
						{
							case 0:
								$message_status="Message In Queue";
								break;
							case 1:
								$message_status="Submitted To Carrie";
								break;
							case 2:
								$message_status="Un Delivered";
								break;
							case 3:
								$message_status="Delivered";
								break;
							case 4:
								$message_status="Expired";
								break;
							case 8:
								$message_status="Rejected";
								break;
							case 9:
								$message_status="Message Sent";
								break;	
							case 10:
								$message_status="Opted Out Mobile Number";
								break;	
							case 11:
								$message_status="Invalid Mobile Number";
								break;	
										
						}
						
						if($jobno != '')
						{
							$wpdb->query("UPDATE ".$wpdb->prefix."smscountry_history SET `dynamic_delivery_report` = '".maybe_serialize($smsResponse)."',`message_status`='".$message_status."'  WHERE `job_no` ='".$jobno."' AND `mobile_no` = '".$mobilenumber."'");
						}	
					}
				}

				//function for start the sesssion
				function myStartSession() 
				{
					if(!session_id()) 
					{
						session_start();
					}
				}

			   //function for display pop_up
				function display_pop_up()
				{
				  global $wpdb;
				  $table_history    			 =    	$wpdb->prefix . 'smscountry_history';
				  $user_template_sign_verify	 = 		get_option( 'woocommerce_user_template_verification' );
				  $sing_up_verify				 =		$user_template_sign_verify['chk_user_sign_up_verify'];
				 
				  if($sing_up_verify)
				  {
					  if($_REQUEST['checkemail']=="registered")
					  {
						 ?>
						 <label for="username">Enter Code</label>
                        <input id="username" type="text" class="required" name="txt_otp"/>
                        <input type="hidden" name="cancel_hidden" id="hidd_cancel" value=""/>
                         <script>
						 jQuery(document).ready(function()
						 {
							 
			  				 jQuery("#loginform").attr("action","");
										jQuery("#loginform").html('<div class="simple_popup" class="ajax-auth"><label for="username">Enter Code</label><input id="username" type="text" class="required" name="txt_otp"/><input type="hidden" name="cancel_hidden" id="hidd_cancel" value=""/><input type="button" name="cancel" id="wp-cancel" class="button button-primary button-large" value="Cancel"/><input type="submit" name="otp_submit" id="otp-submit" class="button button-primary button-large" value="Submit"/></div>');
										
										jQuery(".message").text("Plz Enter OTP");
										jQuery("#otp-submit").css("margin-right","20px");
										jQuery("#otp-submit").css("width","73px");
										jQuery(".forgetmenot").remove(); 
										jQuery("#nav").remove();
										jQuery(".simple_popup").css("margin-top","700 !importent");
										
										jQuery('#wp-cancel').click(function()
										 {
											 window.location ="<?php echo site_url();?>/wp-login.php";
										 });
							
						});	
						 </script>
						 <?php
						 
						    if(isset($_POST['otp_submit']))
							{
								
							 if($_POST['txt_otp']!="") 
							 {
								$txt_otp						=	$_POST['txt_otp'];
								$get_search_records				=	$wpdb->get_results("select * from ".$wpdb->prefix."smscountry_history ORDER BY `sms_id` DESC");
								$sms_country_last_insert_id		=   $get_search_records[0]->sms_id;
								$sms_id							=   $_SESSION["otp_id"];
								$num_rows_found					=   $wpdb->get_results("select * from ".$wpdb->prefix."smscountry_history WHERE otp=".$txt_otp." AND sms_id=".$sms_id);
                       			//OTP is Found then user_status in wp_user table as 0 for login
									if($wpdb->num_rows==1)
									{
					     				$wp_user_id=$num_rows_found[0]->user_id;
										//$wpdb->query("UPDATE ".$wpdb->prefix."users SET `user_status` = '0' WHERE `ID` =".$wp_user_id);
										update_user_meta($wp_user_id, 'verification',1);
										session_destroy();
										?>
										<script>
                                                 window.location ="<?php echo site_url();?>/wp-login.php";
                                        </script>
                                        <?php
									} 
									else
									{
										?>
										<script>
											jQuery(document).ready(function()
											 {
											 	jQuery(".message").text("Error in OTP");
											 });
							            
										</script>
                                        <?php
									}
							   }
							 }
						  }
				     }
				}
				
				//function for set user_status in wp_user table
			   function check_custom_authentication ($user,$password) 
			   {
				    $user_email		=		$user->user_email;
				    global $wpdb;
					$user_profile   =       $wpdb->get_results( "SELECT * FROM $wpdb->users Where user_email='$user_email'");
                    $user_status	=       $user_profile[0]->user_status;
					if ($user_status==1) 
					{
						remove_action('authenticate', 'wp_authenticate_username_password', 20);
						$user = new WP_Error( 'denied', __("<strong>ERROR</strong>: Plz register.") );
					}
					return $user;
				}
				
				//function to add opt field
				function add_otp_field( $fields ) 
				{
					    $fields['billing']['otp_field'] = array(
						'label'     => __('OTP Verification', 'woocommerce'),
						'placeholder'   => _x('OTP Verification', 'placeholder', 'woocommerce'),
						'required'  => false,
						'class'     => array('form-row-wide'),
						'clear'     => true,
						'type'      => 'text'
					    );
					    $fields['billing']['otp_field_btn'] = array(
						'label'     => __('', 'woocommerce'),
						'placeholder'   => _x('SEND OTP', 'placeholder', 'woocommerce'),
						'required'  => false,
						'class'     => array('form-row-wide'),
						'clear'     => true,
						'type'      => 'text',
						'title'      => 'Please click on this button you will get OTP by sms and enter above field'
					    );
						$fields['billing']['otp_field_hidden'] = array(
						'label'     => __('', 'woocommerce'),
						'placeholder'   => _x('', 'placeholder', 'woocommerce'),
						'required'  => false,
						'class'     => array('form-row-wide'),
						'clear'     => true,
						'type'      => 'text'
						 );
					//  $fields['billing']['otp_field_hidden']['default']	= $no1;
					 // $fields['billing']['otp_field_hidden']['type'] = "hidden";
					    return $fields;
			}
			function check_otp_field()
		    { 
      			$phone_number    = $_POST['otp_field'];
      			$hide            = $_POST['otp_field_hidden'];
				
				 if (! $_POST['otp_field'])
  				{
	 				 wc_add_notice( __( 'Please enter Verification code.' ), 'error' );
  				}
				 if( $phone_number != $hide &&  $phone_number!='' )
				 {
						wc_add_notice( __( 'enter right code...' ), 'error' );
				 }
 		    }
				/**
				 * Include valid js/css
				 */
				function include_js_css()
				{
					/*wp_enqueue_script( 'custom_js', plugins_url( '/js/jquery-1.11.3.js', __FILE__ ) );*/
					//wp_enqueue_script( 'custome_css', plugins_url( '/css/font-awesome-4.7.3/css/font-awesome.css', __FILE__ ) );
					wp_enqueue_script( 'smscountry_js', plugins_url( '/js/smscountry.js', __FILE__ ) );
					wp_enqueue_style( 'smscountry_css', plugins_url( '/css/smscountry.css' , __FILE__ ) );
					wp_enqueue_script( 'datepicker1_js', plugins_url( 'datetimepicker-master/build/jquery.datetimepicker.full.min.js', __FILE__ ) );
					wp_enqueue_script( 'datepicker2_js', plugins_url( 'datetimepicker-master/jquery.datetimepicker.js', __FILE__ ) );
					wp_enqueue_style( 'datepicker_style', plugins_url( 'datetimepicker-master/jquery.datetimepicker.css', __FILE__ ) );
				}
				
				//========function for daily sign up users=====//
				 function daily_sms_cron()
				{
					 	 $admin_template_sign_up_history= get_option( 'woocommerce_admin_template_sign_up_history');
						 if($admin_template_sign_up_history['chk_admin_sign_up_history'])
						 {
							 if($admin_template_sign_up_history['txt_check_daily'])
							 {
									 $get_sign_up_msg				=$admin_template_sign_up_history['history_txt_area']; 
									 $today   						= date("Y-m-d H:i:s"); 
									 $settings_general     			= get_option( 'woocommerce_SMSCountry_settings_general' );
									 $admin_mobile_number			= $settings_general['txt_admin_mob_number'];
									 $site_title    				= $settings_general['txt_site_title'];
									 $admin_email    				= $settings_general['txt_admin_Email'];
									 $domain    					= $_SERVER['HTTP_HOST'];
									 $search  		   				= array("[shop_name]","[shop_domain]","[customer_count]");
									 $today    						= date("Y-m-d H:i:s"); 
								   global $wpdb;
								   $table_name		= $wpdb->prefix."users";
								   $daily_date		= date("Y-m-d");
								   $user_count 		= $wpdb->get_results("SELECT * FROM `$table_name` WHERE date(`user_registered`) = '$daily_date' " );
								   $total_record	= $wpdb->num_rows; 
								   $replace   		=  array($site_title , $domain , $total_record);   
								   $new_message  	=  str_replace($search, $replace, $get_sign_up_msg);
								   $text_count   	=  strlen($new_message);
								   $subject 		= "Daily Customer Count";
								   $mail_status 	= $this->send_test_email($admin_email,$admin_mobile_number,$subject,$new_message);
								   $mail_staus_string			= explode(":",$mail_status);
								   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
								   {
										$this->insert_history_data($today,"",$new_message,$text_count,"",'Daily Records','daily details','','admin_daily', $admin_mobile_number,$mail_staus_string[1]);
								   }
								   else if($mail_staus_string[0]	==	'ERROR')
								   {
										$this->insert_history_data($today,"",$new_message,$text_count,"",'Daily Records','daily details','','admin_daily', $admin_mobile_number,$mail_staus_string[1]);
								   }
							 }
						   
						 }
					}
				
				//========function for weekly sign up users=====//
				 function weekly_sms_cron()
				{
					
					$admin_template_sign_up_history= get_option( 'woocommerce_admin_template_sign_up_history');
					if($admin_template_sign_up_history['chk_admin_sign_up_history'])
					{
						 if($admin_template_sign_up_history['txt_check_weekly'])
						 {
						   $get_sign_up_msg					=$admin_template_sign_up_history['history_txt_area']; 
						   $today   						= date("Y-m-d H:i:s"); 
						   $settings_general     			= get_option( 'woocommerce_SMSCountry_settings_general' );
						   $admin_mobile_number				= $settings_general['txt_admin_mob_number'];
						   $site_title    					= $settings_general['txt_site_title'];
						   $admin_email    					= $settings_general['txt_admin_Email'];
						   $domain    						= $_SERVER['HTTP_HOST'];
						   $search  		   				= array("[shop_name]","[shop_domain]","[customer_count]");
						   $today    						= date("Y-m-d H:i:s"); 
						   global $wpdb;
						   $prefix			= $wpdb->prefix; 
						   $table_name		= $wpdb->prefix."users";
						  $user_count  	= $wpdb->get_results("SELECT * FROM $table_name  WHERE YEARWEEK(`user_registered`) = YEARWEEK(NOW())" );
						   $total_record	= $wpdb->num_rows; 
						   $replace   		=  array($site_title , $domain , $total_record);   
						   $new_message  	=  str_replace($search, $replace, $get_sign_up_msg);
						   $text_count      =  strlen($new_message);
						   $subject 		= "Weekly Customer Count";
						   $mail_status 	= $this->send_test_email($admin_email,$admin_mobile_number,$subject,$new_message);
					  	   $mail_staus_string			= explode(":",$mail_status);
						   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
						   {
								$this->insert_history_data($today,"",$new_message,$text_count,"",'Weekly Records','Weekly details','','admin_weekly', $admin_mobile_number,$mail_staus_string[1]);
						   }
						   else if($mail_staus_string[0]	==	'ERROR')
						   {
								$this->insert_history_data($today,"",$new_message,$text_count,"",'Daily Records','daily details','','admin_weekly', $admin_mobile_number,$mail_staus_string[1]);
						   }
						 }
				    }
				}
				
				//========function for monthly sign up users=====//
				 function monthly_sms_cron()
				{
					
					$admin_template_sign_up_history= get_option( 'woocommerce_admin_template_sign_up_history');
					if($admin_template_sign_up_history['chk_admin_sign_up_history'])
					{
						 if($admin_template_sign_up_history['txt_check_monthly'])
						 {
							   $get_sign_up_msg					=$admin_template_sign_up_history['history_txt_area']; 
							   $today   						= date("Y-m-d H:i:s"); 
							   $settings_general     			= get_option( 'woocommerce_SMSCountry_settings_general' );
							   $admin_mobile_number				= $settings_general['txt_admin_mob_number'];
							   $site_title    					= $settings_general['txt_site_title'];
							   $admin_email    					= $settings_general['txt_admin_Email'];
							   $domain    						= $_SERVER['HTTP_HOST'];
							   $search  		   				= array("[shop_name]","[shop_domain]","[customer_count]");
							   $today    						= date("Y-m-d H:i:s");
							    global $wpdb;
								  $table_name		= $wpdb->prefix."users";
							   $prefix			= $wpdb->prefix; 
							   $user_count 		= $wpdb->get_results("SELECT * FROM $table_name  WHERE MONTH(`user_registered`) = MONTH(CURDATE())");
							   $total_record	= $wpdb->num_rows; 
							   $replace   		=  array($site_title , $domain ,$total_record);   
							   $new_message  	=  str_replace($search, $replace, $get_sign_up_msg);
							   $text_count   	=  strlen($new_message);
							   $subject 		= "Monthly Customer Count";
							   $mail_status 	= $this->send_test_email($admin_email,$admin_mobile_number,$subject,$new_message);
							   $mail_staus_string			= explode(":",$mail_status);
							   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
							   {
									$this->insert_history_data($today,"",$new_message,$text_count,"",'Monthly Records','Monthly details','','admin_monthly', $admin_mobile_number,$mail_staus_string[1]);
							   }
							   else if($mail_staus_string[0]	==	'ERROR')
							   {
									$this->insert_history_data($today,"",$new_message,$text_count,"",'Monthly Records','Monthly details','','admin_monthly', $admin_mobile_number,$mail_staus_string[1]);
							   }
						 }
					}
				}

				function check_user_verification()
				{
					$exist_user 		= get_option( 'woocommerce_user_template_verification_existing' );
					if(is_user_logged_in())
					{
						$user 				= wp_get_current_user();
						$user_id 			= $user->ID;
						$get_verification 	= get_user_meta( $user_id, 'verification',true);
						$settings_general   = get_option( 'woocommerce_SMSCountry_settings_general' );
						//$to 				= $settings_general['txt_admin_Email'];
						$to  				=  $user->user_email;
						$today   						= date("Y-m-d H:i:s");
						if($exist_user['chk_user_sign_up_verify_exists'])
						{
							if($get_verification !=1)
							{
								$sign_up_text 		= $exist_user['txt_area_sing_up_exists'];
								$site_title    		= $settings_general['txt_site_title'];
								$domain     		= $_SERVER['HTTP_HOST'];
								if($get_verification == 0 || $get_verification =='')
								{
								  $phone_no = get_user_meta( $user_id, 'phone_no',true);
								  ?>
								  <script>
								   jQuery(document).ready(function() 
								   {
										jQuery('body').prepend('<div class="login_overlay"></div>');
										jQuery('#simple_popup').show("slow");
										jQuery(".close").on('click', '.login_overlay, .close', function ()
										{
												jQuery('#simple_popup').hide("slow");
												jQuery('.login_overlay').remove();
												return false;
		
										});
										jQuery('form#recommend_frm').submit(function()
										{ 
										  // var mob 		 = /^\d{12}$/;
										   var mob 		 = /^[\d]{10,13}$/;
										   var mob_no     =   jQuery('form#recommend_frm .username').val();
										   var ver_no     =   jQuery('form#recommend_frm .verification_no').val();
										   if (jQuery('.username').length > 0)
										   {
											  if(!mob.test(mob_no))
											  {
												  alert('Please enter  valid mobile no ');
												  jQuery('form#recommend_frm .username').focus();
												  return false;
											  }
											  else if(mob_no=="")
											  {
												  alert('Please enter  mobile no');
												  jQuery('form#recommend_frm .username').focus();
												  return false;
											  }
										   }
										   if(ver_no == '')
										  {
											alert('Please enter verification code');
											jQuery('form#recommend_frm .verification_no').focus();
											return false;
										  }
		
									  }); 							
								  });
								  </script>
								  <?php
								  $status  		= '';
								  $rand_otp 		= '';//wp_nonce_field('ajax-login-nonce', 'security'); 
								  $error_msg 		= '';
								  if(isset($_POST['btn_submit']))
								  {
									  if(isset($_POST['mobile_no']) && $_POST['mobile_no'] !='')
									  {
										  $mobile_no 				= trim($_POST['mobile_no']);
										  update_user_meta( $user_id, 'phone_no',$mobile_no );
									  }
									  else
									  {
										  update_user_meta( $user_id, 'phone_no',$phone_no );
									  }
									  $rand_otp		    			=     mt_rand(1000,9999);
									  update_user_meta( $user_id, 'user_verification_code',$rand_otp );
									  $phone_no 					= get_user_meta( $user_id, 'phone_no',true);
									  $search     					= array("[shop_name]","[shop_domain]","[verification_code]");
									  $replace   					= array($site_title,$domain,$rand_otp);   
									  $new_message   				= str_replace($search, $replace,$sign_up_text);
									  $text_count   				= strlen($new_message);
									  $user_mail 					= $this->send_test_email($to,$phone_no,"Code Verification SMS",$new_message);
									  $mail_staus_string=explode(":",$user_mail);
									  $status						= $mail_staus_string[0];
									  if($mail_staus_string[0]	==	'SUCCESS')//check email is send
							   		  {
										$this->insert_history_data($today,"",$new_message,$text_count,"",'Verification Code','Verification Code','','no_verify', $phone_no,$mail_staus_string[1]);
							   		  }
							   		  else if($mail_staus_string[0]	==	'ERROR')
							          {
									     $this->insert_history_data($today,"",$new_message,$text_count,"",'Verification Code','Verification Code','','no_verify', $phone_no,$mail_staus_string[1]);
							          }
									//  echo $status;
								  }
								  if(isset($_POST['btn_verify']))
								  {
									  $user_verification_code			 = get_user_meta( $user_id, 'user_verification_code',true);
									  $verify_code 				 		 = trim($_POST['verification_no']);
									  if($user_verification_code == $verify_code  )
									  {
										   update_user_meta( $user_id, 'verification',1);
										   echo '<script>location.reload();</script>';
									  }
									  else
									  {
										  $error_msg  = "Enter Correct Verification Number<br/>";
										  $status		=	'SUCCESS';
									  }
								  }
								  ?>
								  <div id="simple_popup" class="ajax-auth">
								  <h3><?php if($status=='SUCCESS')
								   {
									  ?> Please enter your Verification Code? <?php 
								   } 
								   else 
								   {
										  ?>Please enter your Mobile Number?<?php 
									}?></h3>
									<hr />
									<p class="status"></p>
									<form method="post" id="recommend_frm">
									<?php if($status=='SUCCESS') 
									{
										echo '<p>'.$error_msg.'</p>';
										?>
									<label for="username">Enter Verification Code</label>
									<input id="username" type="text" class="required verification_no" name="verification_no" value="" >
									<input class="submit_button" type="submit" value="Verify" name="btn_verify">
									<?php 
									}
									else 
									{ ?>
									<label for="username">Enter Mobile No To verify</label>
									<input id="username" type="text" class="required username" name="mobile_no" value="<?php if($phone_no !=''){echo $phone_no;}?>"  size="13">
									<br/>
									 <label for="username">Enter you mobile number with country code. We will send SMS verification code, to verify your mobile</label>
									<input class="submit_button" type="submit" value="Submit" name="btn_submit">
									<?php 
									} ?>
									</form>
									<a class="close" href="">(close)</a> </div>
									<?php
										}
							  }
						}
						/*else
						{
							//echo "else";die;
							if($get_verification ==0 || $get_verification =='')
							{
								
								$sign_up_text 		= $exist_user['txt_area_sing_up_exists'];
								$settings_general   = get_option( 'woocommerce_SMSCountry_settings_general' );
								$site_title    		= $settings_general['txt_site_title'];
								$domain     		= $_SERVER['HTTP_HOST'];
								if($get_verification == 0 || $get_verification =='')
								{
								  $phone_no = get_user_meta( $user_id, 'phone_no',true);
								  ?>
								  <script>
								   jQuery(document).ready(function() 
								   {
										jQuery('body').prepend('<div class="login_overlay"></div>');
										jQuery('#simple_popup').show("slow");
										jQuery(".close").on('click', '.login_overlay, .close', function ()
										{
												jQuery('#simple_popup').hide("slow");
												jQuery('.login_overlay').remove();
												return false;
		
										});
										jQuery('form#recommend_frm').submit(function()
										{ 
										   var mob 		 = /^\d{12}$/;
										   var mob_no     =   jQuery('form#recommend_frm .username').val();
										   var ver_no     =   jQuery('form#recommend_frm .verification_no').val();
										   if (jQuery('.username').length > 0)
										   {
											  if (!mob.test(mob_no)) 
											  {
												  alert('Please enter  mobile no');
												  jQuery('form#recommend_frm .username').focus();
												  return false;
											  }
											  else if(mob_no=="")
											  {
												  alert('Please enter  mobile no');
												  jQuery('form#recommend_frm .username').focus();
												  return false;
											  }
										   }
										   if(ver_no == '')
										  {
											alert('Please enter verification code');
											jQuery('form#recommend_frm .verification_no').focus();
											return false;
										  }
		
									  }); 							
								  });
								  </script>
								  <?php
								  $status  		= '';
								  $rand_otp 		= '';//wp_nonce_field('ajax-login-nonce', 'security'); 
								  $error_msg 		= '';
								  if(isset($_POST['btn_submit']))
								  {
									  if(isset($_POST['mobile_no']) && $_POST['mobile_no'] !='')
									  {
										  $mobile_no 				= trim($_POST['mobile_no']);
										  update_user_meta( $user_id, 'phone_no',$mobile_no );
									  }
									  else
									  {
										  update_user_meta( $user_id, 'phone_no',$phone_no );
									  }
									  $rand_otp		    			=     mt_rand(1000,9999);
									  update_user_meta( $user_id, 'user_verification_code',$rand_otp );
									  $phone_no 					= get_user_meta( $user_id, 'phone_no',true);
									  $search     					= array("[shop_name]","[shop_domain]","[verification_code]");
									  $replace   					= array($site_title,$domain,$rand_otp);   
									  $new_message   				= str_replace($search, $replace,$sign_up_text);
									  $text_count   				= strlen($new_message);
									  $user_mail 					= $this->send_test_email($to,$phone_no,"Code Verification SMS",$new_message);
									  $mail_staus_string=explode(":",$user_mail);
									  $status						= $mail_staus_string[0];
									//  echo $status;
									//  die;
								  }
								  if(isset($_POST['btn_verify']))
								  {
									  $user_verification_code			 = get_user_meta( $user_id, 'user_verification_code',true);
									  $verify_code 				 		 = trim($_POST['verification_no']);
									  if($user_verification_code == $verify_code  )
									  {
										   update_user_meta( $user_id, 'verification',1);
										   echo '<script>location.reload();</script>';
									  }
									  else
									  {
										  $error_msg  	= "Enter Correct Verification Number<br/>";
										  $status		=	'SUCCESS';
									  }
								  }
								  ?>
								  <div id="simple_popup" class="ajax-auth">
								  <h3><?php if($status=='SUCCESS')
								   {
									  ?> Please enter your Verification Code? <?php 
								   } 
								   else 
								   {
										  ?>Please enter your Mobile Number?<?php 
									}?></h3>
									<hr />
									<p class="status"></p>
									<form method="post" id="recommend_frm">
									<?php if($status=='SUCCESS') 
									{
										echo '<p>'.$error_msg.'</p>';
										?>
									<label for="username">Enter Verification Code</label>
									<input id="username" type="text" class="required verification_no" name="verification_no" value="" >
									<input class="submit_button" type="submit" value="Verify" name="btn_verify">
									<?php 
									}
									else 
									{ ?>
									<label for="username">Enter Mobile No To verify</label>
									<input id="username" type="text" class="required username" name="mobile_no" value="<?php if($phone_no !=''){echo $phone_no;}?>" >
									<br/>
									 <label for="username">Enter Your Mobile No we will send SMS verification code to verify user</label>
									<input class="submit_button" type="submit" value="Submit" name="btn_submit">
									<?php 
									} ?>
									</form>
									<a class="close" href="">(close)</a> </div>
									<?php
										}
							  
							}
							
						}*/
					 }
					}

				//function for send sms to contact enquiry
				function send_contact_enquiry_sms()
				{
					  $fullname 					= $_POST['your-name'];
					  $fullname_arr  				= explode(" ",$fullname);
					  $lastname 					= $fullname_arr[2];
					  $email						= $_POST['your-email'];
					  $message						= $_POST['your-message'];
					  $settings_general     		= get_option( 'woocommerce_SMSCountry_settings_general' );
					  $today    					= date("Y-m-d H:i:s"); 
					  $string						= $fullname;
					  $site_title    				= $settings_general['txt_site_title'];
					  $admin_mobile_number			= $settings_general['txt_admin_mob_number'];
					  $admin_email					= $settings_general['txt_admin_Email'];
					  $domain     					= $_SERVER['HTTP_HOST'];
					  $contact_inquiry				= get_option( 'woocommerce_admin_template_contact_inquiry' );
					  $contact_inquiry_msg 			=  $contact_inquiry['admin_txt_area4'];
					  $search     					= array("[shop_name]","[shop_domain]","[customer_name]","[customer_email]","[customer_message]");
					  $replace   					= array($site_title,$domain,$fullname,$email,$message);   
					  $new_message1   				= str_replace($search, $replace,$contact_inquiry_msg);
					  $new_message	 				= substr($new_message1, 0, 200);
					  $text_count   				= strlen($new_message);
					  $subject   		   			= 'Contact enquiry email';
					  
					  //wp_mail( 'mapweb.sse8@gmail.com','Contact enquiry email',$new_message,'contact enquiry message from customer');
					  
					  $mail_status 					= $this->send_test_email($admin_email,$admin_mobile_number,$subject,$new_message);
					  $mail_staus_string			= explode(":",$mail_status);
					   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
					   {
					  		$this->insert_history_data($today,"",$new_message,$text_count,$fullname,'contact details','Contact details','','admin_contact', $admin_mobile_number,$mail_staus_string[1]);
	 				   }
					   else if($mail_staus_string[0]	==	'ERROR')
					   {
							$this->insert_history_data($today,"",$new_message,$text_count,$fullname,'contact details','','','admin_contact', $admin_mobile_number,$mail_staus_string[1]);
						}
				}
        		
				// function for create the table
				function load_history_table() 
				{
					 global $wpdb;
					 $table_history     =    $wpdb->prefix . 'smscountry_history';
					 // create table wp_deal
					 if($wpdb->get_var("show tables like ".$table_history) != $table_history) 
					 {
						    $history_sql  =    

											  "CREATE TABLE IF NOT EXISTS ".$table_history." (
											  `sms_id` int(11) NOT NULL AUTO_INCREMENT,
											  `user_id` int(11) NOT NULL,
											  `date_time` datetime NOT NULL,
											  `message_text` text NOT NULL,
											  `msg_character_count` int(11) NOT NULL,
											  `name_recipient` varchar(200) NOT NULL,
											  `message_type` varchar(100) NOT NULL,
											  `message_status` varchar(100) NOT NULL,
											  `sms_flag` varchar(100) NOT NULL,
											  `mobile_no` bigint(11) NOT NULL,
											  `job_no` int(20) NOT NULL,
											  `dynamic_delivery_report` text NOT NULL,
											  `otp` int(11) NOT NULL,
											  PRIMARY KEY (`sms_id`)
											) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
					  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
					  dbDelta($history_sql);
					 }
        		}
				
				// Add phone number fields in registration form
			    function show_phone_no_field()
				{
					?>
					 <p>
					 <label>Phone No<br/>
					 <input id="phone_no" type="text" tabindex="30" size="25" value="<?php if(isset($_POST['phone_no'])){echo $_POST['phone_no']; }?>" name="phone_no" />
                     <br/>Please Enter No with country code<br/>
					 </label>
					 </p>
					<?php
				}
            	function check_fields ( $login, $email, $errors )
				{
						 global $phone_no;
						 if ( $_POST['phone_no'] == '' )
						 {
						  $errors->add( 'empty_realname', "<strong>ERROR</strong>: Please Enter your phone number" );
						 }
						 else
						 {
						  $phone_no = $_POST['phone_no'];
						 }

				 }
	            
				//function for user registration
				function user_registers( $user_id )
				{
					global $wpdb;
					$get_sign_up   				= get_option( 'woocommerce_user_template_sign_up' );
					$get_admin_sign_up			= get_option( 'woocommerce_admin_template_sign_Up'); 
					
					update_user_meta( $user_id, 'verification',0);
					$user_id_for_validate		= $user_id;
					update_user_meta( $user_id, 'phone_no', $_POST['phone_no'] );
					update_user_meta( $user_id, 'billing_phone', $_POST['phone_no'] );
					$userdata   				= array();
					$userdata['ID'] 			= $user_id;
					$user    					= new WP_User( $user_id );
					$user_email_id  			=  $user->user_email;
					$today   					=  date("Y-m-d H:i:s"); 
				    $user_name   				=  $user->user_login;
				    $user_full_name	 			=  $user->user_nicename;
				    $explode_name_arr 			=  explode("-",$user_full_name);
				    $user_email_id  			=  $user->user_email;
				    $user_full_name1 			=  $user->user_login;
				    $settings_general     		= get_option( 'woocommerce_SMSCountry_settings_general' );
				    $admin_mobile_number		= $settings_general['txt_admin_mob_number'];
				    $admin_email				= $settings_general['txt_admin_Email'];
				    $site_title    				= $settings_general['txt_site_title'];
				    $domain    					= $_SERVER['HTTP_HOST'];
				    $phone_no   				= get_user_meta( $user_id, 'phone_no',true);
					$rand_otp					= mt_rand(0,9999);
				//insert new field phone no
				   $get_sign_up   				= get_option( 'woocommerce_user_template_sign_up' );
				   $get_sign_up_msg  			= $get_sign_up['txt_area1'];
				   $get_admin_sign_up			= get_option( 'woocommerce_admin_template_sign_Up');//get admin signup text
				   $get_sign_up_msg_for_admin 	= $get_admin_sign_up['admin_txt_area'];
				   $search  		   			= array("[customer_firstname]", "[customer_lastname]","[shop_name]","[shop_domain]");
				   $replace   		   			= array($explode_name_arr[0], $explode_name_arr[2],$site_title,$domain);   
				   $new_message  	   			= str_replace($search, $replace, $get_sign_up_msg);
				   $new_message_admin  			= str_replace($search, $replace, $get_sign_up_msg_for_admin);
				   $subject   		   			= 'register mail';
				  // $to     			  			= 'mapweb.sse8@gmail.com';
				   $text    		   			= $new_message;
				   $text_count   	   			= strlen($text);
				   $admin_txt_count    			= strlen($new_message_admin);
				   //query for update set the status for registered user
				   
				    //$wpdb->query("UPDATE ".$wpdb->prefix."users SET `user_status` = '1' WHERE `ID`=".$user_id );
					if($get_sign_up['chk_user_sign_up'] || $get_admin_sign_up['chk_admin_sign_up'])
					//check user/admin checkbox is enable
					{
					   if($get_sign_up['chk_user_sign_up'])//check user checkbox is enable
					   {
							$mail_status  			= $this->send_test_email($user_email_id,$phone_no,$subject,$text);
                            
							$mail_staus_string		= explode(":",$mail_status);
						    //SUCCESS:Email Send Successfully
						    if($mail_staus_string[0]	==	'SUCCESS')//check email is send
						    {
								$this->insert_history_data($today,$user_id,$text,$text_count,$user_full_name1,'New Customer Signup','register',$rand_otp,'user_signup',$phone_no,$mail_staus_string[1]);
							}
							else if($mail_staus_string[0]	==	'ERROR')
							{
								$this->insert_history_data($today,$user_id,$text,$text_count,$user_full_name1,'','',$rand_otp,'user_signup',$phone_no,$mail_staus_string[1]);
							}
							
					   }
					   if($get_admin_sign_up['chk_admin_sign_up'])//check admin checkbox is enable 
 					   {
						   $mail_status 			= $this->send_test_email($admin_email,$admin_mobile_number,$subject,$new_message_admin);
						   $mail_staus_string		= explode(":",$mail_status);
						   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
						   {
                               $this->insert_history_data($today,$user_id,$new_message_admin,$admin_txt_count,$user_full_name1,'New Customer Signup','register',$rand_otp,'admin_signup', $admin_mobile_number,$mail_staus_string[1]);
						   }
						     else if($mail_staus_string[0]	==	'ERROR')
							{
								 $this->insert_history_data($today,$user_id,$new_message_admin,$admin_txt_count,$user_full_name1,'New Customer Signup','',$rand_otp,'admin_signup', $admin_mobile_number,$mail_staus_string[1]);
							}
					   }
					   
				 }
				       //code for send otp to sing up user
					    $user_template_sign_verify		= get_option( 'woocommerce_user_template_verification' );
				       	$sing_up_verify_message_format	=$user_template_sign_verify['txt_area'];
						$verify_placeholder_array  		= array("[shop_name]","[shop_domain]","[verification_code]");
					    $verify_placeholder_replace   	= array($site_title,$domain,$rand_otp);   
						$sign_up_verify_message 	   	= str_replace($verify_placeholder_array,$verify_placeholder_replace,$sing_up_verify_message_format);
						$otp_message_text_count   	   			= strlen($sign_up_verify_message);
						//$otp_text="Your OTP Verification: .".$rand_otp;
						$subject_otp="OTP verification";
						if($user_template_sign_verify['chk_user_sign_up_verify'])
						{
							$mail_status  		= $this->send_test_email($user_email_id,$phone_no,$subject_otp,$sign_up_verify_message);
							$mail_staus_string		= explode(":",$mail_status);
					        if($mail_staus_string[0]	==	'SUCCESS')//check email is send
						    {
                               $this->insert_history_data($today,$user_id,$sign_up_verify_message,$otp_message_text_count,$user_full_name1,'OTP Registration','OTP SEND',$rand_otp,'otp_registration', $phone_no,$mail_staus_string[1]);
						    }
						     else if($mail_staus_string[0]	==	'ERROR')
							{
								  $this->insert_history_data($today,$user_id,$sign_up_verify_message,$otp_message_text_count,$user_full_name1,'OTP Registration','',$rand_otp,'otp_registration', $phone_no,$mail_staus_string[1]);
							}
							
							$get_otp_record		=	$wpdb->get_results("select * from ".$wpdb->prefix."smscountry_history ORDER BY `sms_id` DESC");
                            $get_otp_id			=	$get_otp_record[0]->sms_id;
							session_start();  
							$_SESSION["otp_id"] = $get_otp_id;
					    }
			  }
			   
			    //function for send sms on chnage order status
			   public function send_order_status_sms($order_id) 
				{
					//echo $this->order_status_flag;die;
					if($this->order_status_flag == 'true')
					{
						
					}
					else  if($this->order_status_flag == 'false'  || $this->order_status_flag != 'true' )
					{
						
					
					$order_return   				= get_option( 'woocommerce_user_template_return_order' );
					$order_return_admin				= get_option( 'woocommerce_admin_template_return_order' );
					$order_changed   				= get_option( 'woocommerce_user_template_order_changed' );
					$place_order_alert_for_user		= get_option( 'woocommerce_user_template_new_order');
					$place_order_alert_for_admin	= get_option( 'woocommerce_admin_template_sms_alert' );
					// if( $place_order_alert_for_user['chk_user_new_order'] || $place_order_alert_for_admin['chk_admin_order_sms_alert'] )
					if($order_return ['chk_user_order_return'] || $order_return_admin['chk_admin_return_order'] || $order_changed['chk_user_order_changed'] || $place_order_alert_for_user['chk_user_new_order'] || $place_order_alert_for_admin['chk_admin_order_sms_alert'] ) //check user/admin checkbox is enable
					{
						
					   global $wpdb;
					   $count 				= 0;
					   $order     			=  new WC_Order( $order_id );
					  //echo "<pre>"; print_r( $order); echo "</pre>";die;
					   $order_id    			= $order->id;
					   $today     			= date("Y-m-d H:i:s");
					   $args = array(
						'post_id'  => $order_id,
						'approve'  => 'approve',
						'type'   => 'order_note',
						'order'    =>'desc'
					   );
					   $notes		  		= get_comments( $args );
					   $old_staus           = $notes[0]->comment_content;
					   $status  	  		= $order->get_status();
					   $date        		= $order->order_date;
					   $prod_name   		= '';
					   $city     	  		= get_post_meta($order_id,'_billing_city',true);
					   $first_name  		= get_post_meta($order_id,'_billing_first_name',true);
					   $last_name   		= get_post_meta($order_id,'_billing_last_name',true);
					   $address     		= get_post_meta($order_id,'_billing_address_1',true);
					   $postcode    		= get_post_meta($order_id,'_billing_postcode',true);
					   
					   $country     		= get_post_meta($order_id,'_billing_country',true);
					   $phone     			= get_post_meta($order_id,'_billing_phone',true);
					   $order_total 		= get_post_meta($order_id,'_order_total',true);//$order->get_total();
					   $refund_reason 		= get_post_meta($order_id,'_refund_reason',true);
					   $_orderitem   		=   $order->get_items();
					   //echo "<pre>"; print_r( $_orderitem); echo "</pre>";die;
					   $user_full_name1   	= $first_name." ".$last_name;
					   foreach($_orderitem as $order_product_detail)
					   {
						 $count++;
						 $prod_name 		.= $order_product_detail['name'];
						 $prod_count_qty    += $order_product_detail['qty'];
					   }
					   //$product_count    = $count;
					   $product_count    = $prod_count_qty;
					   $settings_general     		= get_option( 'woocommerce_SMSCountry_settings_general' );
					   
					   $user_email    				= get_post_meta($order_id,'_billing_email',true);
					   $admin_email					= $settings_general['txt_admin_Email'];
					   $admin_mobile_number			= $settings_general['txt_admin_mob_number'];
					   $site_title    				= $settings_general['txt_site_title'];
					   $domain     	   	 = $_SERVER['HTTP_HOST'];
			//		   if($status == 'refunded')
						if($status == 'want-be-returned' || $status == 'refunded')
					   {
							 $order_return   			= get_option( 'woocommerce_user_template_return_order' );
							 $order_return_msg  		= $order_return['txt_area3'];
							 $order_return_admin		= get_option( 'woocommerce_admin_template_return_order' );
							 $order_return_msg_admin    = $order_return_admin['admin_txt_area3'];
							 $search    				= array("[order_products_count]","[order_total]","[order_id]","[customer_firstname]", "[customer_lastname]","[customer_address]","[customer_postcode]","[customer_city]","[customer_country]","[shop_name]","[shop_domain]","[return_product_name]","[return_reason]","[order_status]","[order_date]");
							 $replace    				= array($product_count,$order_total,$order_id,$first_name,$last_name,$address,$postcode,$city,$country,$site_title,$domain,$prod_name,$refund_reason,$status,$date);  
							 $new_message  		    = str_replace($search, $replace, $order_return_msg);
							 $new_message_admin     = str_replace($search, $replace, $order_return_msg_admin);
							 $subject     			= 'order Refund mail';
							// $to     				= 'mapweb.sse8@gmail.com';
							 $text     				= $new_message;
							 $text2					= $new_message_admin;
							 $text_count    		= strlen($text);
							 $ad_text_count    		= strlen($text2);
							 if($order_return ['chk_user_order_return']) //check user checkbox is enable
							 {
								  $mail_status 			=  $this->send_test_email($user_email,$phone,$subject,$text);
								  $mail_staus_string	=  explode(":",$mail_status);
								 // print_r( $mail_staus_string);die;
								   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
								   {
									 $this->insert_history_data($today,"",$text,$text_count,$user_full_name1,'Refund Order',$status,'','user_refund',$phone,$mail_staus_string[1]);
								   }
								   else if($mail_staus_string[0]	==	'ERROR')
									{
										$this->insert_history_data($today,"",$text,$text_count,$user_full_name1,'Refund Order','','','user_refund',$phone,$mail_staus_string[1]);
									}
								 
							 }

							
							 if($order_return_admin['chk_admin_return_order'])//check admin checkbox is enable
							 {
								$mail_status 		=  $this->send_test_email($admin_email,$admin_mobile_number,$subject,$text2);
								$mail_staus_string	=  explode(":",$mail_status);
							   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
							   {
									$this->insert_history_data($today,'',$text2,$ad_text_count,$user_full_name1,'Refund Order',$status,'','admin_refund', $admin_mobile_number,$mail_staus_string[1]);
							   }
							   else if($mail_staus_string[0]	==	'ERROR')
							   {
									$this->insert_history_data($today,'',$text2,$ad_text_count,$user_full_name1,'Refund Order','','','admin_refund', $admin_mobile_number,$mail_staus_string[1]);
							   }
								
							 }
					   }
					   else
					   {
						  // echo "dfgfdgdf";
							 $order_changed   			= get_option( 'woocommerce_user_template_order_changed' );
							  $order_chnage_msg   		=  $order_changed['txt_area4'];
							 $search     				= array("[order_date]","[order_new_status]","[order_old_status]","[order_products_count]","[order_total]","[order_id]","[customer_firstname]", "[customer_lastname]","[customer_address]","[customer_postcode]","[customer_city]","[customer_country]","[shop_name]","[shop_domain]");
							 $replace    				= array($date, $status,$old_staus ,$product_count,$order_total,$order_id,$first_name,$last_name,$address,$postcode,$city,$country,$site_title,$domain);   
							 $new_message   			= str_replace($search, $replace, $order_chnage_msg);
							 $subject     				= 'order status mail';
							 //$to     				    = 'mapweb.sse8@gmail.com';
							 $text    					= $new_message;
							 $text_count    			= strlen($text);
							 if($order_changed['chk_user_order_changed'])//check user checkbox enable
							 {
								   $mail_status 			= $this->send_test_email($user_email,$phone,$subject,$text);
								   //echo  $mail_status;die;
								   $mail_staus_string		= explode(":",$mail_status);
								   if($mail_staus_string[0]	==	'SUCCESS')//check email is send
								   {
									    $this->insert_history_data($today,'',$text,$text_count,$user_full_name1,'Order Status Change',$status,'','user_order_status',$phone,$mail_staus_string[1]);
								   }
								   else if($mail_staus_string[0]	==	'ERROR')
								   {
										$this->insert_history_data($today,'',$text,$text_count,$user_full_name1,'Order Status Change','','','user_order_status',$phone,$mail_staus_string[1]);
                 		           }
							 }
					   }
				   }
				}
				 }
				 
				//function for sen sms for place new order 
			public	function send_new_order_place_sms($order_id) 
				{
					//echo  $this->order_status_flag."test";
					$this->order_status_flag = 'true';
				//  echo $c."sdfsdfds";die;
					//echo $order_status_flag = 'true';
					 $place_order_alert_for_user	= get_option( 'woocommerce_user_template_new_order');
					 $place_order_alert_for_admin   =   get_option( 'woocommerce_admin_template_sms_alert' );
					 if( $place_order_alert_for_user['chk_user_new_order'] || $place_order_alert_for_admin['chk_admin_order_sms_alert'] )  //check user/admin checkbox is enable
					 {
						 $order 			= new WC_Order( $order_id );
						 $count 			= 0;
						 $today 			= date("Y-m-d H:i:s");
						 $order_id    		= $order->id;
						 $order_status  	=  $order->get_status(); //returns 'pending' even on successfull payment
						 $city     			= get_post_meta($order_id,'_billing_city',true);
						 $first_name    	= get_post_meta($order_id,'_billing_first_name',true);
						 $last_name    		= get_post_meta($order_id,'_billing_last_name',true);
						 $address    		= get_post_meta($order_id,'_billing_address_1',true);
						 $phone     		= get_post_meta($order_id,'_billing_phone',true);
						 $postcode    		= get_post_meta($order_id,'_billing_postcode',true);
						 $country    		= get_post_meta($order_id,'_billing_country',true);
						 $order_total   	= get_post_meta($order_id,'_order_total',true);//$order->get_total();
						 $_orderitem    	=   $order->get_items();
						 $user_full_name1   = $first_name." ".$last_name;
						 foreach($_orderitem as $order_product_detail)
						 {
							 $count++;
							 $prod_count_qty    += $order_product_detail['qty'];
						 }
						 //$product_count   				 = $count;
						 $product_count   				     = $prod_count_qty;
						 $settings_general     			 = get_option( 'woocommerce_SMSCountry_settings_general' );
						 
						 $user_email    				= get_post_meta($order_id,'_billing_email',true);
					  	 $admin_email					= $settings_general['txt_admin_Email'];
						 
						 $admin_mobile_number			 = $settings_general['txt_admin_mob_number'];
					     $site_title    				 = $settings_general['txt_site_title'];
						 $domain     	   				 =   $_SERVER['HTTP_HOST'];
						 $user_full_name1  = $first_name." ".$last_name ;
						//get values from database
						 $place_order_alert_for_user	= get_option( 'woocommerce_user_template_new_order');
						 $place_order_alert_for_admin   =   get_option( 'woocommerce_admin_template_sms_alert' );
						//get placeholders from textarea
						 $place_order_msg_for_user      =   $place_order_alert_for_user['txt_area_new_order'];
						 $place_order_msg_for_admin     =   $place_order_alert_for_admin['admin_txt_area2'];
						 $search     =   array("[order_products_count]","[order_total]","[order_id]","[customer_firstname]", "[customer_lastname]","[customer_address]","[customer_postcode]","[customer_city]","[customer_country]","[shop_name]","[shop_domain]","[order_status]");
						 $replace    					=  array($product_count,$order_total,$order_id,$first_name,$last_name,$address,$postcode,$city,$country,$site_title,$domain,$order_status);    

						 $new_message_user   		    =  str_replace($search, $replace, $place_order_msg_for_user);
						 $new_message_admin             =  str_replace($search, $replace, $place_order_msg_for_admin);
						 $subject    					=  'new order placed mail';
						// $to      						=  'mapweb.sse8@gmail.com';
						 $text1     					=  $new_message_user;
						 $text2     					=  $new_message_admin;
						 $text_count    				=  strlen($text1);
						 $ad_text_count    				=  strlen($text2);
						 if( $place_order_alert_for_user['chk_user_new_order'])//check user checkbox enable
						 {

							 $mail_status = $this->send_test_email($user_email,$phone,$subject,$text1);

							 $mail_staus_string=explode(":",$mail_status);
						  
							 if($mail_staus_string[0]	==	'SUCCESS')//check email is send
							   {
							  		$this->insert_history_data($today,'',$text1,$text_count,$user_full_name1,'New Order Placed','New order','','user_new_order',$phone,$mail_staus_string[1]);
  							  }
						   	 else if($mail_staus_string[0]	==	'ERROR')
							  {
								$this->insert_history_data($today,'',$text1,$text_count,$user_full_name1,'','New order','','user_new_order',$mail_staus_string[1]);

							  }
						  
						  }

						 if( $place_order_alert_for_admin['chk_admin_order_sms_alert'])//check admin checkbox enable

						 {

							 $mail_status = $this->send_test_email($admin_email,$admin_mobile_number,$subject,$text2);
							 $mail_staus_string=explode(":",$mail_status);
						  	 if($mail_staus_string[0]	==	'SUCCESS')//check email is send
						 	 {
						  		 $this->insert_history_data($today,'',$text2,$ad_text_count,$user_full_name1,'New Order Placed','New order','','admin_new_order', $admin_mobile_number,$mail_staus_string[1]);
						  	 }
						  	 else if($mail_staus_string[0]	==	'ERROR')
							 {
								$this->insert_history_data($today,'',$text2,$ad_text_count,$user_full_name1,'New Order Placed','','','admin_new_order', $admin_mobile_number,$mail_staus_string[1]);
                             }
						} 
					 }
				}

				 //function for inserting a data
				public function insert_history_data($today,$user_id,$text,$text_count,$user_full_name1,$msg_type,$status,$opt,$sms_flag,$mobile_no,$job_number)
			 	{ 
					 global  $wpdb;
					 $table_history     = $wpdb->prefix.'smscountry_history';
					 $insert_record 	= "INSERT INTO ".$table_history."( `date_time`,`user_id`,`message_text`, `msg_character_count`, `name_recipient`, `message_type`, `message_status`, `otp`,`sms_flag`,`mobile_no`,`job_no`) VALUES ('".$today ."','".$user_id."','".$text."','". $text_count."','".$user_full_name1."','".$msg_type."','".$status."','".$opt."','".$sms_flag."','".$mobile_no."','".$job_number."')";
					 $wpdb->query($insert_record);
				}
	
#REST API function for sending a sms

		

                    public function send_test_email($to,$phone,$subject,$text)
                                {
					$settings_general     = get_option( 'woocommerce_SMSCountry_settings_general' );
	                                  $send_sms_email               = $settings_general['send_sms_email'];

                                        $auth_key= $settings_general['txt_username']; //'TNCjcTChDkYHrFMjadbs';
                                        $auth_token= $settings_general['txt_password']; //'nU3PQQrdVJaKJ7pKZ3Ql6rtiGbnDY5WZyhReJ4sJ';
                                        $url = "https://restapi.smscountry.com/v0.1/Accounts/".$auth_key."/SMSes/";
                                        $DRNotifyUrl = site_url(); //'http://woocommerce.smscountry.com';
                        //              $DRNotifyHttpMethod="POST";
//                                      $text = urlencode($text);
                                        $headers = array(
                                                        "Content-Type: application/json",
                                                        "Authorization: Basic ". base64_encode($auth_key . ":" . $auth_token));

                                        if($settings_general['txt_seinder_id'] == '')
                                                $senderid      = ''; //Your senderid
                                        else
                                                $senderid      = $settings_general['txt_seinder_id']; //Your senderid
//					$senderid      = '';

                                        if($send_sms_email == 'active')//TO send email
                                  {
                                                $email_status    =  wp_mail($to,$subject,$text);
                                                $status                  =  $email_status ?'send':'not send';
                                                if($status      ==      'send')
                                                {
                                                        //return "send";
                                                        return 'SUCCESS:Email Send Successfully.';
                                                }
                                                else
                                                {
                                                        return 'ERROR:Error in Sending Email.';
                                                }
                                  }
                                  else
                                  {

                                        $rest = curl_init();
				
				                                       if (!$rest){
                                                 die("Couldn't initialize a CURL handle");
                                        }
                                        curl_setopt($rest,CURLOPT_URL,$url);
                                        curl_setopt($rest,CURLOPT_HTTPHEADER,$headers);
                                        curl_setopt($rest, CURLOPT_POST, TRUE);
                                        curl_setopt($rest, CURLOPT_POSTFIELDS, "{
                                                        \"Text\": \"$text\",
                                                        \"Number\": \"$phone\",
                                                        \"SenderId\": \"$senderid\",
                                                        \"DRNotifyUrl\": \"$DRNotifyUrl\",
                                                        \"DRNotifyHttpMethod\": \"$DRNotifyHttpMethod\"
                                                }");
                                        curl_setopt($rest,CURLOPT_SSL_VERIFYPEER, false);
                                        $ret = curl_setopt($rest,CURLOPT_RETURNTRANSFER, true);
                                        $curl_response = curl_exec($rest);

                                        if (curl_errno($rest))
                                                        echo 'curl error : ' . curl_error($rest);
                                        if(empty($ret)){

                                                // some kind of an error happened
                                                die(curl_error($rest));
                                                curl_close(rest); // close cURL handler
                                                return 'ERROR:Something is worng.';

                                       }else{

                                                $info = curl_getinfo($rest);
                                                        curl_close($rest); // close cURL handler
                                                        $response = json_decode($curl_response);

                     if($response->Success === "True")
                                                        {

						
                                                return 'SUCCESS:'.$response->MessageUUID; //echo "Message Sent Succesfully" ;
                                                        }
                                                       else
                                                        {
                                                                //Error in the sending sms
                                                                return 'ERROR:'.$response->Message;exit;
                                                        }
                                        }


                                        curl_close($rest);
                                  }

                                }


				//function for sending a mail
				public function send_test_email2($to,$phone,$subject,$text)
				{
				  #Get option value, 1 to send SMS & 0 to send Email
				  $settings_general     = get_option( 'woocommerce_SMSCountry_settings_general' );
				  $send_sms_email 		= $settings_general['send_sms_email'];
				  //echo  $send_sms_email;
				  if($send_sms_email == 'active')//TO send email
				  {
						$email_status    =  wp_mail($to,$subject,$text);
						$status			 =  $email_status ?'send':'not send';
						if($status	==	'send')
						{
							//return "send";
							return 'SUCCESS:Email Send Successfully.';
						}
						else
						{
							return 'ERROR:Error in Sending Email.';
				 		}
				  }	
				  else
				  {
						$user          = $settings_general['txt_username']; //your username
						$password      = $settings_general['txt_password']; //your password
						$sel_lang      = $settings_general['sel_lang'];		//your sel_lang
						$mobilenumbers = $phone; //enter Mobile numbers comma seperated
						$message       = $text; //enter Your Message
						
						if($settings_general['txt_seinder_id'] == '')
							$senderid      = 'SMSCountry'; //Your senderid
						else
							$senderid      = $settings_general['txt_seinder_id']; //Your senderid
						$messagetype   = "N"; //Type Of Your Message
						$messagetype   = "N"; //Type Of Your Message
						$DReports      = "Y"; //Delivery Reports
						$url           = "http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
						$message       = urlencode($message);
						$ch            = curl_init();
						
						if (!$ch) {
							die("Couldn't initialize a cURL handle");
						}
						
						$ret = curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
						curl_setopt($ch, CURLOPT_POSTFIELDS, "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$sel_lang&DR=$DReports");//mtype=$messagetype
						$ret          = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
						// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
						$curlresponse = curl_exec($ch); // execute
						if (curl_errno($ch))
							echo 'curl error : ' . curl_error($ch);
						if (empty($ret)) {
							// some kind of an error happened
							die(curl_error($ch));
							curl_close($ch); // close cURL handler
							return 'ERROR:Something is worng.';
						} else {
							$info = curl_getinfo($ch);
							curl_close($ch); // close cURL handler
							//echo "";
							//echo $curlresponse; //echo "Message Sent Succesfully" ;
							$reponse = explode(":",$curlresponse);
							$reponse = explode(":",$curlresponse);
							if($reponse[0] == 'OK')
							{
								return 'SUCCESS:'.$reponse[1]; //echo "Message Sent Succesfully" ;
							}
							else
							{
								//Error in the sending sms
								return 'ERROR:'.$curlresponse;
							}
						}
					 }
			    }


				
				//function for all the styles
				public function register_all_SMSCountry_styles()
				 {
					 if($_REQUEST['checkemail']=="registered")
					 {
						/*wp_register_script('otp_pup_js', plugins_url(dirname( plugin_basename( __FILE__ ) ) ). '/js/jquery-1.11.3.js');*/
						//wp_register_script('register-popup-script', plugins_url(dirname( plugin_basename( __FILE__ ) ) ). '/js/register-popup-script.js', array('jquery') ); 
						wp_enqueue_script('otp_pup_js'); 
				     }

					/** Get the extension */

					$ext = ( apply_filters( 'woocommerce_SMSCountry_debug_styles', __return_false() ) === true ) ? '.min.css' : '.css';
					/** Register styles */

					wp_register_style( 'smscountry-admin', plugins_url( dirname( plugin_basename( self::get_file() ) ) . DIRECTORY_SEPARATOR .'css'. DIRECTORY_SEPARATOR .'SMSCountryStyles'. $ext ), false, self::$version ); 
					wp_register_script( 'register-popup-script', plugins_url( '/js/register-popup-script.js', __FILE__ ) );
					wp_register_style( 'register-popup-style', plugins_url( '/css/register-popup-style.css' , __FILE__ ) ); 
					wp_enqueue_style('register-popup-style');
					//wp_enqueue_script('register-popup-script');  
				}

				/**
				 * Loads admin stylesheets
				 */
				public function enqueue_SMSCountry_admin_styles( $hook ) 
				{
					/** Load styles */
					wp_enqueue_style( 'smscountry-admin' );

					do_action( 'woocommerce_SMSCountry_enqueue_SMSCountry_admin_styles' );

				}

		 		/**
				 * Adds the admin menus
				 */
                public function add_menus()
				{
				    add_submenu_page( 'woocommerce', 'SMSCountry', 'SMSCountry', 'manage_options', 'woocommerce-cb-import', array( $this, 'woocommerce_cb_submenu_page_callback' ) );	
				}

				function woocommerce_cb_submenu_page_callback() 
				{

					global $wpdb;
					/** Load the edit view template */
					 require dirname( self::get_file() ) . DIRECTORY_SEPARATOR .'templates'. DIRECTORY_SEPARATOR .'SMSCountry_options_section.php';

				}

				

				/**
				 * Script to produce the Settings TABS.
				 */
				function cb_admin_tabs( $current = 'qbGenSettings_tab' , $tabs) 
				{
					$error_count 	= get_option( 'WC_SMSCountry_sync_log', array() );
					$output  		= '';//'<div id="icon-themes" class="icon32"><br></div>';
					$output 		.= '<h2 class="nav-tab-wrapper">';
					foreach( $tabs as $tab => $name )
					{
						$class = ( $tab == $current ) ? ' nav-tab-active' : '';
						$style = '';
						if($tab == 'cb_sync_log')
						{
							  $mark    = '';
							  $markCls = '';
							  if ( 0 < count($error_count) ) 
							  {
								  $mark    = '<mark class="error_mark" style="">'.count($error_count).'</mark>';
								  $markCls = ' markClass';
							  }
							 $output 	.= "<a class='nav-tab$class$markCls' href='?page=woocommerce-cb-import&tab=$tab'>$name$mark</a>";
						}
						else
						$output 		.= "<a class='nav-tab$class' href='?page=woocommerce-cb-import&tab=$tab' ".$style.">$name</a>";

					}

					$output 			.= '</h2>';
					return $output;

				}

				/**
				 * Does security nonce checks
				 */
				public function security_check( $action, $page )
				{
					//if ( check_admin_referer( "woocommerce_SMSCountry-{$action}_{$page}", "woocommerce_SMSCountry-{$action}_{$page}" ) )
					return true;
					//return false;
			 	}



				/**
				 * Does validation
				 */
				public function validate( $values )
				 {
					/** Object flag */
					$is_object = ( is_object( $values ) ) ? true : false;
					/** Convert objects to arrays */
					if ( $is_object )
						$values = (array) $values;

					/** Get settings and do some validation */

					foreach ( $values as $key => $value ) 
					{	
					/** Validators */

						if ( is_numeric( $value ) )
							$values[ $key ] = filter_var( $value, FILTER_VALIDATE_INT );
						elseif ( $value === 'true' || $value === 'false' )
							$values[ $key ] = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
						/** Recurse if necessary */
						if ( is_object( $value ) || is_array( $value ) )
							$values[ $key ] = self::get_instance()->validate( $value );
					}

					/** Convert back to an object */

					if ( $is_object )
						$values = (object) $values;
					return stripslashes_deep( $values );

				}

				/**
				 * Save the SMSCountry General Settings
				 */

				 public function do_gensettings_actions( $page,$post )
				 {  
					global $blog_id;
					$_POST = $post;

				   /** Save the settings */
				   if ( isset( $_POST['save'] ) )
				   {

						/** Security check */
						if ( !self::get_instance()->security_check( 'save', $page ) ) 
						{
							wp_die( __( 'Security check has failed. Save has been prevented. Please try again.', 'woocommerce_SMSCountry' ) );
							exit();
						}

						/** Get settings and do some validation */

						$settings = self::get_instance()->validate( $_POST['settings_general'] );
						/** Update database option and get response */
						update_option( 'woocommerce_SMSCountry_settings_general', stripslashes_deep( $settings ) );

						/** Show update message */
						return self::get_instance()->queue_message( __( 'Settings have been <strong>saved</strong> successfully.', 'woocommerce_SMSCountry' ), 'updated' );
					} 
				}

				

				/**
				 * Save the User template setting Settings
				 */

				 public function do_usertemplate_actions( $page,$post,$key)	
				  {  
					global $blog_id;
					$_POST = $post;

				   /** Save the settings */
				   if ( isset( $_POST['save'] ) )
				   {
					   /** Security check */
					   if ( !self::get_instance()->security_check( 'save', $page ) ) 
					   {
						   wp_die( __( 'Security check has failed. Save has been prevented. Please try again.', 'woocommerce_SMSCountry' ) );
							exit();

						}
						if($key=="sign_Up")
						{
							/** Get settings and do some validation */
							$settings = self::get_instance()->validate( $_POST['setting_user'] );
							/** Update database option and get response */
							update_option( 'woocommerce_user_template_sign_up', stripslashes_deep( $settings ) );
					    }
						if($key=="verification")
						{
							$settings = self::get_instance()->validate($_POST['setting_user'] );
							/** Update database option and get response */
							update_option( 'woocommerce_user_template_verification', stripslashes_deep( $settings ) );
					   }						
						if($key=="verification_existing")
						{
							$settings = self::get_instance()->validate($_POST['setting_user'] );
							/** Update database option and get response */
							update_option( 'woocommerce_user_template_verification_existing', stripslashes_deep( $settings ) );
						}

						if($key=="new_order")
						{
							$settings = self::get_instance()->validate($_POST['setting_user'] );
							/** Update database option and get response */
							update_option( 'woocommerce_user_template_new_order', stripslashes_deep( $settings ) );
						}
						if($key=="return_order")
						{
							$settings = self::get_instance()->validate( $_POST['setting_user'] );
							/** Update database option and get response */
							update_option( 'woocommerce_user_template_return_order', stripslashes_deep( $settings ) );
						}

						if($key=="order_changed")
						{
							$settings = self::get_instance()->validate( $_POST['setting_user'] );
							/** Update database option and get response */
							update_option( 'woocommerce_user_template_order_changed', stripslashes_deep( $settings ) );
						}
                        
						if($key=="checkout")
						{
							$settings = self::get_instance()->validate( $_POST['setting_user'] );
							/** Update database option and get response */
							update_option( 'woocommerce_user_template_checkout', stripslashes_deep( $settings ) );
						}
  
						/** Show update message */
						return self::get_instance()->queue_message( __( 'User template have been <strong>saved</strong> successfully.', 'woocommerce_SMSCountry' ), 'updated' );
					}
				}

				

				/**
				 * Save the Admin template setting Settings
				 */
				 public function do_admintemplate_actions( $page,$post,$key )
				  {  
					global $blog_id;
					$_POST = $post;
				   /** Save the settings */
					if ( isset( $_POST['save'] ) ) 
					{
						/** Security check */
						if ( !self::get_instance()->security_check( 'save', $page ) ) 
						{
							wp_die( __( 'Security check has failed. Save has been prevented. Please try again.', 'woocommerce_SMSCountry' ) );
							exit();
						}
						if($key=="sign_Up")
						{
							/** Get settings and do some validation */
							$settings = self::get_instance()->validate( $_POST['settings_admin'] );
							/** Update database option and get response */
							update_option( 'woocommerce_admin_template_sign_Up', stripslashes_deep( $settings ) );
						}

						if($key=="sign_Up_History")
						{
							$settings = self::get_instance()->validate( $_POST['settings_admin'] );
							/** Update database option and get response */
							update_option( 'woocommerce_admin_template_sign_up_history', stripslashes_deep( $settings ) );
						}

						if($key=="sms_alert")
						{
							$settings = self::get_instance()->validate( $_POST['settings_admin'] );
							/** Update database option and get response */
							update_option( 'woocommerce_admin_template_sms_alert', stripslashes_deep( $settings ) );
						}

						if($key=="return_order")
						{
							$settings = self::get_instance()->validate( $_POST['settings_admin'] );
							/** Update database option and get response */
							update_option( 'woocommerce_admin_template_return_order', stripslashes_deep( $settings ) );
						}
						if($key=="contact_inquiry")
						{
							$settings = self::get_instance()->validate( $_POST['settings_admin'] );
							/** Update database option and get response */
							update_option( 'woocommerce_admin_template_contact_inquiry', stripslashes_deep( $settings ) );
						}
						
			    		/** Show update message */
						return self::get_instance()->queue_message( __( 'Admin template have been <strong>saved</strong> successfully.', 'woocommerce_SMSCountry' ), 'updated' );
					} 
				}

				/**
				 * Getter method for retrieving the class instance.
				 */
				public static function get_instance()
				 {
					if ( !$GLOBALS['WC_SMSCountry'] )
						$GLOBALS['WC_SMSCountry'] = new self;
					return $GLOBALS['WC_SMSCountry'];
				}
				

				/**
				 * Gets the main plugin file
				 */
				public static function get_file()
				{
					return self::$file;
				}

				/**
				 * Add the Sync Log.
				 */ 
				public static function add_sync_log( $log_type = 'Message', $message = '' ) 
				{
					global $blog_id;
					if ( ! $message ) 
					{
						return;
					}

					// Get the sync log
					$sync_log = get_option( 'WC_SMSCountry_sync_log', array() );

			       

				    // Add new message/error to the log

					if(self::$isClearsycLog == 0)
					$sync_log[] = array( 'timestamp' => time(), 'log_type' => $log_type, 'action' => $message );

			

					// Remove the oldest messeges from the log

					if ( 30 < count( $sync_log ) )
					{
						array_shift( $sync_log );
					}

			        

					$error_count = get_option( 'WC_SMSCountry_error_count', 0 );
					if ( 'error' == strtolower( $log_type ) )
					{
						$error_count++;
						update_option( 'WC_SMSCountry_error_count', $error_count );
					}

			

					update_option( 'WC_SMSCountry_sync_log', $sync_log );
					self::$isClearsycLog = 0;
					;
				}

			  /**
			   * Queues an admin message to be displayed
			   */

			   public function queue_message( $text, $type )
			   {
				  global $blog_id;
				  $message = "<div class='message $type' id='dv_message'><p>$text</p></div>";
				  //return $message;
				  add_action( 'woocommerce_SMSCountry_admin_messages', create_function( '', 'echo "'. $message .'";' ) );
				  ;
			   } 	 
			}

			// finally instantiate our plugin class and add it to the set of globals
			
			if ( is_multisite() ) { 
				if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
					// Makes sure the plugin is defined before trying to use it
					require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
				}
					
				if (is_plugin_active_for_network('woocommerce/woocommerce.php')) {	 
					// finally instantiate our plugin class and add it to the set of globals
					$GLOBALS['WC_SMSCountry'] = new WC_SMSCountry();
				}
			}
			else {
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					$GLOBALS['WC_SMSCountry'] = new WC_SMSCountry();
				}
			}
	 }
?>
