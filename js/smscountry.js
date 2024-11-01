//alert("dsfs");
var __sms = jQuery.noConflict();
__sms(document).ready(function(){
	//alert("dsfs");
	var todayTimeStamp = +new Date; // Unix timestamp in milliseconds
	var oneDayTimeStamp = 1000 * 60 * 60 * 48; // Milliseconds in a day
	var diff = todayTimeStamp - oneDayTimeStamp;
	var yesterdayDate = new Date(diff);
	var twoDigitMonths = ((yesterdayDate.getMonth() + 1) === 1)? (yesterdayDate.getMonth() + 1) : '0' + (yesterdayDate.getMonth() + 1);
	var yesterdayString = yesterdayDate.getFullYear() + '-' + twoDigitMonths + '-' + yesterdayDate.getDate();
	
	
	var fullDate = new Date();
	//console.log(fullDate);
	var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
	var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
	//console.log(currentDate);
	//alert(currentDate);
	
	__sms(".date_from_txt").val(yesterdayString);
	__sms(".date_to_txt").val(currentDate);
	
	
	
	//alert("sdsadsad");
	//==========Add datepicker=========//
		__sms('.datetimepicker').datetimepicker({
			 i18n:{
			  de:{
			   months:[
				'Januar','Februar','März','April',
				'Mai','Juni','Juli','August',
				'September','Oktober','November','Dezember',
			   ],
			   dayOfWeek:[
				"So.", "Mo", "Di", "Mi", 
				"Do", "Fr", "Sa.",
			   ]
			  }
			 },
			 timepicker:false,
			 format:'Y-m-d',
			 setDate: 15,			
		});
		
		/*var d = new Date();
		var currentDate 	= d.getFullYear() + '-'  +
					(month<10 ? '0' : '') + month + '-' +
					(day<10 ? '0' : '') + day;
				today_date			=	currentDate.split("-");
				
		var previusDate=d.getFullYear() + '-' +
					(month<10 ? '0' : '') + month + '-' +
					(day<10 ? '0' : '') + d.getDate()-2;
		alert(previusDate)		
		alert(currentDate)
		__sms(".datetimepicker").val(previusDate)	*/	
    //======for checkbox=======//
  	    var checkBox = __sms('.check_css');
        __sms(checkBox).each(function(){
            __sms(this).wrap( "<span class='custom-checkbox'></span>" );
            if(__sms(this).is(':checked')){
                __sms(this).parent().addClass("selected");
            }
        });
        __sms(checkBox).click(function(){
            __sms(this).parent().toggleClass("selected");
        });
     
	 	__sms("#tab_admin_sign_up_history").css("background-color","#CCC");
        
	//======Mouse Over Effect For PlaceHolder====//
	 
		__sms('#placeholder_ol li').mouseover(function(){
			__sms(this).css('color','blue');
			__sms(this).css( 'cursor', 'pointer');
		});
		__sms('#placeholder_ol li').mouseout(function(){
			__sms(this).css('color','');
		});
	
	//===when mouse is clicked on the section tabs====//
	//===button for user template=========//
	 __sms("#btn_user_sign_up").click(function(){
		 __sms(".table_div").show();
		 __sms(".table_div2").hide();
		 __sms(".table_div3").hide();
		 __sms(".table_div4").hide();
		 __sms(".table_div10").hide();
		 __sms(".table_div_sign_up_existing").hide();
		 __sms(".table_div_new_order").hide();	
		 __sms(this).addClass('blue');
		  __sms("#btn_user_checkout").removeClass("blue");
	 	 __sms("#btn_user_sign_up_verify").removeClass("blue");
		 __sms("#btn_user_sign_up_verify_existing").removeClass("blue");
		 __sms("#btn_user_return_order").removeClass("blue"); ;
		 __sms("#btn_user_order_status_changed").removeClass("blue"); 
		 __sms("#btn_user_new_order").removeClass("blue"); 
	 });
		 
	 __sms("#btn_user_sign_up_verify").click(function(){
	    __sms(".table_div9").hide();
		__sms(".table_div").hide();
		__sms(".table_div2").show();
		__sms(".table_div_sign_up_existing").hide();
		__sms(".table_div3").hide();
		__sms(".table_div4").hide();
		 __sms(".table_div10").hide();
		__sms(".table_div_new_order").hide();
	     __sms("#btn_user_checkout").removeClass("blue");
		__sms(this).addClass('blue');
		__sms("#btn_user_sign_up").removeClass("blue");
		__sms("#btn_user_return_order").removeClass("blue"); 
		__sms("#btn_user_sign_up_verify_existing").removeClass("blue");
		__sms("#btn_user_order_status_changed").removeClass("blue"); 
		__sms("#btn_user_new_order").removeClass("blue"); 
	 });
	
	 __sms("#btn_user_sign_up_verify_existing").click(function(){
	    __sms(".table_div9").hide();
		__sms(".table_div").hide();
		__sms(".table_div2").hide();
		__sms(".table_div_sign_up_existing").show();
		__sms(".table_div3").hide();
		__sms(".table_div4").hide();
		__sms(".table_div10").hide();
		__sms(".table_div_new_order").hide();	
		__sms(this).addClass('blue');
		__sms("#btn_user_checkout").removeClass("blue");
		__sms("#btn_user_sign_up").removeClass("blue");
		__sms("#btn_user_return_order").removeClass("blue");
		__sms("#btn_user_sign_up_verify").removeClass("blue"); 
		__sms("#btn_user_order_status_changed").removeClass("blue"); 
		__sms("#btn_user_new_order").removeClass("blue"); 
	 });
	
	 __sms("#btn_user_new_order").click(function(){
		__sms(".table_div9").hide();
		__sms(".table_div").hide();
		__sms(".table_div2").hide();
		__sms(".table_div3").hide();
		__sms(".table_div4").hide();
		 __sms(".table_div10").hide();
		__sms(".table_div_sign_up_existing").hide();
		__sms(".table_div_new_order").show();	
		__sms(this).addClass('blue');
		__sms("#btn_user_checkout").removeClass("blue");
		__sms("#btn_user_sign_up").removeClass("blue");
		__sms("#btn_user_sign_up_verify").removeClass("blue");
		__sms("#btn_user_sign_up_verify_existing").removeClass("blue");
		__sms("#btn_user_return_order").removeClass("blue"); 
		__sms("#btn_user_order_status_changed").removeClass("blue"); 
    });
	
	 __sms("#btn_user_return_order").click(function(){
		 __sms(".table_div9").hide();
		 __sms(".table_div3").show();
		 __sms(".table_div2").hide();
		 __sms(".table_div").hide();
		 __sms(".table_div10").hide();
		 __sms(".table_div_sign_up_existing").hide();
		 __sms(".table_div_new_order").hide();
		 __sms(".table_div4").hide();
		 __sms(this).addClass('blue');
		 __sms("#btn_user_checkout").removeClass("blue");
		 __sms("#btn_user_sign_up").removeClass("blue");
		 __sms("#btn_user_sign_up_verify").removeClass("blue"); 
		 __sms("#btn_user_sign_up_verify_existing").removeClass("blue");
		 __sms("#btn_user_order_status_changed").removeClass("blue"); 
		 __sms("#btn_user_new_order").removeClass("blue"); 
	 });	
		
	 __sms("#btn_user_order_status_changed").click(function(){
		 __sms(".table_div9").hide();
		 __sms(".table_div4").show();
		 __sms(".table_div2").hide();
		 __sms(".table_div3").hide();
		 __sms(".table_div").hide();
		 __sms(".table_div10").hide();
		 __sms(".table_div_sign_up_existing").hide();
		 __sms(".table_div_new_order").hide();
		 __sms(this).addClass('blue');
		  __sms("#btn_user_checkout").removeClass("blue");
		 __sms("#btn_user_sign_up").removeClass("blue"); 
		 __sms("#btn_user_sign_up_verify").removeClass("blue");
		 __sms("#btn_user_sign_up_verify_existing").removeClass("blue");
		 __sms("#btn_user_return_order").removeClass("blue");
		 __sms("#btn_user_new_order").removeClass("blue"); 
	  });	
	  
	   __sms("#btn_user_checkout").click(function(){
		 __sms(".table_div9").hide();
		 __sms(".table_div4").hide();
		 __sms(".table_div2").hide();
		 __sms(".table_div3").hide();
		 __sms(".table_div").hide();
		 __sms(".table_div10").show();
		 __sms(".table_div_sign_up_existing").hide();
		 __sms(".table_div_new_order").hide();
		 __sms(this).addClass("blue");	
		 __sms("#btn_user_order_status_changed").removeClass("blue"); 
		 __sms("#btn_user_sign_up").removeClass("blue"); 
		 __sms("#btn_user_sign_up_verify").removeClass("blue");
		 __sms("#btn_user_sign_up_verify_existing").removeClass("blue");
		 __sms("#btn_user_return_order").removeClass("blue");
		 __sms("#btn_user_new_order").removeClass("blue"); 
		
	 });
	  //======btn for admin template
	  __sms("#btn_admin_sign_up").click(function(){
		 __sms(".table_div9").show(); 
		 __sms(".table_history").hide();
		 __sms(".table_div5").show();
		 __sms(".table_div6").hide();
		 __sms(".table_div7").hide();
		 __sms(".table_div8").hide();
		 __sms(this).addClass('blue');
		 __sms("#tab_admin_sign_up_history").css("background-color","#CCC");
		 __sms("#tab_admin_sign_up").css("background-color","white");
	 	 __sms("#btn_admin_order_sms_alert").removeClass("blue");
		 __sms("#btn_admin_return_order").removeClass("blue"); 
		 __sms("#btn_admin_contact_inquiry").removeClass("blue"); 
	  });
		 
	 __sms("#btn_admin_order_sms_alert").click(function(){
		 __sms(".table_div9").hide();
		 __sms(".table_history").hide();
		 __sms(".table_div6").show();
		 __sms(".table_div5").hide();
		 __sms(".table_div7").hide();
		 __sms(".table_div8").hide();
		 __sms(this).addClass('blue');
		 __sms("#btn_admin_sign_up").removeClass("blue");
		 __sms("#btn_admin_return_order").removeClass("blue"); 
		 __sms("#btn_admin_contact_inquiry").removeClass("blue"); 
	 });
	 
	 __sms("#btn_admin_return_order").click(function(){
		 __sms(".table_div9").hide();
		 __sms(".table_history").hide();
		 __sms(".table_div7").show();
		 __sms(".table_div5").hide();
		 __sms(".table_div6").hide();
		 __sms(".table_div8").hide();
		 __sms(this).addClass('blue');
		 __sms("#btn_admin_sign_up").removeClass("blue");
		 __sms("#btn_admin_order_sms_alert").removeClass("blue"); 
		 __sms("#btn_admin_contact_inquiry").removeClass("blue"); 
	 });	
		
	 __sms("#btn_admin_contact_inquiry").click(function(){
		 __sms(".table_div9").hide();
		 __sms(".table_history").hide();
		 __sms(".table_div8").show();
		 __sms(".table_div5").hide();
		 __sms(".table_div6").hide();
		 __sms(".table_div7").hide();
		 __sms(this).addClass('blue');
		 __sms("#btn_admin_sign_up").removeClass("blue"); 
		 __sms("#btn_admin_order_sms_alert").removeClass("blue");
		 __sms("#btn_admin_return_order").removeClass("blue");
	  });
	 
	  
	 __sms("#tab_admin_sign_up").click(function(){
         __sms(".table_div5").show();
	     __sms(".table_history").hide();
	     __sms("#tab_admin_sign_up_history").css("background-color","#CCC");
	     __sms(this).css("background-color","white");
	 });
	
	 __sms("#tab_admin_sign_up_history").click(function(){
		__sms(".table_div5").hide();
		__sms(".table_history").show();
		__sms("#tab_admin_sign_up").css("background-color","#CCC");
		__sms(this).css("background-color","white");
		__sms(".table_div5").css("positopn")
	 });
	
	
	 
	//==========Functions for Add placeholder to the textarea ======// 
	 
	 //==========USER SIDE==================//
	__sms(".user_first_ol li").click(function(){
		  var text=__sms(this).text()+" ";
		  __sms("#txt_area1").val(__sms("#txt_area1").val() + text);
		  __sms("#txt_area1").focus()
	});
		
	__sms(".user_second_ol li").click(function(){
		  var text=__sms(this).text()+" ";
		  __sms("#txt_area2").val(__sms("#txt_area2").val() + text);
		  __sms("#txt_area2").focus()
	});
	
	__sms(".user_sing_up_exists_ol li").click(function(){
		  var text=__sms(this).text()+" ";
		  __sms("#txt_area_sing_up_exists").val(__sms("#txt_area_sing_up_exists").val() + text);
		  __sms("#txt_area_sing_up_exists").focus()
	});
	
	__sms(".user_new_order_ol li").click(function(){
		  var text=__sms(this).text()+" ";
		  __sms("#txt_area_new_order").val(__sms("#txt_area_new_order").val() + text);
		  __sms("#txt_area_new_order").focus()
		});
			
	__sms(".user_third_ol li").click(function(){
		  var text=__sms(this).text()+" ";
		  __sms("#txt_area3").val(__sms("#txt_area3").val() + text);
		  __sms("#txt_area3").focus()
		});	
	
	__sms(".user_fourth_ol li").click(function(){
		  var text=__sms(this).text()+" ";
		  __sms("#txt_area4").val(__sms("#txt_area4").val() + text);
		  __sms("#txt_area4").focus()
		});	
		
	__sms(".user_checkout_ol li").click(function(){
		  var text=__sms(this).text()+" ";
		  __sms("#user_txt_checkout").val(__sms("#user_txt_checkout").val() + text);
		  __sms("#user_txt_checkout").focus()
	});		
		
	//==========ADMIN SIDE==================//
	__sms(".admin_first_ol li").click(function(){
		   var text=__sms(this).text()+" ";
		   __sms("#admin_txt_area").val(__sms("#admin_txt_area").val() + text);
		   __sms("#admin_txt_area").focus()
		});	
		
	__sms(".admin_second_ol li").click(function(){
		   var text=__sms(this).text()+" ";
		   __sms("#admin_txt_area2").val(__sms("#admin_txt_area2").val() + text);
		   __sms("#admin_txt_area2").focus()
		});		
		
	__sms(".admin_third_ol li").click(function(){
		   var text=__sms(this).text()+" ";
		   __sms("#admin_txt_area3").val(__sms("#admin_txt_area3").val() + text);
		   __sms("#admin_txt_area3").focus()
		});	
	
	__sms(".admin_fourth_ol li").click(function(){
		   var text=__sms(this).text()+" ";
		   __sms("#admin_txt_area4").val(__sms("#admin_txt_area4").val() + text);
		   __sms("#admin_txt_area4").focus()
		});
		
	__sms(".admin_first_ol1 li").click(function(){
		  var text=__sms(this).text()+" ";
		  __sms("#history_txt_area").val(__sms("#history_txt_area").val() + text);
		  __sms("#history_txt_area").focus()
	});
		
	//=======code for when record does not exist in sms history table======//		
	if(__sms(".history_logs tbody tr").size()==0)
	{
		__sms(".not_found_div").html("<h1 class='not_found'>Record Not found........</h1>");	
		__sms(".pagination_center").remove();
	}
	
	//==========prev.next button functionality=====//
	__sms("#next").click(function(){
		var page_url=__sms(".selected_anchor").next().attr("href");
		window.location = page_url;
	});
	
	__sms("#prev").click(function(){
		var page_url=__sms(".selected_anchor").prev().attr("href");
		window.location = page_url;
	});
		
	
});

