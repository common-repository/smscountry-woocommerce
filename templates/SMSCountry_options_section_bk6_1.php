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

	if ( isset( $_POST['save'] ) ) {
	   
	   if(isset($_POST['settings-gen-submit'])) {
		   if($_POST['settings-gen-submit'] == 'Y') {
			   WC_SMSCountry::get_instance()->do_gensettings_actions( $_GET['page'],$_POST );
		   }
	   }
	   
	 /*  if(isset($_POST['apisetting-submit'])) {
		  
		   if($_POST['apisetting-submit'] == 'Y') {
			   WC_SMSCountry::get_instance()->do_apisettings_actions( $_GET['page'],$_POST );
		   }
	   }*/
	   
	   if(isset($_POST['settings-user_template'])) {
		 
		   if($_POST['settings-user_template']) {
			 	WC_SMSCountry::get_instance()->do_usertemplate_actions( $_GET['page'],$_POST,$_POST['settings-user_template']);
		   }
	   }
	   
	    if(isset($_POST['settings-admin_template'])) {
			
		   if($_POST['settings-admin_template']) {
				WC_SMSCountry::get_instance()->do_admintemplate_actions( $_GET['page'],$_POST,$_POST['settings-admin_template']);
		   }
	   }
	   
	}
	
	
	/** Get the plugin settings */
    $settings_general     = get_option( 'woocommerce_SMSCountry_settings_general' );
	
	$settings    = $s = get_option( 'woocommerce_SMSCountry_settings' );
	
	
	$user_template_sign_up= get_option( 'woocommerce_user_template_sign_up' );
	$user_template_sign_verify= get_option( 'woocommerce_user_template_verification' );
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
                <td align="left" scope="row" width="15%"><label style="margin-left:20px;">API URI</label></td>
                <td align="left" scope="row"><input type="text" name="settings_general[api_name]" id="api_name" value="<?php echo @$settings_general['api_name'];?>" size="55"/>
                  <p class="description">
                    <?php _e( 'Enter API URI.', 'woocommerce_SMSCountry' ); ?>
                  </p></td>
              </tr>
              <tr>
                <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Username</label></td>
                <td align="left" scope="row"><input type="text" name="settings_general[txt_username]" id="general_username" value="<?php echo @$settings_general['txt_username'];?>" size="55"/>
                  <p class="description">
                    <?php _e( 'Enter Username.', 'woocommerce_SMSCountry' ); ?>
                  </p></td>
              </tr>
              <tr>
                <td align="left" scope="row" width="15%"><label style="margin-left:20px;">Password</label></td>
                <td align="left" scope="row"><input type="password" name="settings_general[txt_password]" id="txt_password" value="<?php echo @$settings_general['txt_password'];?>" size="55" />
                  <p class="description">
                    <?php _e( 'Enter Password.', 'woocommerce_SMSCountry' ); ?>
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
        
        <div style="border:1px solid black;background-color:white;border-radius:5px 5px;">
           <div id="div1">
                <ul id="tabs_li">
                
                    <li ><input type="button" id="btn1" class="button-primary"  value="1. Sign Up"/>
			        </li>
                    <li><input type="button" id="btn2" class="button-primary"  value="2. Sign Up Verification"/></a>
                    </li>
                    <li ><input type="button" id="btn3" class="button-primary"  value="3. Return Order"/>
                    </li>
                    <li ><input type="button" id="btn4" class="button-primary" value="4. Order Status Changed"/>
                    </li>
                </ul>
           </div>
           
           <!-----User First table------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div')">
           <div class="table_div">


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
                         <input type="button" name="sign_up_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                        <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
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
           <div class="table_div2" style="display:none;">
           		 
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
                         <input type="button" name="sign_up_verification_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                        <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                          
                       
                     </tr>
                     <tr>
                         <td></td>
                         <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings'/><input type='hidden' name='settings-user_template' value='verification' /></p>
                         </td>
                     </tr>
                 </table>

           </div>
           </form>
           
           <!------Third table for return order------->
           <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div3')">
           <div class="table_div3" style="display:none;">
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
                             <li>[customer country]</li>
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
                         <input type="button" name="order_return_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                        <p class="description">
                            <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                          </p></td>
                          
                             
                     </tr>
                     <tr>
                             <td></td>
                             <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings'/><input type='hidden' name='settings-user_template' value='return_order' /></p></td>
                     </tr>
                     </table>
                             
           </div>
           </form>

		<!------------Fourth table for Order Changed------------------->  
          
         <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div4')">
           <div class="table_div4" style="display:none;">
           		
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
                             <input type="button" name="order_changed_sms" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                            <p class="description">
                                <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                              </p></td>
                             
                            
                     </tr>
                     <tr>
                             <td></td>
                             <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-user_template' value='order_changed' /></p></td>
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

        <h2>
          <?php _e( 'User Template', 'woocommerce_SMSCountry' ); ?>
        </h2>
        <div style="border:1px solid black;background-color:white;border-radius:5px 5px;">
           <div id="div1">
                <ul id="tabs_li">
                    
                    <li ><input type="button" id="btn_admin1" class="button-primary" value="1. Sign Up"/>
                    </li>
                    </li>
                    <li><input type="button" id="btn_admin2" class="button-primary"  value="2. Order SMS Alert"/></a>
                    </li>
                    <li ><input type="button" id="btn_admin3" class="button-primary" value="3. Return Order"/>
                    </li>
                    <li ><input type="button" id="btn_admin4" class="button-primary" value="4. Contact Inquiry"/>
                    </li>
                   
                </ul>
           </div>
           
           
         
            <div class="table_div9">
                          <h2 class="nav-tab-wrapper">
                              <a class='nav-tab nav-tab-active' href="#" id="tab_admin">Sign up</a>
                              <a class='nav-tab nav-tab-active' href="#" id="tab_admin1">Sign Up history</a>
                         </h2>
            </div>
            
           <!---------------Admin first table------------------>   
          <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div5')">
                   
                   
                   <div class="table_div5">
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
                                     <input type="button" name="admin_sign_up" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                    <p class="description">
                                        <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                      </p></td>
                          
                                
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
                                 <input type="button" name="admin_sign_up_history" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                          
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
                   <div class="table_div6" style="display:none;">
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
                                     <li>[customer country]</li>
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
                                 <input type="button" name="admin_sms_alert" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                                     
                                      
                             </tr>
                             <tr>
                                     <td></td>
                                     <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-admin_template' value='sms_alert' /></p>
                                     </td>
                             </tr>
                             </table>
                     </div>
             </form> 
             
             
             
              <!---------------Admin Third table------------------>
             
             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div7')">
                   <div class="table_div7" style="display:none;">
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
                                 <input type="button" name="admin_order_return" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                             
                         
                             </tr>
                             <tr>
                                     <td></td>
                                     <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-admin_template' value='return_order' /></p></td>
                             </tr>
                        </table>	   
                   </div>
             </form> 
             
              <!---------------Admin Fourth table------------------>
             
             <form method="post" name="woocommerce_SMSCountry_syncSettings_section" action="<?php echo $current_url; ?>" onsubmit="return validate('table_div8')">
                   <div class="table_div8" style="display:none;" >
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
                                 <input type="button" name="admin_order_changed" id="save" class="button-primary sms" value="Test SMS" style="margin-left:20px;"/>
                                <p class="description">
                                    <?php _e( 'Enter Mobile Number.', 'woocommerce_SMSCountry' ); ?>
                                  </p></td>
                              					                             
                             
                             
                              </tr>
                             <tr>
                                     <td></td>
                                     <td><p class='submit' style='clear: both;'><input type='submit' name='save' id='save' class='button-primary' value='Save Settings' /><input type='hidden' name='settings-admin_template' value='contact_inquiry' /></p>
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
            	<?php 
				
				
				?>
                <table class="history_logs">
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Date/Time</th>
                          <th>Message Text</th>
                          <th>Message Character Count</th>
                          <th class="th5">Name Of Recipient</th>
                          <th>Number Of Recipient</th>
                          <th>Type Of Message</th>
                          <th>Message Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td><strong>Date1</strong></td>
                          <td>message....</td>
                          <td>23</td>
                          <td>Machindra zankar</td>
                          <td>4</td>
                          <td>Order Alert</td>
                          <td>Delivered</td>
                        </tr>
                        </tr>
                        <tr>
                          <tr>
                          <td>2</td>
                          <td><strong>Date1</strong></td>
                          <td>message....</td>
                          <td>23</td>
                          <td>Pawan Potdar </td>
                          <td>4</td>
                          <td>Customer Registration</td>
                          <td>Pending</td>
                        </tr>
                        <tr>
                          <tr>
                          <td>3</td>
                          <td><strong>Date1</strong></td>
                          <td>message....</td>
                          <td>23</td>
                          <td>Pawan Potdar</td>
                          <td>4</td>
                          <td>Customer Registration</td>
                          <td>Pending</td>
                        </tr>
                        
                        </tbody>
                    </table>
                                
            
            </div>
        </div>
     
     
      <?php
   }
}
?>
 
  </div>
</div>
