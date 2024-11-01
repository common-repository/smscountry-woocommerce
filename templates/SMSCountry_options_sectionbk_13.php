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
	$user_template_new_order= get_option( 'woocommerce_user_template_new_order' );
	$user_template_order_return= get_option( 'woocommerce_user_template_return_order' );
	$user_template_order_changed= get_option( 'woocommerce_user_template_order_changed' );
	
	$admin_template_sign_up= get_option( 'woocommerce_admin_template_sign_Up');
	$admin_template_sign_up_history= get_option( 'woocommerce_admin_template_sign_up_history');
	$admin_template_sms_alert= get_option( 'woocommerce_admin_template_sms_alert' );
	$admin_template_order_return= get_option( 'woocommerce_admin_template_return_order' );
	$admin_template_contact_inquiry= get_option( 'woocommerce_admin_template_contact_inquiry' );
	
	$settings_admin=get_option( 'woocommerce_user_template_setting' );
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
      <div class="wrap">
        <h2>
          <?php _e( 'General Settings', 'woocommerce_SMSCountry' ); ?>
        </h2>
        <div style="border:1px solid black;background-color:white;border-radius:5px 5px;" class="genral_setting_div">
             <table class="form-table" border="0" id="api_settings_tbl">
              
             <tr>
              <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Application Setup</label>
              </td>
              <td align="left" scope="row"><a href="<?php echo WC_SMSCountry::$SMSCountry_app_setup_url; ?>?redirect_uri=<?php echo urlencode(admin_url('/admin.php')); ?>" target="_blank">
                <input type="button" class="button button-secondary warn" name="setup_SMSCountry_app" id="setup_SMSCountry_app" value="Setup SMSCountry Application" size="55"/>
                </a>
                <p class="description">
                  <?php _e( 'Setup your SMSCountry Application & fetch API Credentials.', 'woocommerce_SMSCountry' ); ?>
                </p></td>
            </tr>
             
              <tr>
                <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Username</label></td>
                <td align="left" scope="row"><p alt="User Name Registered On www.smscountry.com" class="tooltip"> <input type="text" name="settings_general[txt_username]" id="general_username" value="<?php echo @$settings_general['txt_username'];?>" size="55"/></p>
                  <p class="description">
                    <?php _e( 'Enter Username.', 'woocommerce_SMSCountry' ); ?>
                  </p></td>
              </tr>
              <tr>
                <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Password</label></td>
                <td align="left" scope="row"><p alt="password for the above user name registered on www.smscountry.com" class="tooltip"> <input type="password" name="settings_general[txt_password]" id="txt_password" value="<?php echo @$settings_general['txt_password'];?>" size="55" /></p>
                  <p class="description">
                    <?php _e( 'Enter Password.', 'woocommerce_SMSCountry' ); ?>
                  </p>
                </td>
              </tr>
              <tr>
                    <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Sender Id</label></td>
                    <td align="left" scope="row"><p alt="Sender id should be required" class="tooltip"> <input type="text" name="settings_general[txt_seinder_id]" id="txt_sender_id" value="<?php echo @$settings_general['txt_seinder_id'];?>" size="55" /></p>
                      <p class="description">
                        <?php _e( 'Enter ID.', 'woocommerce_SMSCountry' ); ?>
                      </p>
                </td>
              </tr>
               <tr>
                <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Delivery Report URL</label></td>
                <td align="left" scope="row"><input type="text" name="" id="delivery_report" value="<?php echo admin_url('admin-ajax.php');?>?action=SMSCountyCallBack" size="55" readonly="readonly"/>
                  <p class="description">
                    <?php _e( 'Please share this URL with SMSCountry. To activate Delivery report logs..', 'woocommerce_SMSCountry' ); ?>
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
      
     <!--======User template Section=======----->
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
			$btn1_css="blue";
			//=========code for second table======//
			if(isset($_POST['display_div2'])=='tbl_2')
			 {
				$div2_css="";
				$btn2_css="blue";
				$div1_css="style='display:none;'";
				$btn1_css="";
			 }
			 else
			 {
				$div2_css="style='display:none;'";
				$btn2_css="";
			 }
			
			//=========code for third table======//
			if(isset($_POST['display_div3'])=='tbl_3')
			 {
				$div3_css="";
				$btn3_css="blue";
				$div1_css="style='display:none;'";
				$btn1_css="";
			 }
			 else
			 {
				$div3_css="style='display:none;'";
				$btn3_css="";
				 }
			 
			 //=========code for fourth table======//
			if(isset($_POST['display_div4'])=='tbl_4')
			 {
				$div4_css="";
				$btn4_css="blue";
				$div1_css="style='display:none;'";
				$btn1_css="";
			 }
			 else
			 {
				$div4_css="style='display:none;'";
				$btn4_css="";
				 }
			 
			 //=========code for third table======//
			if(isset($_POST['display_div5'])=='tbl_5')
			 {
				$div5_css="";
				$btn5_css="blue";
				$div1_css="style='display:none;'";
				$btn1_css="";
			 }
			 else
			 {
				$div5_css="style='display:none;'";
				$btn5_css="";
			 }
		
		?>
        <div style="border:1px solid black;background-color:white;border-radius:5px 5px;">
           <div id="div1">
                <ul id="tabs_li">
                
                    <li ><input type="button" id="btn1" class="button-primary <?php echo $btn1_css;?>"  value="1. Sign Up"/>
			        </li>
                    <li><input type="button" id="btn2" class="button-primary <?php echo $btn2_css;?>"  value="2. Sign Up Verification"/></a>
                    </li>
                     <li ><input type="button" id="btn_new_order" class="button-primary <?php echo $btn3_css;?>"  value="3. New Order Placed"/></li>
                    <li ><input type="button" id="btn3" class="button-primary <?php echo $btn4_css;?>"  value="3. Return Order"/>
                    </li>
                    <li ><input type="button" id="btn4" class="button-primary <?php echo $btn5_css;?>" value="4. Order Status Changed"/>
                </ul>
           </div>
           
           <!-----User First table------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div')">
           <div class="table_div" <?php echo $div1_css;?>>


           <?php 
		  
		   	if(isset($user_template_sign_up['txt_check1'])=='active')
						 {
							$checked='checked="checked"'; 
						 }
						 else
						 {
							 $checked="";
						 }
				?>	
		   
		       <table class="form-table" border="0" id="api_settings_tbl">
                    <tr>
                    	<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                        <td align="left" scope="row"><input type="checkbox" name="setting_user[txt_check1]" value="" size="55" <?php echo $checked;?> />
                          <p class="description">
                            <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                      </tr>
                     <tr>
                      <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Message Format<span class="star">*</span></label> 
                      </td>
                      <td align="left" scope="row"><textarea id="txt_area1" name="setting_user[txt_area1]" class="text_area" ><?php echo $user_template_sign_up['txt_area1'];?></textarea>
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
                        <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                        <td align="left" scope="row">
                        <input type="text" name="setting_user[txt_contact]" id="txt_contact" class="sms_text" value="<?php echo $user_template_sign_up['txt_contact'];?>" size="55"/>
                       <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;
    height: 37px;"   onclick="get_popup('element_to_pop_up1');"/>  <input type="button" name="sign_up_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                        <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p>
                           <!-- Element to pop up -->
                      <div id="element_to_pop_up" class="element_to_pop_up1">
                          <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php echo $user_template_sign_up['txt_area1'];?></textarea>
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
           
           <!-----User Second table------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div2')">
           <div class="table_div2" <?php echo $div2_css;?>>
           		 
                  <?php 
		   			if(isset($user_template_sign_verify['txt_check2'])=='active')
						 {
							$checked2='checked="checked"'; 
						 }
						 else
						 {
							 $checked2="";
						 }
				?>	
                 <table class='form-table' border='0' id='api_settings_tbl'>
                     <tr>
                    	<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                        <td align="left" scope="row"><input type="checkbox" name="setting_user[txt_check2]" value="" size="55" <?php echo $checked2;?>/>
                          <p class="description">
                            <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                      </tr>
                     <tr>
                         <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label> </td>
                         <td align='left' scope='row'><textarea id='txt_area2' name='setting_user[txt_area]' class='text_area'><?php echo $user_template_sign_verify['txt_area'] ?></textarea><p class='description'><span>Enter Message Format</span></p></td>
                     </tr>
                     <tr><td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                         <td align='left' scope='row'>
                         <ol class='user_second_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol">
                         <li>[shop_name]</li>
                         <li>[shop_domain]</li>
                         <li>[verification_code]</li>
                         </ol>
                         <p class='description'><span>Select placeholder</span></p></td>
                     </tr>
                     <tr>
                          <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                        <td align="left" scope="row">
                        <input type="text" name="setting_user[txt_contact2]" id="txt_contact2" class="sms_text" value="<?php echo $user_template_sign_verify['txt_contact2'];?>" size="55"/>
                          <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;
    height: 37px;" onclick="get_popup('element_to_pop_up2')"/> <input type="button" name="sign_up_verification_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                        <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p>
                          <div id="element_to_pop_up" class="element_to_pop_up2">
                          <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php echo $user_template_sign_verify['txt_area'];?></textarea>
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
           
           
           <!------Third Table For New order------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div_new_order')">
           <div class="table_div_new_order" <?php echo $div3_css;?>>
           	   <table class='form-table' border='0' id='api_settings_tbl'>
               
					   <?php 
                      
                        if(isset($user_template_new_order['txt_check_order'])=='active')
                                     {
                                        $checked_new='checked="checked"'; 
                                     }
                                     else
                                     {
                                         $checked_new="";
                                     }
                        ?>	
                      <tr>
                    	<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                        <td align="left" scope="row"><input type="checkbox" name="setting_user[txt_check_order]" value="" size="55" <?php echo  $checked_new;?>/>
                          <p class="description">
                            <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                      </tr>
                     <tr>
                             <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                             <td align='left' scope='row'><textarea id='txt_area_new_order' name='setting_user[txt_area_new_order]' class='text_area'><?php echo $user_template_new_order['txt_area_new_order'];?></textarea><p class='description'><span>Enter Message Format</span></p>
                             </td>
                     </tr>
                     <tr>
                             <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                             <td align='left' scope='row'>
                             <ol class='user_new_order_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol"><li>[shop_name]</li>
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
                     	<td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                        <td align="left" scope="row">
                        <input type="text" name="setting_user[txt_contact_new_order]" id="txt_contact_new_order" class="sms_text" value="<?php echo $user_template_new_order['txt_contact_new_order'];?>" size="55"/>
                       <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;
    height: 37px;" onclick="get_popup('element_to_pop_up10')"/>  <input type="button" name="order_return_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                        <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p>
                          <div id="element_to_pop_up" class="element_to_pop_up10">
                          <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php echo $user_template_new_order['txt_area_new_order'];?></textarea>
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
           
           <!------Fourth table for return order------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div3')">
           <div class="table_div3" <?php echo $div4_css;?>>
           		<?php 
					if(isset($user_template_order_return['txt_check3'])=='active')
								 {
									$checked3='checked="checked"'; 
								 }
								 else
								 {
									 $checked3="";
								 }
				?>	
                <table class='form-table' border='0' id='api_settings_tbl'>
                      <tr>
                    	<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                        <td align="left" scope="row"><input type="checkbox" name="setting_user[txt_check3]" value="" size="55" <?php echo $checked3;?>/>
                          <p class="description">
                            <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                      </tr>
                     <tr>
                             <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                             <td align='left' scope='row'><textarea id='txt_area3' name='setting_user[txt_area3]' class='text_area'><?php echo $user_template_order_return['txt_area3'] ?></textarea><p class='description'><span>Enter Message Format</span></p>
                             </td>
                     </tr>
                     <tr>
                             <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                             <td align='left' scope='row'>
                             <ol class='user_third_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol"><li>[shop_name]</li>
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
                     	<td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                        <td align="left" scope="row">
                        <input type="text" name="setting_user[txt_contact3]" id="txt_contact3" class="sms_text" value="<?php echo $user_template_order_return['txt_contact3'];?>" size="55"/>
                          <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;
    height: 37px;" onclick="get_popup('element_to_pop_up3')"/><input type="button" name="order_return_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                        <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p>
                           <div id="element_to_pop_up" class="element_to_pop_up3">
                          <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php echo $user_template_order_return['txt_area3'];?></textarea>
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

		<!------------Fifth table for Order Changed------------------->  
          
         <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div4')">
           <div class="table_div4" <?php echo $div5_css;?>>
           		
                <?php 
					if(isset($user_template_order_changed['txt_check4'])=='active')
								 {
									$checked4='checked="checked"'; 
								 }
								 else
								 {
									 $checked4="";
								 }
				?>	
                <table class='form-table' border='0' id='api_settings_tbl'>
                     <tr>
                    	<td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                        <td align="left" scope="row"><input type="checkbox" name="setting_user[txt_check4]"value="" size="55" <?php echo $checked4;?>/>
                          <p class="description">
                            <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                      </tr>
                     <tr>
                             <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label> </td>
                             <td align='left' scope='row'><textarea id='txt_area4' name='setting_user[txt_area4]' class='text_area'><?php echo $user_template_order_changed['txt_area4'] ?></textarea><p class='description'><span>Enter Message Format</span></p>
                             </td>
                     </tr>
                     <tr>
                             <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                             <td align='left' scope='row'>
                             <ol class='user_fourth_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol"><li>[shop_name]</li>
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
                             <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                            <td align="left" scope="row">
                            <input type="text" name="setting_user[txt_contact4]" id="txt_contact4" class="sms_text" value="<?php echo $user_template_order_changed['txt_contact4'];?>" size="55"/>
                            <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px;
    height: 37px;" onclick="get_popup('element_to_pop_up4')"/>   <input type="button" name="order_changed_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                            <p class="description">
                                <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                              </p>
                               <div id="element_to_pop_up" class="element_to_pop_up4">
                          <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php  echo $user_template_order_changed['txt_area4'];?></textarea>
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
       
      
      
	  <!--======admin template Section=======----->
      
	  <?php
	  break;
	  case 'admin_template' : 
	  ?>
     
      <div class="wrap">
       <?php
			//**************code for sticky btn/div**********//
		    $admin_div1_css="";
			$admin_btn1_css="blue";
			//=========code for second table======//
			if(isset($_POST['display_admin_div2'])=='admin_tbl_2')
			 {
				$admin_div2_css="";
				$admin_btn2_css="blue";
				$admin_div1_css="style='display:none;'";
				$admin_btn1_css="";
			 }
			 else
			 {
				$admin_div2_css="style='display:none;'";
				$admin_btn2_css="";
			 }
			
			//=========code for third table======//
			if(isset($_POST['display_admin_div3'])=='admin_tbl_3')
			 {
				$admin_div3_css="";
				$admin_btn3_css="blue";
				$admin_div1_css="style='display:none;'";
				$admin_btn1_css="";
			 }
			 else
			 {
				$admin_div3_css="style='display:none;'";
				$admin_btn3_css="";
			 }
			 
			 //=========code for fourth table======//
			if(isset($_POST['display_admin_div4'])=='admin_tbl_4')
			 {
				$admin_div4_css="";
				$admin_btn4_css="blue";
				$admin_div1_css="style='display:none;'";
				$admin_btn1_css="";
			 }
			 else
			 {
				$admin_div4_css="style='display:none;'";
				$admin_btn4_css="";
			 }
			 
			
		
		?>
        <h2>
          <?php _e( 'Admin Template', 'woocommerce_SMSCountry' ); ?>
        </h2>
        <div style="border:1px solid black;background-color:white;border-radius:5px 5px;">
           <div id="div1">
                <ul id="tabs_li">
                    
                    <li ><input type="button" id="btn_admin1" class="button-primary <?php echo $admin_btn1_css;?>" value="1. Sign Up"/>
                    </li>
                    <li><input type="button" id="btn_admin2" class="button-primary <?php echo $admin_btn2_css;?>"  value="2. Order SMS Alert"/></a>
                    </li>
                    <li ><input type="button" id="btn_admin3" class="button-primary <?php echo $admin_btn3_css;?>" value="3. Return Order"/>
                    </li>
                    <li ><input type="button" id="btn_admin4" class="button-primary <?php echo $admin_btn4_css;?>" value="4. Contact Inquiry"/>
                    </li>
                   
                </ul>
           </div>
           
           
         
            <div class="table_div9" <?php echo $admin_div1_css;?>>
                          <h2 class="nav-tab-wrapper">
                              <a class='nav-tab nav-tab-active' href="#" id="tab_admin">Sign up</a>
                              <a class='nav-tab nav-tab-active' href="#" id="tab_admin1">No. Of New Registered Customers</a>
                         </h2>
            </div>
            
           <!---------------Admin first table------------------>   
          <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div5')">
                   
                   
                   <div class="table_div5" <?php echo $admin_div1_css;?>>
                       <?php 
						if(isset($admin_template_sign_up['txt_check5'])=='active')
									 {
										$checked5='checked="checked"'; 
									 }
									 else
									 {
										 $checked5="";
									 }
					?>	
                       <table class="form-table" border="0" id="api_settings_tbl">
                            <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label> </td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[txt_check5]"  value="" size="55" <?php echo $checked5;?>/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                           
                            <tr>
                              <td align="left" scope="row" width="20%"><label style="margin-left:20px;"> Message Format<span class="star">*</span></label>
                              </td>
                              <td align="left" scope="row"><textarea id="admin_txt_area" name="settings_admin[admin_txt_area]" class="text_area"><?php echo $admin_template_sign_up['admin_txt_area'];?></textarea>
                                 <p class="description">
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
                              
                                   <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                                    <td align="left" scope="row">
                                    <input type="text" name="settings_admin[admin_txt_contact]" id="admin_txt_contact" class="sms_text" value="<?php echo $admin_template_sign_up['admin_txt_contact'];?>" size="55"/>
                                     <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up5')"/>  <input type="button" name="admin_sign_up" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                    <p class="description">
                                        <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                      </p>
                                       <div id="element_to_pop_up" class="element_to_pop_up5">
                                 <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php  echo $admin_template_sign_up['admin_txt_area'];?></textarea>
                      </div>
                                      </td>
                          
                                
                              </tr>
                              <tr>
                                <td>
                                </td>
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
             
             
             <!----------sign_up history table----------->
             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_history')">
                   
                   
                   <div class="table_history" style="display:none;">
                       <?php 
						if(isset($admin_template_sign_up_history['txt_check6'])=='active')
									 {
										$checked6='checked="checked"'; 
									 }
									 else
									 {
										 $checked6="";
									 }
					?>	
                       <table class="form-table" border="0" id="api_settings_tbl">
                            <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[txt_check6]" value="" size="55" <?php echo $checked6;?>/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                           <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Alerts </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[txt_check_daily]" value="" size="55" />&nbsp;Daily&nbsp;&nbsp;&nbsp;<input type="checkbox" name="settings_admin[txt_check_weekly]" value="" size="55" />&nbsp;Weekly&nbsp;&nbsp;&nbsp;<input type="checkbox" name="settings_admin[txt_check_monthly]" value="" size="55"/>&nbsp;Monthly
                                  <p class="description">
                                    <?php _e( 'Admin Alerts', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                            <tr>
                              <td align="left" scope="row" width="20%"><label style="margin-left:20px;"> Message Format<span class="star">*</span></label>
                              </td>
                              <td align="left" scope="row"><textarea id="history_txt_area" name="settings_admin[history_txt_area]" class="text_area"><?php echo $admin_template_sign_up_history['history_txt_area'];?></textarea>
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
                              
                                  <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                                <td align="left" scope="row">
                                <input type="text" name="settings_admin[history_txt_contact]" id="history_txt_contact" class="sms_text" value="<?php echo $admin_template_sign_up_history['history_txt_contact'];?>" size="55"/>
                                <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up6')"/>    <input type="button" name="admin_sign_up_history" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                  </p>
                                   <div id="element_to_pop_up" class="element_to_pop_up6">
                                 <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php  echo $admin_template_sign_up_history['history_txt_area'];?></textarea>
                      </div>
                                  </td>
                          
                              </tr>
                              <tr>
                                <td>
                                </td>
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
             
             <!---------------Admin second table------------------>
           
             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div6')">
                   <div class="table_div6" <?php echo $admin_div2_css;?>>
                      <?php 
						if(isset($admin_template_sms_alert['txt_check7'])=='active')
									 {
										$checked7='checked="checked"'; 
									 }
									 else
									 {
										 $checked7="";
									 }
					?>	
                      <table class='form-table' border='0' id='api_settings_tbl'>
                             <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[txt_check7]" value="" size="55" <?php echo $checked7;?>/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                             <tr>
                                     <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label> </td>
                                     <td align='left' scope='row'><textarea id='admin_txt_area2' name='settings_admin[admin_txt_area2]' class='text_area'><?php echo $admin_template_sms_alert['admin_txt_area2'];?></textarea><p class='description'><span>Enter Message Format</span></p>
                                     </td>
                             </tr>
                             <tr>
                                     <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                                     <td align='left' scope='row'>
                                     <ol class='admin_second_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol"><li>[shop_name]</li>
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
                                 <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                                <td align="left" scope="row">
                                <input type="text" name="settings_admin[admin_txt_contact2]" id="admin_txt_contact2" class="sms_text" value="<?php echo $admin_template_sms_alert['admin_txt_contact2'];?>" size="55"/>
                             <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up7')"/>       <input type="button" name="admin_sms_alert" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                  </p>
                                     <div id="element_to_pop_up" class="element_to_pop_up7">
                                 <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php  echo $admin_template_sms_alert['admin_txt_area2'];?></textarea>
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
             
             
             
              <!---------------Admin Third table------------------>
             
             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div7')">
                   <div class="table_div7"  <?php echo $admin_div3_css;?>>
                   		<?php 
						if(isset($admin_template_order_return['txt_check8'])=='active')
									 {
										$checked8='checked="checked"'; 
									 }
									 else
									 {
										 $checked8="";
									 }
					 ?>	
                         <table class='form-table' border='0' id='api_settings_tbl'>
                             <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[txt_check8]" value="" size="55" <?php echo $checked8; ?>/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                             <tr>
                                     <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                                     <td align='left' scope='row'><textarea id='admin_txt_area3' name='settings_admin[admin_txt_area3]' class='text_area'><?php echo $admin_template_order_return['admin_txt_area3'];?></textarea><p class='description'><span>Enter Message Format</span></p></td>
                             </tr>
                             <tr>
                                     <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                                     <td align='left' scope='row'>
                                     <ol class='admin_third_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol"><li>[shop_name]</li>
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
                             	<td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                                <td align="left" scope="row">
                                <input type="text" name="settings_admin[admin_txt_contact3]" id="admin_txt_contact3" class="sms_text" value="<?php echo $admin_template_order_return['admin_txt_contact3'];?>" size="55"/>
                                  <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up8')"/>  <input type="button" name="admin_order_return" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                  </p>
                                     <div id="element_to_pop_up" class="element_to_pop_up8">
                                 <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php  echo $admin_template_order_return['admin_txt_area3'];?></textarea>
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
             
              <!---------------Admin Fourth table------------------>
             
             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div8')">
                   <div class="table_div8" <?php echo $admin_div4_css;?>>
                   		<?php 
						if(isset($admin_template_contact_inquiry['txt_check9'])=='active')
									 {
										$checked9='checked="checked"'; 
									 }
									 else
									 {
										 $checked9="";
									 }
					 ?>	
                        <table class='form-table' border='0' id='api_settings_tbl'>
                             <tr>
                                <td align="left" scope="row" width="20%"><label style="margin-left:20px;">Activate </label></td>			
                                <td align="left" scope="row"><input type="checkbox" name="settings_admin[txt_check9]" value="" size="55" <?php echo $checked9;?>/>
                                  <p class="description">
                                    <?php _e( 'Enabled/Disabled', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                            </tr>
                             <tr>
                                     <td align='left' scope='row' width='20%'><label style='margin-left:20px;'>Message Format<span class="star">*</span></label></td>
                                     <td align='left' scope='row'><textarea id='admin_txt_area4' name='settings_admin[admin_txt_area4]' class='text_area'><?php echo $admin_template_contact_inquiry['admin_txt_area4'];?></textarea><p class='description'><span>Enter Message Format</span></p></td>
                             </tr>
                             <tr>
                                     <td align='left' scope='row' width='15%'><label style='margin-left:20px;'>Placeholder<span class="star">*</span></label></td>
                                     <td align='left' scope='row'>
                                     <ol class='admin_fourth_ol' style='position:relative;bottom:14px;slist-style-type: circle;font-weight:bold;' id="Placeholder_ol"><li>[shop_name]</li>
                                     <li>[shop_domain]</li>
                                     <li>[customer_name]</li>
                                     <li>[customer_email]</li>
                                     <li>[customer_message]</li>
                                     </ol>
                                     <p class='description'><span>Select placeholder</span></p>
                                     </td>
                             </tr>
                             <tr>
								<td align="left" scope="row" width="15%"><label style="margin-left:20px;">Mobile Number<span class="star">*</span></label> </td>
                                <td align="left" scope="row">
                                <input type="text" name="settings_admin[admin_txt_contact4]" id="admin_txt_contact4" class="sms_text" value="<?php echo $admin_template_contact_inquiry['admin_txt_contact4'];?>" size="55"/>
                                 <input type="button" name="sign_up_sms" id="preview" class="button-primary sms my-button" value="Preview SMS" style="margin-left:20px; border-radius: 7px; height: 37px;" onclick="get_popup('element_to_pop_up9')"/>  <input type="button" name="admin_order_changed" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                  </p>
                                   <div id="element_to_pop_up" class="element_to_pop_up9">
                                 <a class="b-close" style="font-size: 20px;">X<a/>
                         <h3>Message Preview</h3>
                         <textarea  style="height: 200px;width: 100%;"><?php  echo $admin_template_contact_inquiry['admin_txt_area4'];?></textarea>
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
            	 <div class="filter_div">
               <?php
				 global $wpdb;
				 $page_per_record			=	4;
				 $current_page				=   0;
				 $page_number				=	null;
				 $table_history	    		=   $wpdb->prefix . 'smscountry_history';
			     $total_pages				= 	0;
				 $from_date_for_sticky_value=	null;
				 $to_date_for_sticky_value	=	null;
				 $option_sticky_value		=	null;
			     $option_value				=	'Select option';
				 $count						=	0;
				 //$record_not_found			=	null;
				 if(isset($_GET['page_number']))
				{
					 $page_number=$_GET['page_number']-1;
					 $current_page=$page_number*$page_per_record;
					 $count=$current_page;
				}
				
				/****** Code for search option with pagination********/	
				 if(isset($_POST['search']))
				 {
						$message_type				=	$_POST['select_option'];
						$from_date					=	$_POST['search_from_date'];
						$to_date					=	$_POST['search_to_date'];
                        $from_date_for_sticky_value	=   $_POST['search_from_date'];
						$to_date_for_sticky_value	=	$_POST['search_to_date'];
						$option_sticky_value		=	$_POST['select_option'];
						 
						 
						 //=============query for getting all the records======//
						 
						 if($from_date=="" && $to_date=="")
						 {
							 $get_search_records=$wpdb->get_results("SELECT * FROM `$table_history` WHERE `sms_flag`='$message_type' ORDER BY `sms_id` DESC limit $current_page,$page_per_record");
						
							 $get_search_records_for_pagination= $wpdb->get_results("SELECT * FROM `$table_history` WHERE `sms_flag`='$message_type' ORDER BY `sms_id` DESC"); 
						 }
						 else
						 {
							 
							 $get_search_records=$wpdb->get_results("SELECT * FROM `$table_history` WHERE `sms_flag`='$message_type' AND date(`date_time`) BETWEEN '$from_date' AND '$to_date' ORDER BY `sms_id` DESC limit $current_page,$page_per_record");
						
							 $get_search_records_for_pagination= $wpdb->get_results("SELECT * FROM `$table_history` WHERE `sms_flag`='$message_type' AND date(`date_time`) BETWEEN '$from_date' AND '$to_date' ORDER BY `sms_id` DESC"); 
						 }
					    
								
						$total_record=$wpdb->num_rows;
						$total_pages=ceil($total_record/$page_per_record);
						 
				 }	
				
				/****** Code for when search is done with pagination********/	
				 else if(isset($_GET['option']))
				  {
						$from_date	= 	$_GET['from_date'];
						$to_date	=	$_GET['to_date'];
						$message_type=	$_GET['option'];
						$from_date_for_sticky_value	=   $from_date;
						$to_date_for_sticky_value	=	$to_date;
						$option_sticky_value		=	$message_type;
							
						
						if($from_date=="" && $to_date=="")
						 {
							 $get_search_records=$wpdb->get_results("SELECT * FROM `$table_history` WHERE `sms_flag`='$message_type' ORDER BY `sms_id` DESC limit $current_page,$page_per_record");
						
							$get_search_records_for_pagination= $wpdb->get_results("SELECT * FROM `$table_history` WHERE `sms_flag`='$message_type' ORDER BY `sms_id` DESC"); 
						 }
						 else
						 {
							 $get_search_records=$wpdb->get_results("SELECT * FROM `$table_history` WHERE `sms_flag`='$message_type' AND date(`date_time`) BETWEEN '$from_date' AND '$to_date' ORDER BY `sms_id` DESC limit $current_page,$page_per_record");
						
							 $get_search_records_for_pagination= $wpdb->get_results("SELECT * FROM `$table_history` WHERE `sms_flag`='$message_type' AND date(`date_time`) BETWEEN '$from_date' AND '$to_date' ORDER BY `sms_id` DESC"); 
						 }
						
						
						
						$total_record=$wpdb->num_rows;
						$total_pages=ceil($total_record/$page_per_record);
												
				  }	 
				  

				/****** Code for when swithout search with pagination********/	
				  else
				  
				  {
					  $number_of_rows = $wpdb->get_results("select * from `$table_history` ORDER BY `sms_id` DESC limit  $current_page,$page_per_record");   
					  $total_rows=$wpdb->get_results("select * from `$table_history` ORDER BY `sms_id` DESC");
					  $total_record=$wpdb->num_rows;
					  $total_pages=ceil($total_record/$page_per_record);
							
				  }
				  
				  
				  /********* code for sticky option value**********/
				  switch($option_sticky_value)
				  {
					  case 'user_signup':
					  	$option_value='Sign Up';
						break;
					  
					  case 'sign_up_verify_user':
					  	$option_value='Sign up Verification';
						break;
						
					  case 'user_new_order':
					  	$option_value='New Order Placed';
						break;
						
					  case 'user_refund':
					  	$option_value='Return Order';
						break;
						
					  case 'user_order_status':
					  	$option_value='New Order Placed';
						break;
						
					  case 'admin_signup':
					  	$option_value='Sign up';
						break;
						
					  case 'admin_new_order':
					  	$option_value='New Order SMS';
						break;
					   
					   case 'admin_refund':
					  	$option_value='Return Order';
						break;
						
					   case 'admin_contact':
					  	$option_value='Contact Enquiry';
						break;			 			
				  }
				 ?> 
                  
                 
                   <form method="POST" name="woocommerce_SMSCountry_syncSettings_section" action="?page=woocommerce-cb-import&tab=sms_history">
                          
                            <label>Message Type:</label>&nbsp;&nbsp;&nbsp;
                            <select name="select_option" id="webmenu" value="">
                                    <option value="<?=$option_sticky_value?>"><?=$option_value;?></option>
                                    <option value="" style="background-color:#999;color:white;" disabled="disabled">**User template**</option>
                                    <option value="user_signup">Sign up</option>
                                    <option value="sign_up_verify_user">Sign up Verification</option>
                                    <option value="user_new_order">New Order Placed</option>
                                    <option value="user_refund">Return Order</option>
                                    <option value="user_order_status">New Order Placed</option>
                                    <option value="" style="background-color:#999;color:white;" disabled="disabled">**Admin tamplate**</option>
                                    <option value="admin_signup">Sign up</option>
                                    <option value="admin_new_order">New Order SMS</option>
                                    <option value="admin_refund">Return Order</option>
                                    <option value="admin_contact">Contact Enquiry</option>
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp; 
                            <label>From Date:</label>
                            <input type="text" name="search_from_date" value="<?=$from_date_for_sticky_value?>" id="datetimepicker"/>
                            &nbsp;&nbsp;&nbsp;&nbsp; 
                            <label>To Date:</label>
                            <input type="text" name="search_to_date" value="<?=$to_date_for_sticky_value?>" id="datetimepicker1"/>
                        
                            <input type="submit" name="search" class='button-primary search' value="Search"/> 			
                           
                  </form>
                </div>
	             <table class="history_logs">
                      
                      <thead>
                        <tr>
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
						if(isset($_POST['search']))
						{
						
							foreach($get_search_records as $search_retrived_data)
							{
								$count+=1;
							 ?>
								  
							 <tr>
							  <td><?=$count?></td>
							  <td><strong><?= $search_retrived_data->date_time;?></strong></td>
							  <td><?= $search_retrived_data->message_text;?></td>
							  <td>1</td>
							  <td><?= $search_retrived_data->message_type;?></td>
							  <td><?= $search_retrived_data->message_status;?></td>
							  <td><?= $search_retrived_data->mobile_no;?></td>
							</tr>
						  
						   <?php
							}
						}
						else if(isset($_GET['option']))
						{
						
							foreach($get_search_records as $search_retrived_data)
							{
								$count+=1;
							 ?>
								  
							 <tr>
							  <td><?=$count?></td>
							  <td><strong><?= $search_retrived_data->date_time;?></strong></td>
							  <td><?= $search_retrived_data->message_text;?></td>
							  <td>1</td>
							  <td><?= $search_retrived_data->message_type;?></td>
							  <td><?= $search_retrived_data->message_status;?></td>
							  <td><?= $search_retrived_data->mobile_no;?></td>
							</tr>
						  
						   <?php
							}
							
						}
						
						else
						{  
						   
							foreach($number_of_rows as $retrived_data)
							{
								$count+=1;
							 ?>
								  
							 <tr>
							  <td><?=$count?></td>
							  <td><strong><?= $retrived_data->date_time;?></strong></td>
							  <td><?= $retrived_data->message_text;?></td>
							  <td>1</td>
							  <td><?= $retrived_data->message_type;?></td>
							  <td><?= $retrived_data->message_status;?></td>
							  <td><?= $retrived_data->mobile_no;?></td>
							</tr>
						  
						   <?php
							}
                         }
                          
                        ?>
                       </tbody>
                    </table>
                    
                    <?php
				    	 echo "<center class='pagination_center'><p><a href='#' id='prev'>Prev</a>"; 
							 $page_number+=1;
							 for($anchor_count=1;$anchor_count<=$total_pages;$anchor_count++)
							 {
								if(isset($_POST['search']))
								{
									 if($page_number==$anchor_count)
									 {
										
										 echo "<a class='selected_anchor' id='pagination_anchor' href='$current_url&page_number=$anchor_count&from_date=$from_date&option=$message_type&to_date=$to_date'> $anchor_count </a>";
									 }
									 else
									 {
										 echo "<a id='pagination_anchor' href='$current_url&page_number=$anchor_count&from_date=$from_date&option=$message_type&to_date=$to_date'> $anchor_count </a>";
									 }
								} 
								
								else if(isset($_POST['option']))
								{
									if($page_number==$anchor_count)
									 {
										
										 echo "<a class='selected_anchor' id='pagination_anchor' href='$current_url&page_number=$anchor_count&from_date=$from_date&option=$message_type&to_date=$to_date'> $anchor_count </a>";
									 }
									 else
									 {
										 echo "<a id='pagination_anchor' href='$current_url&page_number=$anchor_count&from_date=$from_date&option=$message_type&to_date=$to_date'> $anchor_count </a>";
									 }
	
								}
								
								else
								{
									 if($page_number==$anchor_count)
									 {
										 echo "<a class='selected_anchor' id='pagination_anchor' href='$current_url&page_number=$anchor_count' > $anchor_count </a>";
									 }
									 else
									 {
										 echo "<a id='pagination_anchor' href='$current_url&page_number=$anchor_count'> $anchor_count </a>";
									 }
								     
								}
							 }
							  echo "<a href='#' id='next'>Next</a>";
							  echo "</center></p>";
						
					?>
                    <div class="not_found_div"></div>
                    
              </div>
        </div>
     
     
      <?php
   }
}
?>
 
  </div>
</div>