//===========Mobile number validation in SMS Histroy tab=====//
function mobilenumber()
{
	var retvalue=true;
	
	 if(__sms(".txt_filter_mob").val()!="")
	 {
		 if (/^[\d]{10,13}$/.test(__sms(".txt_filter_mob").val())) {
			retvalue=true;
		 } 
		 else
		 {
			retvalue=false;
			alert("Plz Enter valid Contact")	;
		 }
	 }
	 return retvalue;
	
}	
	
//==========Validations for all the tables======//
function validate(string)
{
	
 	var retvalue=true;
    //========validation for input type==========//
	 __sms("."+string+" input").each(function(){
		  if(__sms(this).attr("type")=="text")
		  {
			 if(__sms(this).attr("class")!="sms_text")
			 {
				  if(__sms(this).val()=="")
				  { 
					retvalue=false;
					var errorString=__sms(this).parent().find("span").attr("id");
					__sms(this).parent().find("span").text(" Please Enter Correct "+errorString+ " !.");
				  }
				  else
				  {
					  __sms(this).parent().find("span").text("");
				  }
			 }
		  }
		 if(__sms(this).attr("type")=="password")
		  {
			 if(__sms(this).val()=="")
			  { 
				retvalue=false;
				var errorString=__sms(this).parent().find("span").attr("id");
				__sms(this).parent().find("span").text(" Please Enter Valid "+errorString+" !.");
				//__sms(this).css("border-color","red");
			  } 
			  else
			  {
				  __sms(this).parent().find("span").text("");
			  }
		  }
		__sms(this).keyup(function(){
			 __sms(this).css("border-color","green");
			 __sms("."+string).find("span").text("");
			});
		
       //============contact number validation=====//
		/*if(__sms(this).attr("class")=="sms_text")
		{
			if (/^\d{10}__sms/.test(__sms(this).val())) {
				__sms(this).css("border-color","green");
				
			} else {
				 __sms(this).css("border-color","red");
				 retvalue=false;
			} 
		}*/
		//==========contact number validation=====//
		if(__sms(this).attr("class")=="api_setting_mob" )
		{
			if (/^[\d]{10,13}$/.test(__sms(this).val())) {
				__sms(this).css("border-color","green");
				__sms(this).parent().find("span").text("");
				
			} else {
				 //__sms(this).css("border-color","red");
				
				 var errorString=__sms(this).parent().find("span").attr("id");
				 __sms(this).parent().find("span").text(" Please Enter Valid "+errorString+" !.");
				 retvalue=false;
			}
		}
		
		//==========Email Validation=========//
		if(__sms(this).attr("id")=="admin_email")
		{
			var userinput = __sms(this).val();
		
			var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
			var valid = emailRegex.test(userinput);
			if (!valid) {
				 var errorString=__sms(this).parent().find("span").attr("id");
				 __sms(this).parent().find("span").text(" Please Enter "+errorString+" !.");
				// __sms(this).css("border-color","red");
				 retvalue=false;	
			} 
			else
			{
				__sms(this).parent().find("span").text("");
			}
		}
		
		if(__sms(this).attr('type')=='checkbox')
		{
			if(__sms(this).is(":checked"))
			{
				__sms(this).val("active");
			}
		    else
			{
				__sms(this).val("inactive")
			}
		}
		if(__sms(this).attr('id')=='txt_sender_id')
		{
			if(__sms(this).val().length>11)
			{
				 var errorString=__sms(this).parent().find("span").attr("id");
				 __sms(this).parent().find("span").text(" Please Enter "+errorString+" !.");
				 //__sms(this).css("border-color","red");
				 retvalue=false;
			}
			
		}	
		
		
		
	  });
	  
    //========validation for textarea==========//	
	__sms("."+string+" textarea").each(function(){ 
	
	  if(!__sms("#element_to_pop_up textarea"))
	{
		  if(__sms(this).val()=="")
		  {
			 retvalue=false;
			 // __sms(this).parent().find("#txterror").text(" Please Enter MEsaage Format !");
			 __sms(this).css("border-color","red");
		  }
		  __sms(this).keyup(function(){
			__sms(this).css("border-color","green");
		  });
	}
		  
	 });
	

	return retvalue;
}
	  
