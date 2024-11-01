<div class="wrap" id="QBSection">  
<div class="main-panel">
    <div id="woocommerce_SMSCountry-welcome-message" class="welcome-panel cblogo"> <a title="SMSCountry Online" href="<?php echo WC_SMSCountry::$SMSCountry_app_setup_url; ?>" target="_blank" class="plbrand mainlogo-link" id="mfa0"> <span class="intuit-logo-image">SMSCountrys Online</span> </a>
      <h1 id="mf24">The Most Comprehensive Range OF 
          SMS Solutions, At Your Fingertips.</h1>
    </div>
    <?php
    $response = '';
	/** Get the TABS */
	$currentTab = @$_GET['tab'] ? trim($_GET['tab']) : 'cbGenSettings_tab';
    $tabNames  = array( 'cbGenSettings_tab' => 'API Settings','user_template'=>'User Template','admin_template' => 'Admin template','sms_history'=>'SMS History');
    $tabs      = WC_SMSCountry::get_instance()->cb_admin_tabs( $currentTab , $tabNames);
	echo $tabs;  
	$pagenow = $_GET['page'] ? trim($_GET['page']) : '';
	$action  = ''; 
	parse_str($_SERVER['REQUEST_URI'], $resReqUri);
	$resReqUri['tab'] = $currentTab;
	$_SERVER['REQUEST_URI'] = urldecode(http_build_query($resReqUri));
	$_SERVER['REQUEST_URI'] = str_replace('admin_php','admin.php',$_SERVER['REQUEST_URI']); 
	$current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
	
	   /****** Used for save general settings ********/
	   if ( isset( $_POST['save'] ) ) {
		   if(isset($_POST['settings-gen-submit'])) {
			   if($_POST['settings-gen-submit'] == 'Y') {
				   WC_SMSCountry::get_instance()->do_gensettings_actions( $_GET['page'],$_POST );
			   }
		  }

	   /****** Used for save user settings********/	   
	   if(isset($_POST['settings-user_template'])) {
		   if($_POST['settings-user_template']) {
			 	WC_SMSCountry::get_instance()->do_usertemplate_actions( $_GET['page'],$_POST,$_POST['settings-user_template']);
		   }
	   }

	  /****** Used for save admin settings********/	  
	    if(isset($_POST['settings-admin_template'])) {	
		   if($_POST['settings-admin_template']) {
				WC_SMSCountry::get_instance()->do_admintemplate_actions( $_GET['page'],$_POST,$_POST['settings-admin_template']);
		   }
	   }
	}



	/** Get the plugin settings */
    $settings_general     = get_option( 'woocommerce_SMSCountry_settings_general' );
	$user_template_sign_up= get_option( 'woocommerce_user_template_sign_up' );
	$user_template_sign_verify= get_option( 'woocommerce_user_template_verification' );
	$user_template_sign_verify_existing= get_option( 'woocommerce_user_template_verification_existing' );
	$user_template_new_order= get_option( 'woocommerce_user_template_new_order' );
	$user_template_order_return= get_option( 'woocommerce_user_template_return_order' );
	$user_template_order_changed= get_option( 'woocommerce_user_template_order_changed' );
	$user_template_checkput= get_option( 'woocommerce_user_template_checkout' );
	
	
	
	$admin_template_sign_up= get_option( 'woocommerce_admin_template_sign_Up');
	$admin_template_sign_up_history= get_option( 'woocommerce_admin_template_sign_up_history');
	$admin_template_sms_alert= get_option( 'woocommerce_admin_template_sms_alert' );
	$admin_template_order_return= get_option( 'woocommerce_admin_template_return_order' );
	$admin_template_contact_inquiry= get_option( 'woocommerce_admin_template_contact_inquiry' );
	
	$settings_admin=get_option( 'woocommerce_user_template_setting' );
	
	//====Static Feild for display message format=======//
	 $site_title    				 = 	$settings_general['txt_site_title'];
	 $domain    					 = 	$_SERVER['HTTP_HOST'];
	 $customer_firstname			 =	"Sachin";
	 $customer_lastname				 =	"More";
	 $verification_code				 =  1234;
	 $verification_code_existing	 =  1234;	
	 $product_count					 =	2;
	 $order_total					 =	2000;
	 $order_id					     =	12344544;
	 $address						 =	"At mumbai naka,nasik";
	 $postcode						 =	424206;
	 $city							 =	"nasik";
	 $country					     =	"India";
	 $order_status					 =	"Order Complete";	
	 $prod_name 					 =	"Samsung TV";
	 $return_resion					 =	"Financial";
	 $today							 =	date("Y-m-d H:i:s");
	 $status						 =	"return";
	 $old_staus						 =	"Processing";
	 $customer_email				 =  "mapwebtech@gmail.com";
	 $customer_message				 = 	"Hi This is test message for contact enquiry";
	?>
    <div class="messages-container">
      <?php do_action( 'woocommerce_SMSCountry_admin_messages' ); ?>
    </div>
      <?php
		wp_nonce_field( "vendor-supplier-page" ); 
		/** Security nonce fields */
		wp_nonce_field('update-options');
		wp_nonce_field( "woocommerce_SMSCountry-save_{$_GET['page']}", "woocommerce_SMSCountry-save_{$_GET['page']}", false );