//===========function for copy to clickboard====//
function copyToClipboard(element) {
  var __smstemp = __sms("<input>");
  __sms("body").append(__smstemp);
  __smstemp.val(__sms(element).val()).select();
  document.execCommand("copy");
  __smstemp.remove();
}

	
//===========pop up functionality==========//
  function get_popup(id)
  {
		__sms('.'+id).bPopup();
  }
		
(function(b){b.fn.bPopup=function(z,F){function K(){a.contentContainer=b(a.contentContainer||c);switch(a.content){case "iframe":var h=b('<iframe class="b-iframe" '+a.iframeAttr+"></iframe>");h.appendTo(a.contentContainer);r=c.outerHeight(!0);s=c.outerWidth(!0);A();h.attr("src",a.loadUrl);k(a.loadCallback);break;case "image":A();b("<img />").load(function(){k(a.loadCallback);G(b(this))}).attr("src",a.loadUrl).hide().appendTo(a.contentContainer);break;default:A(),b('<div class="b-ajax-wrapper"></div>').load(a.loadUrl,a.loadData,function(){k(a.loadCallback);G(b(this))}).hide().appendTo(a.contentContainer)}}function A(){a.modal&&b('<div class="b-modal '+e+'"></div>').css({backgroundColor:a.modalColor,position:"fixed",top:0,right:0,bottom:0,left:0,opacity:0,zIndex:a.zIndex+t}).appendTo(a.appendTo).fadeTo(a.speed,a.opacity);D();c.data("bPopup",a).data("id",e).css({left:"slideIn"==a.transition||"slideBack"==a.transition?"slideBack"==a.transition?g.scrollLeft()+u:-1*(v+s):l(!(!a.follow[0]&&m||f)),position:a.positionStyle||"absolute",top:"slideDown"==a.transition||"slideUp"==a.transition?"slideUp"==a.transition?g.scrollTop()+w:x+-1*r:n(!(!a.follow[1]&&p||f)),"z-index":a.zIndex+t+1}).each(function(){a.appending&&b(this).appendTo(a.appendTo)});H(!0)}function q(){a.modal&&b(".b-modal."+c.data("id")).fadeTo(a.speed,0,function(){b(this).remove()});a.scrollBar||b("html").css("overflow","auto");b(".b-modal."+e).unbind("click");g.unbind("keydown."+e);d.unbind("."+e).data("bPopup",0<d.data("bPopup")-1?d.data("bPopup")-1:null);c.undelegate(".bClose, ."+a.closeClass,"click."+e,q).data("bPopup",null);H();return!1}function G(h){var b=h.width(),e=h.height(),d={};a.contentContainer.css({height:e,width:b});e>=c.height()&&(d.height=c.height());b>=c.width()&&(d.width=c.width());r=c.outerHeight(!0);s=c.outerWidth(!0);D();a.contentContainer.css({height:"auto",width:"auto"});d.left=l(!(!a.follow[0]&&m||f));d.top=n(!(!a.follow[1]&&p||f));c.animate(d,250,function(){h.show();B=E()})}function L(){d.data("bPopup",t);c.delegate(".bClose, ."+a.closeClass,"click."+e,q);a.modalClose&&b(".b-modal."+e).css("cursor","pointer").bind("click",q);M||!a.follow[0]&&!a.follow[1]||d.bind("scroll."+e,function(){B&&c.dequeue().animate({left:a.follow[0]?l(!f):"auto",top:a.follow[1]?n(!f):"auto"},a.followSpeed,a.followEasing)}).bind("resize."+e,function(){w=y.innerHeight||d.height();u=y.innerWidth||d.width();if(B=E())clearTimeout(I),I=setTimeout(function(){D();c.dequeue().each(function(){f?b(this).css({left:v,top:x}):b(this).animate({left:a.follow[0]?l(!0):"auto",top:a.follow[1]?n(!0):"auto"},a.followSpeed,a.followEasing)})},50)});a.escClose&&g.bind("keydown."+e,function(a){27==a.which&&q()})}function H(b){function d(e){c.css({display:"block",opacity:1}).animate(e,a.speed,a.easing,function(){J(b)})}switch(b?a.transition:a.transitionClose||a.transition){case "slideIn":d({left:b?l(!(!a.follow[0]&&m||f)):g.scrollLeft()-(s||c.outerWidth(!0))-C});break;case "slideBack":d({left:b?l(!(!a.follow[0]&&m||f)):g.scrollLeft()+u+C});break;case "slideDown":d({top:b?n(!(!a.follow[1]&&p||f)):g.scrollTop()-(r||c.outerHeight(!0))-C});break;case "slideUp":d({top:b?n(!(!a.follow[1]&&p||f)):g.scrollTop()+w+C});break;default:c.stop().fadeTo(a.speed,b?1:0,function(){J(b)})}}function J(b){b?(L(),k(F),a.autoClose&&setTimeout(q,a.autoClose)):(c.hide(),k(a.onClose),a.loadUrl&&(a.contentContainer.empty(),c.css({height:"auto",width:"auto"})))}function l(a){return a?v+g.scrollLeft():v}function n(a){return a?x+g.scrollTop():x}function k(a){b.isFunction(a)&&a.call(c)}function D(){x=p?a.position[1]:Math.max(0,(w-c.outerHeight(!0))/2-a.amsl);v=m?a.position[0]:(u-c.outerWidth(!0))/2;B=E()}function E(){return w>c.outerHeight(!0)&&u>c.outerWidth(!0)}b.isFunction(z)&&(F=z,z=null);var a=b.extend({},b.fn.bPopup.defaults,z);a.scrollBar||b("html").css("overflow","hidden");var c=this,g=b(document),y=window,d=b(y),w=y.innerHeight||d.height(),u=y.innerWidth||d.width(),M=/OS 6(_\d)+/i.test(navigator.userAgent),C=200,t=0,e,B,p,m,f,x,v,r,s,I;c.close=function(){a=this.data("bPopup");e="__b-popup"+d.data("bPopup")+"__";q()};return c.each(function(){b(this).data("bPopup")||(k(a.onOpen),t=(d.data("bPopup")||0)+1,e="__b-popup"+t+"__",p="auto"!==a.position[1],m="auto"!==a.position[0],f="fixed"===a.positionStyle,r=c.outerHeight(!0),s=c.outerWidth(!0),a.loadUrl?K():A())})};b.fn.bPopup.defaults={amsl:50,appending:!0,appendTo:"body",autoClose:!1,closeClass:"b-close",content:"ajax",contentContainer:!1,easing:"swing",escClose:!0,follow:[!0,!0],followEasing:"swing",followSpeed:500,iframeAttr:'scrolling="no" frameborder="0"',loadCallback:!1,loadData:!1,loadUrl:!1,modal:!0,modalClose:!0,modalColor:"#000",onClose:!1,onOpen:!1,opacity:0.7,position:["auto","auto"],positionStyle:"absolute",scrollBar:!0,speed:250,transition:"fadeIn",transitionClose:!1,zIndex:9997}})(jQuery);