if ( $pagenow == 'woocommerce-cb-import' ){
   switch ( $currentTab ){
      case 'cbGenSettings_tab' :
	  ?>  
     <!--======General Setting Section=======----->
       <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('genral_setting_div')">
       <input type="hidden" name="settings_general[send_sms_email]" value="" />
          <div class="wrap">
            <h2>
              <?php _e( 'General Settings', 'woocommerce_SMSCountry' ); ?>
            </h2>
            <div style="border:1px solid black;background-color:white;border-radius:5px 5px;" class="genral_setting_div">
                 <table class="form-table" border="0" id="api_settings_tbl">

                      <tr>
                            <td align="left" scope="row" width="20%"><label style="margin-left:20px;">AuthKey</label></td>
                            <td align="left" scope="row"><p alt="AuthKey Registered On www.smscountry.com" class="tooltip"> <input type="text" name="settings_general[txt_username]" id="general_username" value="<?php echo @$settings_general['txt_username'];?>" size="55"/><span style="color:red" id="AuthKey"></span></p>
                              <p class="description">
                                <?php _e( 'Enter AuthKey.', 'woocommerce_SMSCountry' ); ?>
                              </p></td>
                      </tr>
                      <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">AuthToken</label></td>
                            <td align="left" scope="row"><p alt="AuthToken for the above AuthKey registered on www.smscountry.com" class="tooltip"> <input type="password" name="settings_general[txt_password]" id="txt_password" value="<?php echo @$settings_general['txt_password'];?>" size="55" /><span style="color:red" id="AuthToken"></span></p>
                              <p class="description">
                                <?php _e( 'Enter AuthToken.', 'woocommerce_SMSCountry' ); ?>
                              </p>
                            </td>
                      </tr>
                      <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Sender Id</label></td>
                            <td align="left" scope="row"><p alt="Sender id should be required" class="tooltip"> <input type="text" name="settings_general[txt_seinder_id]" id="txt_sender_id" value="<?php echo @$settings_general['txt_seinder_id'];?>" size="55" /><span style="color:red" id="Id"></span></p>
                              <p class="description">
                                <?php _e( 'Enter ID.', 'woocommerce_SMSCountry' ); ?>
                              </p>
                            </td>
                      </tr>
                      <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Site Title</label></td>
                            <td align="left" scope="row"><p alt="Site title should  be required" class="tooltip"> <input type="text" name="settings_general[txt_site_title]" id="txt_site_title" value="<?php if($settings_general['txt_site_title']!=''){ echo $settings_general['txt_site_title'];}else{echo get_bloginfo( 'name' );}?>" size="55" /><span style="color:red" id="Title"></span></p>
                              <span style="color:red" id="Site Title"></span><p class="description">
                                <?php _e( 'Site Title.', 'woocommerce_SMSCountry' ); ?>
                              </p>
                            </td>
                      </tr>
                      <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Admin Email Notification</label></td>
                            <td align="left" scope="row"><p alt="Admin Email For Notification" class="tooltip"><input type="text" name="settings_general[txt_admin_Email]" id="admin_email" value="<?php echo @$settings_general['txt_admin_Email'];?>" size="55" />
                              <span style="color:red" id="Email"></span> <p class="description">
                                <?php _e( 'Admin Email', 'woocommerce_SMSCountry' ); ?>
                              </p>
                            </td>
                      </tr>
                      <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Admin Mobile</label></td>
                            <td align="left" scope="row"><p alt="Admin Contact" class="tooltip"> <input type="text" name="settings_general[txt_admin_mob_number]" id="txt_admin_mob_number" value="<?php echo $settings_general['txt_admin_mob_number'];?>" size="55" class="api_setting_mob"/><span style="color:red" id="Mobile"></span></p>
                              <p class="description">
                                <?php _e( 'Enter Mobile Number With Country Code.', 'woocommerce_SMSCountry' ); ?>
                              </p>
                            </td>
                      </tr>
                       <?php /*?><tr>
                      <?php
					 if(isset($settings_general['send_sms_email'])=='active')
					 {
						$checked_new1='checked="checked"'; 
					 }
					 else
					 {
						 $checked_new1="";
					 }
					  ?>

                      <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Enable Test Email </label></td>
                      <td align="left" scope="row"><input type="checkbox" name="settings_general[send_sms_email]" value="1" size="55"  <?php echo  $checked_new1;?> class="check_css"/>
                       <p class="description">
                      	<?php _e( 'Checked It To Send Email/Unchecked It To Send SMS', 'woocommerce_SMSCountry' ); ?>
                      </p></td>
                    </tr><?php */?>                    
					 <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Delivery Report URL</label></td>
                            <td align="left" scope="row"><input type="text" name="" id="delivery_report" value="<?php echo site_url();//echo admin_url('admin-ajax.php').'?action=SMSCountyCallBack';?>" size="55" readonly="readonly"/><input type="button" id="target-to-copy" data-clipboard-target="clipboard-text" onclick="copyToClipboard('#delivery_report')" value="Copy URL" class="button-primary api_setting_btn">
                              <p class="description">
                                <?php _e( 'Please share this URL with SMSCountry. To activate Delivery report logs..', 'woocommerce_SMSCountry' ); ?>
                              </p>
                            </td>
                      </tr>
                        <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Language</label></td>
                            <td align="left" scope="row">
                            <select name="settings_general[sel_lang]">
                            <option value="N" <?php if($settings_general['sel_lang']=='N'){echo 'selected="selected"';}?>>English</option>
                            <option value="LNG" <?php if($settings_general['sel_lang']=='LNG'){echo 'selected="selected"';}?>>Other Language</option>
                            </select>
                            <p class="description">
                                <?php _e( 'Language', 'woocommerce_SMSCountry' ); ?>
                              </p>
                            </td>
                      </tr>
                  </table>
                <p class="submit" style="clear: both;">
                      <input type="submit" name="save" id="save" class="button-primary api_setting_btn" value="Save Settings" style="margin-left:20px;" />
                      <input type="hidden" name="settings-gen-submit" value="Y" />
                </p>
            </div>
          </div>
      </form>
  <!----------------User template Section------------------>
      <?php
	  break;
	  case 'user_template' : 
	  ?>
       	<div class="wrap">
	     <h2>
          <?php _e( 'User Template', 'woocommerce_SMSCountry' ); ?>
         </h2>
        <?php 
		    //**************code for sticky btn/div**********//
		    $div1_css="";
			$btn_user_sign_up_css="blue";
			
			
			//=========code for second table======//
			if(isset($_POST['display_div2'])=='tbl_2')
			 {
				$div2_css="";
				$btn_user_sign_up_verify_css="blue";
				$div1_css="style='display:none;'";
				$btn_user_sign_up_css="";
			 }
			 else
			 {
				$div2_css="style='display:none;'";
				$btn_user_sign_up_verify_css="";
			 }

			 //=========code for sing_up verify for existing users======//
			if(isset($_POST['display_div_sign_up_exists'])=='tbl_sing_up_existing')
		    {
				$div_sing_up_exist_css="";
				$btn_sing_up_exists_css="blue";
				$div1_css="style='display:none;'";
				$btn_user_sign_up_css="";
			}
		
			else
			{
				$div_sing_up_exist_css="style='display:none;'";
				$btn_sing_up_exists_css="";
			}
			//=========code for third table======//
			if(isset($_POST['display_div3'])=='tbl_3')
			 {
				$div3_css="";
				$btn_user_return_order_css="blue";
				$div1_css="style='display:none;'";
				$btn_user_sign_up_css="";
			 }
			 else
			 {
				$div3_css="style='display:none;'";
				$btn_user_return_order_css="";
			 }

			 //=========code for fourth table======//
			if(isset($_POST['display_div4'])=='tbl_4')
			 {
				$div4_css="";
				$btn_user_order_status_changed_css="blue";
				$div1_css="style='display:none;'";
				$btn_user_sign_up_css="";
			 }
			 else
			 {
				$div4_css="style='display:none;'";
				$btn_user_order_status_changed_css="";
			}
			 //=========code for third table======//
			if(isset($_POST['display_div5'])=='tbl_5')
			 {
				$div5_css="";
				$btn5_css="blue";
				$div1_css="style='display:none;'";
				$btn_user_sign_up_css="";
			 }
			 else
			 {
				$div5_css="style='display:none;'";
				$btn5_css="";
			 }
			 
			 //=========code for checout======//
			if(isset($_POST['display_user_div_checout'])=='user_tbl_checout')
			 {
				$div_checkout_css="";
				$btn_checkout_css="blue";
				$div1_css="style='display:none;'";
				$btn_user_sign_up_css="";
			 }
			 else
			 {
				$div_checkout_css="style='display:none;'";
				$btn_checkout_css="";
			 }
			 
			
		?>
        <div style="border:1px solid black;background-color:white;border-radius:5px 5px;">
           <div id="div_user">
                <ul id="tabs_li">
                <li ><input type="button" id="btn_user_sign_up" class="button-primary <?php echo $btn_user_sign_up_css;?>"  value="1. Sign Up"/>
			        </li>
                    <li><input type="button" id="btn_user_sign_up_verify" class="button-primary <?php echo $btn_user_sign_up_verify_css;?>"  value="2. Sign Up Verification"/>
                    </li>
                    <li><input type="button" id="btn_user_sign_up_verify_existing" class="button-primary <?php echo $btn_sing_up_exists_css;?>"  value="3. Sign Up Verify[Existing]"/>
                    </li>
                     <li ><input type="button" id="btn_user_new_order" class="button-primary <?php echo $btn_user_return_order_css;?>"  value="4. New Order Placed"/></li>
                    <li ><input type="button" id="btn_user_return_order" class="button-primary <?php echo $btn_user_order_status_changed_css;?>"  value="5. Return Order"/>
                    </li>
                    <li ><input type="button" id="btn_user_order_status_changed" class="button-primary <?php echo $btn5_css;?>" value="6. Order Status Changed"/></li>
                     <li ><input type="button" id="btn_user_checkout" class="button-primary <?php echo $btn_checkout_css;?>" value="7. Checkout"/>
                    </li>
                </ul>

           </div>

            <!-----User Sign Up Table------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div')">
           <div class="table_div" <?php echo $div1_css;?>>
 	       <?php 
		   	if(isset($user_template_sign_up['chk_user_sign_up'])=='active')
			 {
				$checked='checked="checked"'; 
			 }
			 else
			 {
				 $checked="";
			 }
			?>	
		       <h3 class="page_heading">SMS to be sent when the new customer gets registered on the website.</h3>
		       <table class="form-table" border="0" id="api_settings_tbl">
               		 <tr>
                            <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                            <td align="left" scope="row"><input type="checkbox" name="setting_user[chk_user_sign_up]" value="" size="55" <?php echo $checked;?> class="check_css"/>
                              <p class="description">
                                <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                              </p></td>
                     </tr>
                     <tr>
                      		<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Message Format<span class="star">*</span></label> 
                      </td>
                      		<td align="left" scope="row"><textarea id="txt_area1" name="setting_user[txt_area1]" class="text_area" ><?php echo $user_template_sign_up['txt_area1'];?></textarea><span id="txterror" style="color:red;"></span>
                        	 <p class="description">
							  <?php _e( 'Enter Message Format.', 'woocommerce_SMSCountry' ); ?>
                            </p></td>
                     </tr>
                     <tr>
                            <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Placeholder<span class="star">*</span></label></td> 
                            <td align="left" scope="row">
                                <ol class="user_first_ol" style="position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;" id="Placeholder_ol">
                                    <li>[shop_name]</li> 
                                    <li>[shop_domain]</li>
                                    <li>[customer_firstname]</li>
                                    <li>[customer_lastname]</li>
                                </ol>
                                
                                <p class="description">
                                <?php _e('Select placeholder.', 'woocommerce_SMSCountry' ); ?>
                                </p>
                            </td>
                      </tr>
                      <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                            <td align="left" scope="row">
                             <?php
							 //====static text format for preview sms=====//
							 $sign_up_message_format		 =	$user_template_sign_up['txt_area1'];
							 $search_user_sign_up  		  	 = 	array("[shop_name]", "[shop_domain]","[customer_firstname]","[customer_lastname]");
				   			 $replace_user_sign_up   	     =	array($site_title,$domain,$customer_firstname,$customer_lastname);   
				  			 $preview_message_user_sign_up   = 	str_replace($search_user_sign_up,$replace_user_sign_up,$sign_up_message_format);
							 ?>
                             <input type="text" name="setting_user[txt_contact]" id="txt_contact" class="sms_text" value="" size="55"/>
                             <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;
        height: 37px;"   onclick="get_popup('element_to_pop_up1');"/>  <input type="button" name="sign_up_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('txt_contact','<?php echo $preview_message_user_sign_up;?>')"/>
                              <p class="description">
                                <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                              </p>

      					   <!-- Element to pop up -->
                             <div id="element_to_pop_up" class="element_to_pop_up1">
                               <a class="b-close" style="font-size: 20px;">X<a/>
                               <h3>Message Preview</h3>
                               <textarea  style="height: 200px;width: 100%;"><?php echo $preview_message_user_sign_up;?></textarea><span id="txterror" style="color:red;"></span>
                             </div>
                              </td>
                      </tr>
                      <tr>
                            <td>
                            </td>
                            <td>
                            <p class="submit" style="clear: both;">
                            <input type="submit" name="save" id="save" class="button-primary" value="Save Settings"/>
                            <input type="hidden" name="settings-user_template" value="sign_Up" />
                            </p>
                            </td>
						  </tr>
                </table>
            </div>
            </form>
            
            <!-----User Sign Up verification Table------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div2')">
           <div class="table_div2" <?php echo $div2_css;?>>
                  <?php 
		   			if(isset($user_template_sign_verify['chk_user_sign_up_verify'])=='active')
					 {
						$checked2='checked="checked"'; 
					 }
					 else
					 {
						 $checked2="";
					 }
				?>	
                 <h3 class="page_heading">SMS with RANDOM code sent to the user to verify his mobile number.</h3>
                 <table class='form-table' border='0' id='api_settings_tbl'>
                     <tr>
                    	<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                        <td align="left" scope="row"><input type="checkbox" name="setting_user[chk_user_sign_up_verify]" value="" size="55" <?php echo $checked2;?> class="check_css"/>
                          <p class="description">
                            <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                     </tr>
                     <tr>
                         <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label> </td>
                         <td align='left' scope='row'><textarea id='txt_area2' name='setting_user[txt_area]' class='text_area'><?php echo $user_template_sign_verify['txt_area'] ?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p></td>
                     </tr>
                     <tr>
                     	 <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                         <td align='left' scope='row'>
                         <ol class='user_second_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                             <li>[shop_name]</li>
                             <li>[shop_domain]</li>
                             <li>[verification_code]</li>
                         </ol>
                         <p class='description'><span>Select placeholder</span></p></td>
                     </tr>
                     <tr>
                          <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                          <td align="left" scope="row">
                          <?php
							 //====static text format for preview sms=====//
							 $sign_up_verify_message_format		    =$user_template_sign_verify['txt_area'];
							 $search_user_sign_up_verify  		  	= array("[shop_name]", "[shop_domain]","[verification_code]");
				   			 $replace_user_sign_up_verify   	    = array($site_title,$domain,$verification_code);   
				  			 $preview_message_user_sign_up_verify   = str_replace($search_user_sign_up_verify,$replace_user_sign_up_verify,$sign_up_verify_message_format);
							
							?>
                          <input type="text" name="setting_user[txt_contact2]" id="txt_contact2" class="sms_text" value="" size="55"/>
                          <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;height: 37px;" onclick="get_popup('element_to_pop_up2')"/> 
    					  <input type="button" name="sign_up_verification_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('txt_contact2','<?php echo $preview_message_user_sign_up_verify;?>')"/>
                          <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p>
                          <div id="element_to_pop_up" class="element_to_pop_up2">
                              <a class="b-close" style="font-size: 20px;">X<a/>
                              <h3>Message Preview</h3>
                              <textarea  style="height: 200px;width: 100%;"><?php echo $preview_message_user_sign_up_verify;?></textarea><span id="txterror" style="color:red;"></span>
                      	  </div>
                          </td>
                     </tr>
                     <tr>
                         <td></td>
                         <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings'/><input type='hidden' name='settings-user_template' value='verification' /><input type="hidden" name="display_div2" value="tbl_2" /></p>
                         </td>
                     </tr>
                 </table>
           </div>
           </form>
           
           <!-----User Sign Up verification for Existing users------->
             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div_sign_up_existing')">
           <div class="table_div_sign_up_existing" <?php echo $div_sing_up_exist_css;?>?>
                   <?php 
		   			if(isset($user_template_sign_verify_existing['chk_user_sign_up_verify_exists'])=='active')
					 {
						$checked_existing_sing_up_users='checked="checked"'; 
					 }
					 else
					 {
						 $checked_existing_sing_up_users="";
					 }
				 ?>	

                 <h3 class="page_heading">SMS with RANDOM code sent to the Existing user to verify his mobile number.</h3>
                 <table class='form-table' border='0' id='api_settings_tbl'>
                     <tr>
                    	<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                        <td align="left" scope="row"><input type="checkbox" name="setting_user[chk_user_sign_up_verify_exists]" value="" size="55" class="check_css" <?php echo $checked_existing_sing_up_users;?>/>
                          <p class="description">
                            <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                     </tr>
                     <tr>
                         <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label> </td>
                         <td align='left' scope='row'><textarea id='txt_area_sing_up_exists' name='setting_user[txt_area_sing_up_exists]' class='text_area'><?php echo $user_template_sign_verify_existing['txt_area_sing_up_exists'] ?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p></td>
                     </tr>
                     <tr>
                     	<td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                         <td align='left' scope='row'>
                         <ol class='user_sing_up_exists_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                             <li>[shop_name]</li>
                             <li>[shop_domain]</li>
                             <li>[verification_code]</li>
                         </ol>
                         <p class='description'><span>Select placeholder</span></p></td>
                     </tr>
                     <tr>
                          <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                          <td align="left" scope="row">
                          
                           <?php
							 //====static text format for preview sms=====//
							 $sign_up_verify_existing_message_format	    =	$user_template_sign_verify_existing['txt_area_sing_up_exists'];
							 $search_user_sign_up_verify_existing  		  	= 	array("[shop_name]", "[shop_domain]","[verification_code]");
				   			 $replace_user_sign_up_verify_existing   	    = 	array($site_title,$domain,$verification_code_existing);   
				  			 $preview_message_user_sign_up_verify_existing  =	 str_replace($search_user_sign_up_verify_existing,$replace_user_sign_up_verify_existing,$sign_up_verify_existing_message_format);
							
							?>
                          <input type="text" name="setting_user[txt_contact_sing_up_verify_existing]" id="txt_contact_sing_up_verify_existing" class="sms_text" value="" size="55"/>
                          <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up_sing_up')"/> 
    					  <input type="button" name="sign_up_verification_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('txt_contact_sing_up_verify_existing','<?php echo $preview_message_user_sign_up_verify_existing; ?>')"/>
                          <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p>
                          <div id="element_to_pop_up" class="element_to_pop_up_sing_up">
                              <a class="b-close" style="font-size: 20px;">X<a/>
                              <h3>Message Preview</h3>
                              <textarea  style="height: 200px;width: 100%;"><?php echo $preview_message_user_sign_up_verify_existing; ?></textarea><span id="txterror" style="color:red;"></span>
                      	  </div>
                          </td>
                     </tr>
                     <tr>
                         <td></td>
                         <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings'/><input type='hidden' name='settings-user_template' value='verification_existing' /><input type="hidden" name="display_div_sign_up_exists" value="tbl_sing_up_existing" /></p>
                         </td>
                     </tr>
                 </table>
           </div>
           </form>
           
           <!------User New Order table------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div_new_order')">
           <div class="table_div_new_order" <?php echo $div3_css;?>>
               <h3 class="page_heading">Confirmation SMS to be sent to the customer after placing the order.</h3>
                 <?php 
					if(isset($user_template_new_order['chk_user_new_order'])=='active')
					 {
						$checked_new='checked="checked"'; 
					 }
					 else
					 {
						 $checked_new="";
					 }
				?>
                 <table class='form-table' border='0' id='api_settings_tbl'>
					  <tr>
                    	<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                        <td align="left" scope="row"><input type="checkbox" name="setting_user[chk_user_new_order]" value="" size="55" <?php echo  $checked_new;?> class="check_css"/>
                          <p class="description">
                            <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                     </tr>
                     <tr>
                             <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                             <td align='left' scope='row'><textarea id='txt_area_new_order' name='setting_user[txt_area_new_order]' class='text_area'><?php echo $user_template_new_order['txt_area_new_order'];?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p>
                             </td>
                     </tr>
                     <tr>
                             <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                             <td align='left' scope='row'>
                             <ol class='user_new_order_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                                 <li>[shop_name]</li>
                                 <li>[shop_domain]</li>
                                 <li>[customer_firstname]</li>
                                 <li>[customer_lastname]</li>
                                 <li>[customer_address]</li>
                                 <li>[customer_postcode]</li>
                                 <li>[customer_city]</li>
                                 <li>[customer_country]</li>
                                 <li>[order_id]</li>
                                 <li>[order_total]</li>
                                 <li>[order_products_count]</li>
                                 <li>[order_status]</li>
                             </ol>
                             <p class='description'><span>Select placeholder</span></p>
                             </td>
                     </tr>
                     <tr>
                     	<td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span</label> </td>
                        <td align="left" scope="row">
                           <?php
							 //====static text format for preview sms=====//
							 $user_new_order_message_format	    =	$user_template_new_order['txt_area_new_order'];
							 $search_user_new_order 		  	=	array("[order_products_count]","[order_total]","[order_id]","[customer_firstname]", "[customer_lastname]","[customer_address]","[customer_postcode]","[customer_city]","[customer_country]","[shop_name]","[shop_domain]","[order_status]");
				   			 $replace_user_new_order   	        = 	array($product_count,$order_total,$order_id,$customer_firstname,$customer_lastname,$address,$postcode,$city,$country,$site_title,$domain,$order_status); 
				  			 $preview_message_user_new_order = str_replace($search_user_new_order,$replace_user_new_order,$user_new_order_message_format);
							
							?>
                          <input type="text" name="setting_user[txt_contact_new_order]" id="txt_contact_new_order" class="sms_text" value="" size="55"/>
                          <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;height: 37px;" onclick="get_popup('element_to_pop_up10')"/>  
    					  <input type="button" name="order_return_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('txt_contact_new_order','<?php echo $preview_message_user_new_order;?>')"/>
                          <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p>
                          <div id="element_to_pop_up" class="element_to_pop_up10">
                             <a class="b-close" style="font-size: 20px;">X<a/>
                             <h3>Message Preview</h3>
                            <textarea  style="height: 200px;width: 100%;"><?php echo $preview_message_user_new_order;?></textarea><span id="txterror" style="color:red;"></span>
                         </div>
                          </td>
                     </tr>
                     <tr>
                             <td></td>
                             <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings'/><input type='hidden' name='settings-user_template' value='new_order'/><input type="hidden" name="display_div3" value="tbl_3" /></p></td>
                     </tr>
              </table>
           </div>
          </form>

           <!------User Order return table------->     
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div3')">
           <div class="table_div3" <?php echo $div4_css;?>>
           		<?php 
					if(isset($user_template_order_return['chk_user_order_return'])=='active')
					 {
						$checked3='checked="checked"'; 
					 }
					 else
					 {
						 $checked3="";
					 }
               	?>	
                <h3 class="page_heading">Confirmation SMS to be sent to the customer after return order.</h3>
                <table class='form-table' border='0' id='api_settings_tbl'>
                      <tr>
                            <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>		
                            <td align="left" scope="row"><input type="checkbox" name="setting_user[chk_user_order_return]" value="" size="55" <?php echo $checked3;?> class="check_css"/>
                              <p class="description">
                                <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                              </p></td>
                      </tr>
                      <tr>
                             <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                             <td align='left' scope='row'><textarea id='txt_area3' name='setting_user[txt_area3]' class='text_area'><?php echo $user_template_order_return['txt_area3'] ?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p>
                             </td>
                      </tr>
                      <tr>
                             <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                             <td align='left' scope='row'>
                             <ol class='user_third_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                                  <li>[shop_name]</li>
                                 <li>[shop_domain]</li>
                                 <li>[customer_firstname]</li>
                                 <li>[customer_lastname]</li>
                                 <li>[customer_address]</li>
                                 <li>[customer_postcode] </li>
                                 <li>[customer_city]</li>
                                 <li>[customer_country]</li>
                                 <li>[order_id]</li>
                                 <li>[order_total]</li>
                                 <li>[order_status]</li>
                                 <li>[return_product_name]</li>
                                 <li>[return_reason]</li>
                             </ol>
                             <p class='description'><span>Select placeholder</span></p>
                             </td>
                       </tr>
                       <tr>
                            <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                            <td align="left" scope="row">
                             <?php
							 //====static text format for preview sms=====//
							 $user_order_return_message_format			=	$user_template_order_return['txt_area3'];
							 $search_user_order_return    				=	array("[order_products_count]","[order_total]","[order_id]","[customer_firstname]", "[customer_lastname]","[customer_address]","[customer_postcode]","[customer_city]","[customer_country]","[shop_name]","[shop_domain]","[return_product_name]","[return_reason]","[order_status]","[order_date]");
							 $replace_user_order_return    				=	array($product_count,$order_total,$order_id,$customer_firstname,$customer_lastname,$address,$postcode,$city,$country,$site_title,$domain,$prod_name,$return_resion,$status,$today);  
							 $preview_message_user_order_return			= 	str_replace($search_user_order_return,$replace_user_order_return,$user_order_return_message_format);
							
							?>
                              <input type="text" name="setting_user[txt_contact3]" id="txt_contact3" class="sms_text" value="" size="55"/>
                              <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;height: 37px;" onclick="get_popup('element_to_pop_up3')"/>
        					<input type="button" name="order_return_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('txt_contact3','<?php echo $preview_message_user_order_return;?>')"/>
                            <p class="description">
                                <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                            </p>
                               <div id="element_to_pop_up" class="element_to_pop_up3">
                                  <a class="b-close" style="font-size: 20px;">X<a/>
                                 <h3>Message Preview</h3>
                                  <textarea  style="height: 200px;width: 100%;"><?php echo $preview_message_user_order_return;?></textarea><span id="txterror" style="color:red;"></span>
                              </div>
                              </td>
                     </tr>
                     <tr>
                             <td></td>
                             <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings'/><input type='hidden' name='settings-user_template' value='return_order' /><input type="hidden" name="display_div4" value="tbl_4" /></p></td>
                     </tr>
               </table>
            </div>
	  </form>
     <!---------------User checkout Order Table------------------>   
		     <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div10')">
                   <div class="table_div10" <?php echo $div_checkout_css;?>>
                   		 <?php
						 if(isset($user_template_checkput['chk_user_checkcut'])=='active')
					 {
						$checked_checout='checked="checked"'; 
					 }
					 else
					 {
						 $checked_checout="";
					 }
						 
						 ?>
                         <h3 class="page_heading">Verification SMS alert  to be send to guest user when place order. </h3>
                         <table class='form-table' border='0' id='api_settings_tbl'>
                             <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="setting_user[chk_user_checkcut]" value="" size="55"  class="check_css" <?php echo $checked_checout;?>/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                             <tr>
                                     <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                                     <td align='left' scope='row'><textarea id='user_txt_checkout' name='setting_user[user_txt_checkout]' class='text_area'><?php echo $user_template_checkput['user_txt_checkout'];?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p></td>
                             </tr>
                             <tr>
                                     <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                                     <td align='left' scope='row'>
                                     <ol class='user_checkout_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                                         <li>[customer_firstname]</li>
                                         <li>[customer_lastname]</li>
                                         <li>[verification]</li>
                                         <li>[shop_name]</li>
                                         <li>[shop_domain]</li>
                                        
                                        
                                     </ol>
                                     <p class='description'><span>Select placeholder</span></p>
                                     </td>
                             </tr>
                             <tr>
                             	<td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                                <td align="left" scope="row">
                                    <?php
									 	 $checkout_user_format						=	$user_template_checkput['user_txt_checkout'];
										 $search_checkout				   			= 	array("[shop_name]","[shop_domain]","[customer_firstname]","[customer_lastname]");
										 $replace_checkout			    			= 	array($site_title,$domain,"rahul","testing");  
										 $preview_checkout_msg 						= 	str_replace($search_checkout,$replace_checkout,$checkout_user_format);
									?>
                                    <input type="text" name="setting_user[checkout_txt_contact3]" id="checkout_txt_contact3" class="sms_text" value="<?php echo $user_template_checkput['checkout_txt_contact3'];?>" size="55"/>
                                     <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up18')"/>  
                                    <input type="button" name="order_changed_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('txt_contact18','<?php  echo $preview_checkout_msg;?>')"/> 
                                     <p class="description">
                                        <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' );
										 ?>
                                     </p>
                                     <div id="element_to_pop_up" class="element_to_pop_up18">
                                         <a class="b-close" style="font-size: 20px;">X<a/>
			                             <h3>Message Preview</h3>
                             			<textarea  style="height: 200px;width: 100%;"><?php echo $preview_checkout_msg;?></textarea><span id="txterror" style="color:red;"></span>
                         			 </div>
                                 </td>
                             </tr>
                             <tr>
                                     <td></td>
                                     <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-user_template' value='checkout' /><input type="hidden" name="display_user_div_checout" value="user_tbl_checout" /></p></td>
                             </tr>
                        </table>	   
                   </div>
             </form> 
		<!------------User table for Order Changed------------------->  
     <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div4')">
           <div class="table_div4" <?php echo $div5_css;?>>
                <?php 
					if(isset($user_template_order_changed['chk_user_order_changed'])=='active')
					 {
						$checked4='checked="checked"'; 
					 }
					 else
					 {
						 $checked4="";
					 }
				?>	
                <h3 class="page_heading">SMS Sent to the customer whenever there is a change in the order status.</h3>
                <table class='form-table' border='0' id='api_settings_tbl'>
                     <tr>
                            <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                            <td align="left" scope="row"><input type="checkbox" name="setting_user[chk_user_order_changed]"value="" size="55" <?php echo $checked4;?> class="check_css"/>
                              <p class="description">
                                <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                              </p></td>
                     </tr>
                     <tr>
                             <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label> </td>
                             <td align='left' scope='row'><textarea id='txt_area4' name='setting_user[txt_area4]' class='text_area'><?php echo $user_template_order_changed['txt_area4'] ?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p>
                             </td>
                     </tr>
                     <tr>
                             <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                             <td align='left' scope='row'>
                             <ol class='user_fourth_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                                 <li>[shop_name]</li>
                                 <li>[shop_domain]</li>
                                 <li>[customer_firstname]</li>
                                 <li>[customer_lastname]</li>
                                 <li>[customer_address]</li>
                                 <li>[customer_postcode]</li>
                                 <li>[customer_city]</li>
                                 <li>[customer_country]</li>
                                 <li>[order_id]</li>
                                 <li>[order_total]</li>
                                 <li>[order_products_count]</li>
                                 <li>[order_old_status]</li>
                                 <li>[order_new_status]</li>
                                 <li>[order_date]</li>
                             </ol>
                             <p class='description'><span>Select placeholder</span></p></td>
                     </tr>
                     <tr>
                             <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                            <td align="left" scope="row">
                             <?php
							 //====static text format for preview sms=====//
							 $user_order_changed_message_format			=	$user_template_order_changed['txt_area4'];
							 $search_user_order_changed     			= 	array("[order_date]","[order_new_status]","[order_old_status]","[order_products_count]","[order_total]","[order_id]","[customer_firstname]", "[customer_lastname]","[customer_address]","[customer_postcode]","[customer_city]","[customer_country]","[shop_name]","[shop_domain]");
							 $replace_user_order_changed    			= 	array($today, $status,$old_staus ,$product_count,$order_total,$order_id,$customer_firstname,$customer_lastname,$address,$postcode,$city,$country,$site_title,$domain);   
						     $preview_message_user_order_cahnged		=	 str_replace($search_user_order_changed,$replace_user_order_changed,$user_order_changed_message_format);
							?>
                            <input type="text" name="setting_user[txt_contact4]" id="txt_contact4" class="sms_text" value="" size="55"/>
                            <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up4')"/>  
    						<input type="button" name="order_changed_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('txt_contact4','<?php  echo $preview_message_user_order_cahnged;?>')"/>
                            <p class="description">
                                <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                              </p>
                               <div id="element_to_pop_up" class="element_to_pop_up4">
                                     <a class="b-close" style="font-size: 20px;">X<a/>
                                     <h3>Message Preview</h3>
                                     <textarea  style="height: 200px;width: 100%;"><?php echo $preview_message_user_order_cahnged;?></textarea><span id="txterror" style="color:red;"></span>
                               </div>
                              </td>
                     </tr>
                     <tr>
                             <td></td>
                             <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-user_template' value='order_changed' /><input type="hidden" name="display_div5" value="tbl_5" /></p></td>
                     </tr>
                </table>
            </div>
           </form>
        </div>
      </div>

   
 <!------------admin template Section=======----->

    <?php
	  break;
	  case 'admin_template' : 
	  ?>
     <div class="wrap">
       <?php
			//**************code for sticky btn/div**********//
		    $admin_div1_css="";
			$admin_btn_user_sign_up_css="blue";
			//=========code for second table======//
			if(isset($_POST['display_admin_div2'])=='admin_tbl_2')
			 {
				$admin_div2_css="";
				$admin_btn_user_sign_up_verify_css="blue";
				$admin_div1_css="style='display:none;'";
				$admin_btn_user_sign_up_css="";
			 }

		    else
			 {
				$admin_div2_css="style='display:none;'";
				$admin_btn_user_sign_up_verify_css="";
			 }
			
			//=========code for third table======//
			if(isset($_POST['display_admin_div3'])=='admin_tbl_3')
			 {
				$admin_div3_css="";
				$admin_btn_user_return_order_css="blue";
				$admin_div1_css="style='display:none;'";
				$admin_btn_user_sign_up_css="";
			 }

			 else
			 {
				$admin_div3_css="style='display:none;'";
				$admin_btn_user_return_order_css="";
			 }

			 //=========code for fourth table======//
			if(isset($_POST['display_admin_div4'])=='admin_tbl_4')
			 {
				$admin_div4_css="";
				$admin_btn_user_order_status_changed_css="blue";
				$admin_div1_css="style='display:none;'";
				$admin_btn_user_sign_up_css="";
			 }
			 else
			 {
				$admin_div4_css="style='display:none;'";
				$admin_btn_user_order_status_changed_css="";
			 }

		?>
        <h2>
          <?php _e( 'Admin Template', 'woocommerce_SMSCountry' ); ?>
        </h2>
        <div style="border:1px solid black;background-color:white;border-radius:5px 5px;">
           <div id="div1">
                <ul id="tabs_li">
                    <li ><input type="button" id="btn_admin_sign_up" class="button-primary <?php echo $admin_btn_user_sign_up_css;?>" value="1. Sign Up"/>
                    </li>
                    <li><input type="button" id="btn_admin_order_sms_alert" class="button-primary <?php echo $admin_btn_user_sign_up_verify_css;?>"  value="2. Order SMS Alert"/></a>
                    </li>
                    <li ><input type="button" id="btn_admin_return_order" class="button-primary <?php echo $admin_btn_user_return_order_css;?>" value="3. Return Order"/>
                    </li>
                    <li ><input type="button" id="btn_admin_contact_inquiry" class="button-primary <?php echo $admin_btn_user_order_status_changed_css;?>" value="4. Contact Inquiry"/>
                    </li>
                  
		    </ul>
           </div>
           <div class="table_div9" <?php echo $admin_div1_css;?>>
                          <h2 class="nav-tab-wrapper">
                              <a class='nav-tab nav-tab-active' href="#" id="tab_admin_sign_up">Sign up</a>
                              <a class='nav-tab nav-tab-active' href="#" id="tab_admin_sign_up_history">No. Of New Registered Customers</a>
                         </h2>
           </div>

              <!---------------Admin Sign Up Table------------------>   
          <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div5')">
                   <div class="table_div5" <?php echo $admin_div1_css;?>>
                       <?php 
						if(isset($admin_template_sign_up['chk_admin_sign_up'])=='active')
						 {
							$checked5='checked="checked"'; 
						 }
						 else
						 {
							$checked5="";
						 }
					?>	
                      <h3 class="page_heading">SMS to be sent to the admin whenever new customers sign up.</h3>
                      <table class="form-table" border="0" id="api_settings_tbl">
                            <tr>
                                 <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label> </td>			
                                 <td align="left" scope="row"><input type="checkbox" name="settings_admin[chk_admin_sign_up]"  value="" size="55" <?php echo $checked5;?> class="check_css"/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                            <tr>
                                  <td align="left" scope="row" width="20%"><label style="margin-left:20px;"> Message Format<span class="star">*</span></label>
                                  </td>
                                  <td align="left" scope="row"><textarea id="admin_txt_area" name="settings_admin[admin_txt_area]" class="text_area"><?php echo $admin_template_sign_up['admin_txt_area'];?></textarea><span id="txterror" style="color:red;"></span><p class="description">
                                      <?php _e( 'Enter Message Format.', 'woocommerce_SMSCountry' ); ?>
                                    </p></td>
                             </tr>
                             <tr>
                                 <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Placeholder<span class="star">*</span></label></td>
                                 <td align="left" scope="row">
                                    <ol class="admin_first_ol" style="position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;" id="Placeholder_ol">
                                                    <li>[shop_name]</li>
                                                    <li>[shop_domain]</li>
                                                    <li>[customer_firstname]</li>
                                                    <li>[customer_lastname]</li>
                                    </ol>
                                    <p class="description">
                                    <?php _e('Select placeholder.', 'woocommerce_SMSCountry' ); ?>
                                    </p>
                                    </td>
                             </tr>
                             <tr>
                                   <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                                   <td align="left" scope="row">
									<?php
                                     //====static text format for preview sms=====//
                                     $admin_sign_up_message_format			=	$admin_template_sign_up['admin_txt_area'];
                                     $search_admin_sign_up    				= 	array("[shop_name]","[shop_domain]","[customer_firstname]","[customer_lastname]");
                                     $replace_admin_sign_up   				=	 array($site_title,$domain,$customer_firstname,$customer_lastname);   
                                     $preview_message_admin_sign_up			= 	str_replace($search_admin_sign_up,$replace_admin_sign_up,$admin_sign_up_message_format);
                                     
                                    ?>
                                     <input type="text" name="settings_admin[admin_txt_contact]" id="admin_txt_contact" class="sms_text" value="" size="55"/>
                                     <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up5')"/>  
                                     <input type="button" name="admin_sign_up" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('admin_txt_contact','<?php  echo  $preview_message_admin_sign_up;?>')"/>
                                     <p class="description">
                                        <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                     </p>
                                     <div id="element_to_pop_up" class="element_to_pop_up5">
                                           <a class="b-close" style="font-size: 20px;">X</a>
                                           <h3>Message Preview</h3>
                                           <textarea  style="height: 200px;width: 100%;"><?php  echo  $preview_message_admin_sign_up;?></textarea><span id="txterror" style="color:red;"></span>
                                     </div>
                                     </td>
                              </tr>
                              <tr>
                                    <td></td>
                                    <td>
                                    <p class="submit" style="clear: both;">
                                    <input type="submit" name="save" id="save" class="button-primary" value="Save Settings"/>
                                    <input type="hidden" name="settings-admin_template" value="sign_Up" />
                                    </p>
                                    </td>
                             </tr>
                        </table>
                     </div>
             </form>

               <!----------Admin sign_up history table----------->
             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_history')">
			      <div class="table_history" style="display:none;">
                       <?php 
						if(isset($admin_template_sign_up_history['chk_admin_sign_up_history'])=='active')
						 {
							$checked6='checked="checked"'; 
						 }


						 else
						 {
							 $checked6="";
						 }
						 
						  /*=====to check daily/weekly/mothly checkbox that are saved in database=====*/
						if(isset($admin_template_sign_up_history['txt_check_daily'])=='active')
						 {
							$checked_daily='checked="checked"'; 
						 }
						 else
						 {
							 $checked_daily="";
						 } 
						 
						 if(isset($admin_template_sign_up_history['txt_check_weekly'])=='active')
						 {
							$checked_weekly='checked="checked"'; 
						 }
						 else
						 {
							 $checked_weekly="";
						 } 
						 
	    				 if(isset($admin_template_sign_up_history['txt_check_monthly'])=='active')
						 {
							$checked_monthly='checked="checked"'; 
						 }
						 else
						 {
							 $checked_monthly="";
						 } 
                  		?>	
                        <h3 class="page_heading">SMS to be sent to the admin whenever new customers sign up.(frequency of the SMS will be daily/weekly/monthly)</h3>
                       <table class="form-table" border="0" id="api_settings_tbl">
                            <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[chk_admin_sign_up_history]" value="" size="55" <?php echo $checked6;?> class="check_css"/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                           </tr>
                           <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Alerts </label></td>			
                                <td align="left" scope="row">
                                 <input type="checkbox" name="settings_admin[txt_check_daily]" value="" size="55" class="check_css" <?php echo $checked_daily;?>/>&nbsp;Daily&nbsp;&nbsp;&nbsp;
                               	 <input type="checkbox" name="settings_admin[txt_check_weekly]" value="" size="55" class="check_css" <?php echo $checked_weekly; ?>/>&nbsp;Weekly&nbsp;&nbsp;&nbsp;
                                 <input type="checkbox" name="settings_admin[txt_check_monthly]" value="" size="55" class="check_css" <?php echo $checked_monthly;?>/>&nbsp;Monthly
                                    <p class="description">
                                    <?php _e( 'Admin Alerts', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                           </tr>
                           <tr>
                                <td align="left" scope="row" width="20%"><label >Set Crons<br/> in Cpanel </label></td>			
                                <td align="left" scope="row">
                             <b><u>For Daily</u> : http://mapwebdev.com/maptest/wooinstall/wp-admin/admin-ajax.php?action=DailySMSCron</b><br/><br/>
                               <b><u>For Weekly</u> : http://mapwebdev.com/maptest/wooinstall/wp-admin/admin-ajax.php?action=WeekllySMSCron</b><br/><br/>
                                 <b><u>For Monthly</u> : http://mapwebdev.com/maptest/wooinstall/wp-admin/admin-ajax.php?action=MonthlySMSCron</b>
                                  </td>
                           </tr>
                           <tr>
                               <td align="left" scope="row" width="20%"><label style="margin-left:20px;"> Message Format<span class="star">*</span></label>
                               </td>
                               <td align="left" scope="row"><textarea id="history_txt_area" name="settings_admin[history_txt_area]" class="text_area"><?php echo $admin_template_sign_up_history['history_txt_area'];?></textarea><span id="txterror" style="color:red;"></span>
                                <p class="description">
                                  <?php _e( 'Enter Message Format.', 'woocommerce_SMSCountry' ); ?>
                               </p></td>
                           </tr>
                           <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Placeholder<span class="star">*</span></label></td>
                                <td align="left" scope="row">
                                    <ol class="admin_first_ol1" style="position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;" id="Placeholder_ol">
                                                    <li>[shop_name]</li>
                                                    <li>[shop_domain]</li>
                                                    <li>[customer_count]</li>
						           </ol>
                                    <p class="description">
                                    <?php _e('Select placeholder.', 'woocommerce_SMSCountry' ); ?>
                                  </p>
                                </td>
                           </tr>
                           <tr>
                                <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                                <td align="left" scope="row">
                             
                               <?php
                                     //====static text format for preview sms=====//
                                     $admin_sign_up_history_message_format			=	$admin_template_sign_up_history['history_txt_area'];
									 $customer_count								=	20;	
                                     $search_admin_sign_up_history    				= 	array("[shop_name]","[shop_domain]","[customer_count]");
                                     $replace_admin_sign_up_history   				= 	array($site_title,$domain,$customer_count);   
                                     $preview_message_admin_sign_up_history			= 	str_replace($search_admin_sign_up_history,$replace_admin_sign_up_history,$admin_sign_up_history_message_format);
                                    
                               ?>
                                <input type="text" name="settings_admin[history_txt_contact]" id="history_txt_contact" class="sms_text" value="" size="55"/>
                                <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up6')"/>   
                                <input type="button" name="admin_sign_up_history" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('history_txt_contact','<?php  echo $preview_message_admin_sign_up_history;?>')"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                </p>
                                <div id="element_to_pop_up" class="element_to_pop_up6">
                                    <a class="b-close" style="font-size:20px;">X<a/>
                                     <h3>Message Preview</h3>
                                     <textarea  style="height: 200px;width: 100%;"><?php  echo $preview_message_admin_sign_up_history;?></textarea><span id="txterror" style="color:red;"></span>
                               </div>
                               </td>
                          </tr>
                          <tr>
                                <td></td>
                                <td>
                                <p class="submit" style="clear: both;">
                                <input type="submit" name="save" id="save" class="button-primary" value="Save Settings" />
                                <input type="hidden" name="settings-admin_template" value="sign_Up_History" />
                                </p>
                                </td>
                          </tr>
                     </table>
                  </div>
             </form> 

               <!---------------Admin Order SMS alert table------------------>

             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div6')">
                   <div class="table_div6" <?php echo $admin_div2_css;?>>
                      <?php 
						if(isset($admin_template_sms_alert['chk_admin_order_sms_alert'])=='active')
						 {
							$checked7='checked="checked"'; 
						 }
						 else
						 {
							 $checked7="";
						 }
                		?>
                        <h3 class="page_heading">SMS alert to be sent to admin when there is get an new order  by the customer. </h3>
                     <table class='form-table' border='0' id='api_settings_tbl'>
                            <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[chk_admin_order_sms_alert]" value="" size="55" <?php echo $checked7;?> class="check_css"/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                           </tr>
                           <tr>
                                <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label> </td>
                                <td align='left' scope='row'><textarea id='admin_txt_area2' name='settings_admin[admin_txt_area2]' class='text_area'><?php echo $admin_template_sms_alert['admin_txt_area2'];?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p>                                </td>
                           </tr>
                           <tr>
                                <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                                <td align='left' scope='row'>
                                    <ol class='admin_second_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                                         <li>[shop_name]</li>
                                         <li>[shop_domain]</li>
                                         <li>[customer_firstname]</li>
                                         <li>[customer_lastname]</li>
                                         <li>[customer_address]</li>
                                         <li>[customer_postcode]</li>
                                         <li>[customer_city]</li>
                                         <li>[customer_country]</li>
                                         <li>[order_id]</li>
                                         <li>[order_total]</li>
                                         <li>[order_products_count]</li>
                                         <li>[order_status]</li>
                                     </ol>
                                     <p class='description'><span>Select placeholder</span></p>
                                  </td>
                           </tr>
                           <tr>
                                 <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                                 <td align="left" scope="row">
                                  	  <?php
										 //====static text format for preview sms=====//
										 $admin_new_order_message_format		=	$admin_template_sms_alert['admin_txt_area2'];
										 $search_admin_new_order 		  	 	= 	array("[order_products_count]","[order_total]","[order_id]","[customer_firstname]", "[customer_lastname]","[customer_address]","[customer_postcode]","[customer_city]","[customer_country]","[shop_name]","[shop_domain]","[order_status]");
				   			 			 $replace_admin_new_order   	        = 	array($product_count,$order_total,$order_id,$customer_firstname,$customer_lastname,$address,$postcode,$city,$country,$site_title,$domain,$order_status); 
				  						 $preview_message_admin_new_order		= 	str_replace($search_admin_new_order,$replace_admin_new_order,$admin_new_order_message_format);
                               		 ?>
                                  
                                    <input type="text" name="settings_admin[admin_txt_contact2]" id="admin_txt_contact2" class="sms_text" value="" size="55"/>
								    <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up7')"/>       
                                    <input type="button" name="admin_sms_alert" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('admin_txt_contact2','<?php  echo $preview_message_admin_new_order;?>')"/>
                                   <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                   </p>
                                   <div id="element_to_pop_up" class="element_to_pop_up7">
                                     <a class="b-close" style="font-size: 20px;">X<a/>
                                     <h3>Message Preview</h3>
                                     <textarea  style="height: 200px;width: 100%;"><?php  echo $preview_message_admin_new_order;?></textarea><span id="txterror" style="color:red;"></span>
                                   </div>
                                  </td>
                             </tr>
                             <tr>
                                     <td></td>
                                     <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-admin_template' value='sms_alert' /><input type="hidden" name="display_admin_div2" value="admin_tbl_2" /></p>
                                     </td>
                             </tr>
                             </table>
                     </div>
             </form> 

               <!---------------Admin Return Order Table------------------>
		     <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div7')">
                   <div class="table_div7"  <?php echo $admin_div3_css;?>>
                   		<?php 
						if(isset($admin_template_order_return['chk_admin_return_order'])=='active')
						 {
							$checked8='checked="checked"'; 
						 }
						 else
						 {
							 $checked8="";
						 }
                  		 ?>	
                         <h3 class="page_heading">SMS alert to be sent to admin when there is an order return request placed by the customer. </h3>
                         <table class='form-table' border='0' id='api_settings_tbl'>
                             <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[chk_admin_return_order]" value="" size="55" <?php echo $checked8; ?> class="check_css"/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                             <tr>
                                     <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                                     <td align='left' scope='row'><textarea id='admin_txt_area3' name='settings_admin[admin_txt_area3]' class='text_area'><?php echo $admin_template_order_return['admin_txt_area3'];?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p></td>
                             </tr>
                             <tr>
                                     <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                                     <td align='left' scope='row'>
                                     <ol class='admin_third_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                                         <li>[shop_name]</li>
                                         <li>[shop_domain]</li>
                                         <li>[customer_firstname]</li>
                                         <li>[customer_lastname]</li>
                                         <li>[customer_address]</li>
                                         <li>[customer_postcode] </li>
                                         <li>[customer_city]</li>
                                         <li>[customer_country]</li>
                                         <li>[order_id]</li>
                                         <li>[order_total]</li>
                                         <li>[order_status]</li>
                                         <li>[return_product_name]</li>
                                         <li>[return_reason]</li>
                                     </ol>
                                     <p class='description'><span>Select placeholder</span></p>
                                     </td>
                             </tr>
                             <tr>
                             	<td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>
                                <td align="left" scope="row">
                                    
                                     <?php
										 //====static text format for preview sms=====//
										 $admin_order_return_message_format		=	$admin_template_order_return['admin_txt_area3'];
										 $search_admin_order_return    			= 	array("[order_products_count]","[order_total]","[order_id]","[customer_firstname]", "[customer_lastname]","[customer_address]","[customer_postcode]","[customer_city]","[customer_country]","[shop_name]","[shop_domain]","[return_product_name]","[return_reason]","[order_status]","[order_date]");
										 $replace_admin_order_return    		= 	array($product_count,$order_total,$order_id,$customer_firstname,$customer_lastname,$address,$postcode,$city,$country,$site_title,$domain,$prod_name,$return_resion,$status,$today);  
										 $preview_message_admin_order_return	= 	str_replace($search_admin_order_return,$replace_admin_order_return,$admin_order_return_message_format);
										
									?>
                                    <input type="text" name="settings_admin[admin_txt_contact3]" id="admin_txt_contact3" class="sms_text" value="" size="55"/>
                                    <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up8')"/> 
                                    <input type="button" name="admin_order_return" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('admin_txt_contact3','<?php  echo $preview_message_admin_order_return;?>')"/>
                                     <p class="description">
                                        <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                     </p>
                                     <div id="element_to_pop_up" class="element_to_pop_up8">
                                         <a class="b-close" style="font-size: 20px;">X<a/>
			                             <h3>Message Preview</h3>
                             			<textarea  style="height: 200px;width: 100%;"><?php  echo $preview_message_admin_order_return;?></textarea><span id="txterror" style="color:red;"></span>
                         			 </div>
                                 </td>
                             </tr>
                             <tr>
                                     <td></td>
                                     <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-admin_template' value='return_order' /><input type="hidden" name="display_admin_div3" value="admin_tbl_3" /></p></td>
                             </tr>
                        </table>	   
                   </div>
             </form> 

              <!---------------Admin Contact Inquiry table------------------>

             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div8')">
                   <div class="table_div8" <?php echo $admin_div4_css;?>>
					<?php 
                     if(isset($admin_template_contact_inquiry['chk_admin_contact_inquiry'])=='active')
                     {
                        $checked9='checked="checked"'; 
                     }
                     else
                     {
                         $checked9="";
                     }
					 ?>	
                        <h3 class="page_heading">SMS alert for admin when a customer fills up a contact form with a gist of a message.</h3>
                        <table class='form-table' border='0' id='api_settings_tbl'>
                             <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[chk_admin_contact_inquiry]" value="" size="55" <?php echo $checked9;?> class="check_css"/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                            <tr>
                                 <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                                 <td align='left' scope='row'><textarea id='admin_txt_area4' name='settings_admin[admin_txt_area4]' class='text_area'><?php echo $admin_template_contact_inquiry['admin_txt_area4'];?></textarea><span id="txterror" style="color:red;"></span><p class='description'><span>Enter Message Format</span></p></td>
                            </tr>
                            <tr>
                                 <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                                  <td align='left' scope='row'>
                                  	<ol class='admin_fourth_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                                         <li>[shop_name]</li>
                                         <li>[shop_domain]</li>
                                         <li>[customer_name]</li>
                                         <li>[customer_email]</li>
                                         <li>[customer_message]</li>
                                     </ol>
                                     <p class='description'><span>Select placeholder</span></p>
                                     </td>
                            </tr>
                            <tr>
								<td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number</label> </td>

                                <td align="left" scope="row">
                                 <?php
										 //====static text format for preview sms=====//
										 $admin_contact_inquiry_message_format		=	$admin_template_contact_inquiry['admin_txt_area4'];
										 $search_admin_contact_inquiry   			= 	array("[shop_name]","[shop_domain]","[customer_name]","[customer_email]","[customer_message]");
										 $replace_admin_contact_inquiry    			= 	array($site_title,$domain,$customer_firstname,$customer_email,$customer_message);  
										 $preview_message_admin_contact_inquiry 	= 	str_replace($search_admin_contact_inquiry,$replace_admin_contact_inquiry,$admin_contact_inquiry_message_format);
								?>		
                                 <input type="text" name="settings_admin[admin_txt_contact4]" id="admin_txt_contact4" class="sms_text" value="" size="55"/>
                                 <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up9')"/>  <input type="button" name="admin_order_changed" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;" onclick="send_test_sms_javascript('admin_txt_contact4','<?php  echo  $preview_message_admin_contact_inquiry;?>')"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                 </p>
                                 <div id="element_to_pop_up" class="element_to_pop_up9">
                         	        <a class="b-close" style="font-size: 20px;">X<a/>
                         			<h3>Message Preview</h3>
                         			<textarea  style="height: 200px;width: 100%;"><?php  echo  $preview_message_admin_contact_inquiry;?></textarea><span id="txterror" style="color:red;"></span>
                      			 </div>
                                  </td>

                             </tr>

                             <tr>

                                 <td></td>

                                 <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-admin_template' value='contact_inquiry' /><input type="hidden" name="display_admin_div4" value="admin_tbl_4" /></p>

                                </td>
                             </tr>
                          </table>
 				   </div>
             </form> 
          </div>
      </div>

       
     <!----------------SMS History------------------>

    <?php
	  break;
	  case 'sms_history' : 
	  ?>
      <div class="wrap">
	     <h2>
          <?php _e( 'SMS History', 'woocommerce_SMSCountry' ); ?>
         </h2>
               <div style="border:1px solid black;background-color:white;border-radius:5px 5px;">
           	   <center>
               <div class="filter_div">
               <?php
				 global $wpdb;
				 $page_per_record			=	10;
				 $current_page				=   0;
				 $page_number				=	null;
				 $table_history	    		=   $wpdb->prefix . 'smscountry_history';
			     $total_pages				= 	0;
				 $from_date_for_sticky_value=	null;
				 $to_date_for_sticky_value	=	null;
				 $count						=	0;
				 $search_record_by_string	=array();
				 $from_date="";
				 $to_date	="";
				 //$record_not_found			=	null;
				if(isset($_GET['page_number']))
				{
					 if(isset($_POST['search']))
					 {
						 
						 $page_number=1-1;
						 $current_page=$page_number*$page_per_record;
						 $count=$current_page;
					 }
					 else
					 {						 
						 $page_number=$_GET['page_number']-1;
						 $current_page=$page_number*$page_per_record;
						 $count=$current_page;
					 }
					 
				}
		    	//=============Code for search option with pagination====//	
			    if(isset($_POST['search']))
			    {
					
					$message_type				=	$_POST['message_Type'];
					$from_date					=	$_POST['search_from_date'];
					$to_date					=	$_POST['search_to_date'];
					$mobile_number				=   $_POST['txt_mob_number'];
					$message_status				= $_POST['message_status'];
					//print_r($_POST);
					$query="Select * from `$table_history` where";
					foreach($_POST as $key=>$value)
					{
						if($key=="message_Type" )
						{
							if($value!="")
							{
								$query.=" sms_flag='$value' AND";	
							}
						}
						
						if($key=="message_status")
						{
						  	if($value!="")
							{
						 		 $query.=" message_status='$value' AND"; 
							}
						}
						
						if($key=="txt_mob_number")
						{
							if($value!="")
							{
						  		$query.=" mobile_no='$value' AND"; 
							}
						}
						
						if($key=="search_from_date")
						{
							$from_date=$value;
						}
						if($key=="search_to_date")
						{
							$to_date=$value;
							if($to_date!="")
							{
								$query.=" date(`date_time`) BETWEEN '$from_date' AND '$to_date' AND";
							}
						}
					}
					
					$query.=" ORDER BY `sms_id` DESC";
					$final_query= str_replace('AND ORDER', 'ORDER', $query);
					if($_GET['emptyFlag']=="1")
					{
						$get_search_records=$wpdb->get_results($final_query." limit 0,$page_per_record");
					}
					else
					{
						$get_search_records=$wpdb->get_results($final_query." limit $current_page,$page_per_record");
					}
					
					
                    $get_search_records_for_pagination= $wpdb->get_results($final_query);  
					$total_record=$wpdb->num_rows;
					$total_pages=ceil($total_record/$page_per_record);
					
				}	


                else if(isset($_GET['flag']))
				{
					$message_type	=	$_GET['option1'];
					$message_status	=	$_GET['option2'];
					$from_date		=	$_GET['from'];
					$to_date		=	$_GET['to'];	
					$mobile_number	= 	$_GET['mobile'];
					$pagination_array			=   array('message_Type'=>$message_type,'message_status'=>$message_status,'mobile_number'=>$mobile_number,'from_date'=>$from_date,'to_date'=>$to_date);
					$query="Select * from `$table_history` where";
					
					foreach($pagination_array as $key=>$value)
					{
						if($key=="message_Type" )
						{
							if($value!="")
							{
								$query.=" sms_flag='$value' AND";	
							}
						}
						
						if($key=="message_status")
						{
						  	if($value!="")
							{
						 		 $query.=" message_status='$value' AND"; 
							}
						}
						
						if($key=="mobile_number")
						{
							if($value!="")
							{
						  		$query.=" mobile_no='$value' AND"; 
							}
						}
						
						if($key=="from_date")
						{
							$from_date=$value;
						}
						if($key=="to_date")
						{
							$to_date=$value;
							if($to_date!="")
							{
								$query.=" date(`date_time`) BETWEEN '$from_date' AND '$to_date' AND";
							}
						}
					}
					
					$query.=" ORDER BY `sms_id` DESC";
					$final_query= str_replace('AND ORDER', 'ORDER', $query);
					
					$get_search_records2=$wpdb->get_results($final_query." limit $current_page,$page_per_record");
                    $get_search_records_for_pagination2= $wpdb->get_results($final_query);  
					
					$total_record=$wpdb->num_rows;
					$total_pages=ceil($total_record/$page_per_record);
				}
				 //==========without search with pagination=====/	
				  else
				  {
					  $prev_date = date('Y-m-d', strtotime($date .' -2 day'));
					  $current_date = date('Y-m-d', strtotime($date .' 0 day'));
					
					// echo "select * from `$table_history` WHERE date_time > DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY `sms_id` DESC limit  $current_page,$page_per_record";
					  $number_of_rows = $wpdb->get_results("select * from `$table_history` WHERE date(`date_time`) BETWEEN '$prev_date' AND '$current_date' ORDER BY `sms_id` DESC limit  $current_page,$page_per_record"); 
					
					  $total_rows=$wpdb->get_results("select * from `$table_history` WHERE date(`date_time`) BETWEEN '$prev_date' AND '$current_date' ORDER BY `sms_id` DESC");
					  $total_record=$wpdb->num_rows;
					  $total_pages=ceil($total_record/$page_per_record);

				  }
				  
				  
				 ?> 

                   <form action="" name="woocommerce_SMSCountry_syncSettings_section" method="POST" onsubmit="return mobilenumber()">
                            <label>Message Type:</label>
                            <select value="" name="message_Type">
                            		<option value="">Select Option</option> 
                                    <option disabled="disabled" value="" >---USER TEMPLATE---</option>
                                    <option value="user_signup" <?php if($message_type=='user_signup'){echo 'selected="selected"';} ?>>Sign up</option>
                                    <option value="otp_registration" <?php if($message_type=='otp_registration'){echo 'selected="selected"';} ?>>Sign up Verification</option>
                                    <option value="user_new_order" <?php if($message_type=='user_new_order'){echo 'selected="selected"';} ?>>New Order Placed</option>
                                    <option value="user_refund" <?php if($message_type=='user_refund'){echo 'selected="selected"';} ?>>Return Order</option>
                                    <option value="user_order_status" <?php if($message_type=='user_order_status'){echo 'selected="selected"';} ?>>User Order Status</option>
                                    <option disabled="disabled" value="">---ADMIN TEMPLATE---</option>
                                    <option value="admin_signup" <?php if($message_type=='admin_signup'){echo 'selected="selected"';} ?>>Sign up</option>
                                    <option value="admin_new_order" <?php if($message_type=='admin_new_order'){echo 'selected="selected"';} ?>>New Order SMS</option>
                                    <option value="admin_refund" <?php if($message_type=='admin_refund'){echo 'selected="selected"';} ?>>Return Order</option>
                                    <option value="admin_contact" <?php if($message_type=='admin_contact'){echo 'selected="selected"';} ?>>Contact Enquiry</option>
                            </select>&nbsp;
														
                            <label>Message Status:</label>
                            	<select value="" name="message_status">
                            		<option value="">Select Option</option> 
                                    <option value="Message In Queue" <?php if($message_status=='Message In Queue'){echo 'selected="selected"';} ?>>Message In Queue</option>
                                    <option value="Submitted To Carrier" <?php if($message_status=='Submitted To Carrier'){echo 'selected="selected"';} ?>>Submitted To Carrier</option>
                                    <option value="Un Delivered" <?php if($message_status=='Un Delivered'){echo 'selected="selected"';} ?>>Un Delivered</option>
                                    <option value="Delivered" <?php if($message_status=='Delivered'){echo 'selected="selected"';} ?>>Delivered</option>
                                    <option value="Expired" <?php if($message_status=='Expired'){echo 'selected="selected"';} ?>>Expired</option>
                                    <option value="Rejected" <?php if($message_status=='Rejected'){echo 'selected="selected"';} ?>>Rejected</option>
                                    <option value="Message Sent" <?php if($message_status=='Message Sent'){echo 'selected="selected"';} ?>>Message Sent</option>
                                    <option value="Opted Out Mobile Number" <?php if($message_status=='Opted Out Mobile Number'){echo 'selected="selected"';} ?>>Opted Out Mobile Number</option>
                                    <option value="Invalid Mobile Number" <?php if($message_status=='Invalid Mobile Number'){echo 'selected="selected"';} ?>>Invalid Mobile Number</option>
                            
                            </select>&nbsp;
  													
                            <label>Mobile Number</label>
                            <input type="text" class="txt_filter_mob" value="<?php echo $mobile_number;?>" name="txt_mob_number" kl_virtual_keyboard_secure_input="on">
  
                            <input type="text" class="datetimepicker  date_from_txt" value="<?php echo $from_date;?>" name="search_from_date" kl_virtual_keyboard_secure_input="on" placeholder="FROM DATE">&nbsp;

                            <input type="text" class="datetimepicker date_to_txt" value="<?php echo $to_date;?>" name="search_to_date" kl_virtual_keyboard_secure_input="on" placeholder="TO DATE">&nbsp;
                            <input type="submit" value="Search" class="button-primary search" name="search"> 			
			       </form>

                 </div>
                </center> 
                 <table class="history_logs">
					    <thead>
                        <tr>
                         <h3 class='number_of_record_top'>Number Of Records: <?php echo $total_record;?></h3>
                          <th class="th1">Sr.No</th>
                          <th class="th2">Date/Time</th>
                          <th class="th3">Message Text</th>
                          <th class="th4">No.Of SMS</th>
                          <th class="th5">Type Of Template</th>
                          <th class="th6">Msg Status</th>
                          <th class="th7">Mobile Number</th>
                        </tr>
                      </thead>
                      <tbody>

			          <?php
					  //======display result when search=====//
						if(isset($_POST['search']))
						{
							foreach($get_search_records as $search_retrived_data)
							{
								$count+=1;
							 ?>
							 <tr>
                                  <td><?php echo $count?></td>
                                  <td><strong><?php echo $search_retrived_data->date_time;?></strong></td>
                                  <td><?php echo $search_retrived_data->message_text;?></td>
                                  <td>1</td>
                                  <td><?php echo $search_retrived_data->message_type;?></td>
                                  <td><?php echo $search_retrived_data->message_status;?></td>
                                  <td><?php echo $search_retrived_data->mobile_no;?>
                                  </td></tr>
						    <?php
							}
						}
                        //======display result when search+pagination=====//
					    else if(isset($_GET['flag']))
						{
							
							foreach( $get_search_records2 as $search_retrived_data)
							{
								$count+=1;
							 ?>
							 <tr>
                                  <td><?php echo $count?></td>
                                  <td><strong><?php echo $search_retrived_data->date_time;?></strong></td>
                                  <td><?php echo $search_retrived_data->message_text;?></td>
                                  <td>1</td>
                                  <td><?php echo $search_retrived_data->message_type;?></td>
                                  <td><?php echo $search_retrived_data->message_status;?></td>
                                  <td><?php echo $search_retrived_data->mobile_no;?>
                                  </td></tr>
						    <?php
							}
						}
						//======display result withour search=====//
						else
						{  
							foreach($number_of_rows as $retrived_data)
							{
								$count+=1;
							 ?>
							 <tr>
                                  <td><?php echo $count?></td>
                                  <td><strong><?php echo $retrived_data->date_time;?></strong></td>
                                  <td><?php echo $retrived_data->message_text;?></td>
                                  <td>1</td>
                                  <td><?php echo $retrived_data->message_type;?></td>
                                  <td><?php echo $retrived_data->message_status;?></td>
                                  <td><?php echo $retrived_data->mobile_no;?></td>
							</tr>
						   <?php
							}
                         }
                        ?>
                       </tbody>
                    </table>
                    <?php
					     //==========pagination functionality============//
				    	 echo "<h3 class='number_record'>Number Of Records: ".$total_record."</h3><center class='pagination_center'><a href='#' id='prev'>Prev</a>"; 
							 $page_number+=1;
							 for($anchor_count=1;$anchor_count<=$total_pages;$anchor_count++)
							 {
								if(isset($_POST['search']))
								{
								
									 if($page_number==$anchor_count)
									 {

										 echo "<a class='selected_anchor' id='pagination_anchor' href='$current_url&page_number=$anchor_count&flag=1&option1=$message_type&option2=$message_status&from=$from_date&to=$to_date&mobile=$mobile_number'> $anchor_count </a>";
									 }
									 else
									 {
										 echo "<a id='pagination_anchor' href='$current_url&page_number=$anchor_count&flag=1&option1=$message_type&option2=$message_status&from=$from_date&to=$to_date&mobile=$mobile_number'> $anchor_count </a>";
									 }
								} 
                                
								else if(isset($_GET['flag']))
								{
									
									if($page_number==$anchor_count)
									 {

										 echo "<a class='selected_anchor' id='pagination_anchor' href='$current_url&page_number=$anchor_count&flag=1&option1=$message_type&option2=$message_status&from=$from_date&to=$to_date&mobile=$mobile_number'> $anchor_count </a>";
									 }
									 else
									 {
										 echo "<a id='pagination_anchor' href='$current_url&page_number=$anchor_count&flag=1&option1=$message_type&option2=$message_status&from=$from_date&to=$to_date&mobile=$mobile_number'> $anchor_count </a>";
									 } 
								}
								else
								{
									
									 if($page_number==$anchor_count)
									 {
										 echo "<a class='selected_anchor' id='pagination_anchor' href='$current_url&page_number=$anchor_count&emptyFlag=1' > $anchor_count </a>";
									 }
									 else
									 {
										 echo "<a id='pagination_anchor' href='$current_url&page_number=$anchor_count&emptyFlag=1'> $anchor_count </a>";
									 }

								}
							 }
							  echo "<a href='#' id='next'>Next</a>";
							  echo "</center></p>";

					?>
                    <center><div class="not_found_div"></div></center>
              </div>
        </div>
     <?php
   }
}
?>

  </div>
</div>
 <script type="text/javascript">   
     var ajaxurl = '<?php echo esc_url( home_url( '/' ));?>wp-admin/admin-ajax.php';
	  function send_test_sms_javascript(mobile,message)
	  {
	  		var mobile_no		 = 	jQuery("#"+mobile).val();
			var mob 		 	 = /^[\d]{10,13}$/;
			if(mobile_no == '' || !mob.test(mobile_no))
			{
				 alert("please enter correct mobile no..should not be less than 10 digit & grater than 13 digit");
			}
		    else
		   {
			    jQuery.ajax
				  ({ 
					   data: {action: 'send_test_sms', mobile_no:mobile_no,message:message},
					   type: 'post',
					   url: ajaxurl,
					   success: function(data) 
					   {
						  alert(data); //should print out the name since you sent it along
						  return false;
					   }
					  });
		  }
	}

</script>

