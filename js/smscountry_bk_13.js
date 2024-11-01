$(document).ready(function(){
	
	
	//==========Add datepicker=========//
	$('#datetimepicker').datetimepicker({
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
		 format:'Y-m-d'
		});
	
	$('#datetimepicker1').datetimepicker({
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
		  format:'Y-m-d'
		});	
	
	  //======for checkbox=======//
      var checkBox = $('input[type="checkbox"]');
        $(checkBox).each(function(){
            $(this).wrap( "<span class='custom-checkbox'></span>" );
            if($(this).is(':checked')){
                $(this).parent().addClass("selected");
            }
        });
        $(checkBox).click(function(){
            $(this).parent().toggleClass("selected");
        });
     
	   
		
		$("#btn1").addClass("blue"); 
		$("#btn_admin1").addClass("blue"); 
		$("#tab_admin1").css("background-color","#CCC");
        
	//======Mouse Over Effect For PlaceHolder====//
	 
		$('#placeholder_ol li').mouseover(function(){
			$(this).css('color','blue');
			$(this).css( 'cursor', 'pointer');
		});
		
		$('#placeholder_ol li').mouseout(function(){
			
			$(this).css('color','');
		
		});
	
	
	//===when mouse is clicked on the section tabs====//
	 $("#btn1").click(function(){
		 
		 $(".table_div").show();
		 $(".table_div2").hide();
		 $(".table_div3").hide();
		 $(".table_div4").hide();
		 $(".table_div_new_order").hide();	
		 $(this).addClass('blue');
	 	 $("#btn2").removeClass("blue");
		 $("#btn3").removeClass("blue"); 
		 $("#btn4").removeClass("blue"); 
		 $("#btn_new_order").removeClass("blue"); 
	
		 });
		 
	 $("#btn2").click(function(){
		$(".table_div9").hide();
		$(".table_div").hide();
		$(".table_div2").show();
		$(".table_div3").hide();
		$(".table_div4").hide();
		$(".table_div_new_order").hide();	
		 $(this).addClass('blue');
		 $("#btn1").removeClass("blue");
		 $("#btn3").removeClass("blue"); 
		 $("#btn4").removeClass("blue"); 
		  $("#btn_new_order").removeClass("blue"); 
		 });
	 
	  $("#btn_new_order").click(function(){
		$(".table_div9").hide();
		$(".table_div").hide();
		$(".table_div2").hide();
		$(".table_div3").hide();
		$(".table_div4").hide();
		$(".table_div_new_order").show();	
		 $(this).addClass('blue');
		 $("#btn1").removeClass("blue");
		 $("#btn2").removeClass("blue");
		 $("#btn3").removeClass("blue"); 
		 $("#btn4").removeClass("blue"); 
		 });
	
	 $("#btn3").click(function(){
		 $(".table_div9").hide();
		 $(".table_div3").show();
		 $(".table_div2").hide();
		 $(".table_div").hide();
		 $(".table_div_new_order").hide();
		 $(".table_div4").hide();
		 $(this).addClass('blue');
		 $("#btn1").removeClass("blue");
		 $("#btn2").removeClass("blue"); 
		 $("#btn4").removeClass("blue"); 
		 $("#btn_new_order").removeClass("blue"); 
		 });	
		
	 $("#btn4").click(function(){
		 $(".table_div9").hide();
		 $(".table_div4").show();
		 $(".table_div2").hide();
		 $(".table_div3").hide();
		 $(".table_div").hide();
		 $(".table_div_new_order").hide();
		 $(this).addClass('blue');
		 $("#btn1").removeClass("blue"); 
		 $("#btn2").removeClass("blue");
		 $("#btn3").removeClass("blue");
		  $("#btn_new_order").removeClass("blue"); 
	  });	
	  
	  
	  $("#btn_admin1").click(function(){
		 $(".table_div9").show(); 
		 $(".table_history").hide();
		 $(".table_div5").show();
		 $(".table_div6").hide();
		 $(".table_div7").hide();
		 $(".table_div8").hide();
		 $(this).addClass('blue');
	 	 $("#btn_admin2").removeClass("blue");
		 $("#btn_admin3").removeClass("blue"); 
		 $("#btn_admin4").removeClass("blue"); 
	
		 });
		 
	 $("#btn_admin2").click(function(){
		 $(".table_div9").hide();
		 $(".table_history").hide();
		 $(".table_div6").show();
		 $(".table_div5").hide();
		 $(".table_div7").hide();
		 $(".table_div8").hide();
		 $(this).addClass('blue');
		 $("#btn_admin1").removeClass("blue");
		 $("#btn_admin3").removeClass("blue"); 
		 $("#btn_admin4").removeClass("blue"); 
		 });
	 
	 $("#btn_admin3").click(function(){
		 $(".table_div9").hide();
		 $(".table_history").hide();
		 $(".table_div7").show();
		 $(".table_div5").hide();
		 $(".table_div6").hide();
		 $(".table_div8").hide();
		 $(this).addClass('blue');
		 $("#btn_admin1").removeClass("blue");
		 $("#btn_admin2").removeClass("blue"); 
		 $("#btn_admin4").removeClass("blue"); 
		  
		 });	
		
	 $("#btn_admin4").click(function(){
		 $(".table_div9").hide();
		 $(".table_history").hide();
		 $(".table_div8").show();
		 $(".table_div5").hide();
		 $(".table_div6").hide();
		 $(".table_div7").hide();
		 $(this).addClass('blue');
		 $("#btn_admin1").removeClass("blue"); 
		 $("#btn_admin2").removeClass("blue");
		 $("#btn_admin3").removeClass("blue");
	  });
	 
	  $("#tab_admin").click(function(){
	   $(".table_div5").show();
	   $(".table_history").hide();
	   $("#tab_admin1").css("background-color","#CCC");
	   $(this).css("background-color","white");
	});
	
	$("#tab_admin1").click(function(){
		$(".table_div5").hide();
		$(".table_history").show();
		$("#tab_admin").css("background-color","#CCC");
		$(this).css("background-color","white");
		$(".table_div5").css("positopn")
	});
	
	
	 //==========Functions for Add placeholder to the textarea ======// 
	 
	 //==========USER SIDE==================//
	$(".user_first_ol li").click(function(){
		  var text=$(this).text()+" ";
		  var textarea=$("#txt_area1");
		  textarea.val(textarea.val() + text);
		  $("#txt_area1").focus()
	});
		
	$(".user_second_ol li").click(function(){
		 
		  var text=$(this).text()+" ";
		  var textarea=$("#txt_area2");
		  textarea.val(textarea.val() + text);
		  $("#txt_area2").focus()
		});
	
	$(".user_new_order_ol li").click(function(){
		 
		  var text=$(this).text()+" ";
		  var textarea=$("#txt_area_new_order");
		  textarea.val(textarea.val() + text);
		  $("#txt_area_new_order").focus()
		});
			
	$(".user_third_ol li").click(function(){
		  var text=$(this).text()+" ";
		  var textarea=$("#txt_area3");
		  textarea.val(textarea.val() + text);
		  $("#txt_area3").focus()
		});	
	
	$(".user_fourth_ol li").click(function(){
		  var text=$(this).text()+" ";
		  var textarea=$("#txt_area4");
		  textarea.val(textarea.val() + text);
		  $("#txt_area4").focus()
		
		});	
	
	
	//==========ADMIN SIDE==================//
	$(".admin_first_ol li").click(function(){
		   var text=$(this).text()+" ";
		   var textarea=$("#admin_txt_area");
		   textarea.val(textarea.val() + text);
		   $("#admin_txt_area").focus()
		});	
		
	$(".admin_second_ol li").click(function(){
		   var text=$(this).text()+" ";
		   var textarea=$("#admin_txt_area2");
		   textarea.val(textarea.val() + text);
		   $("#admin_txt_area2").focus()
		});		
		
	$(".admin_third_ol li").click(function(){
		   var text=$(this).text()+" ";
		   var textarea=$("#admin_txt_area3");
		   textarea.val(textarea.val() + text);
		   $("#admin_txt_area3").focus()
		});	
	
	$(".admin_fourth_ol li").click(function(){
		   var text=$(this).text()+" ";
		   var textarea=$("#admin_txt_area4");
		   textarea.val(textarea.val() + text);
		   $("#admin_txt_area4").focus()
		});
		
	$(".admin_first_ol1 li").click(function(){
		   var text=$(this).text()+" ";
		   var textarea=$("#history_txt_area");
		   textarea.val(textarea.val() + text);
		  $("#history_txt_area").focus()
	});
		
	//=======code for when record does not exist in sms history table======//		
	if($(".history_logs tbody tr").size()==0)
	{
		$(".not_found_div").html("<h1 class='not_found'>Record Not found........</h1>");	
		$(".pagination_center").remove();
	}
	
	
	//=======paginationation anchor code====//
	/*$(".selected_anchor").next().show();
	$(".selected_anchor").next().next().show();
	$(".selected_anchor").next().next().next().show();
	$(".selected_anchor").next().next().next().next().show();
	$(".selected_anchor").prev().show();
	$(".selected_anchor").prev().prev().show();
	$(".selected_anchor").prev().prev().prev().show();
	$(".selected_anchor").prev().prev().prev().prev().show();
*/	//$(".selected_anchor").next().next();*/
	//$("#next").css("margin-left","20px");
	//$("#prev").css("margin-right","20px")
	
	$("#next").click(function(){
		var page_url=$(".selected_anchor").next().attr("href");
		window.location = page_url;
	});
	
	$("#prev").click(function(){
		var page_url=$(".selected_anchor").prev().attr("href");
		window.location = page_url;
	});
		
	
});
	

	
	
//==========Validations======//
function validate(string)
{
	
	var retvalue=true;
//========validation for input type==========//
	 $("."+string+" input").each(function(){
		  if($(this).attr("type")=="text")
		  {
			  if($(this).val()=="")
			  { 
				retvalue=false;
				$(this).css("border-color","red");
			  }
		  }
		 if($(this).attr("type")=="password")
		  {
			 if($(this).val()=="")
			  { 
				retvalue=false;
				$(this).css("border-color","red");
			  } 
		  }
		$(this).keyup(function(){
			$(this).css("border-color","green");
			});
		
		
		if($(this).attr("class")=="sms_text")
		{
			
			if (/^\d{10}$/.test($(this).val())) {
				$(this).css("border-color","green");
				
			} else {
				 $(this).css("border-color","red");
				 retvalue=false;
			}
		}
		
		
		if($(this).attr('type')=='checkbox')
		{
			if($(this).is(":checked"))
			{
				$(this).val("active");
			}
		    else
			{
				$(this).val("inactive")
			}
		}
		if($(this).attr('id')=='txt_sender_id')
		{
			if($(this).val().length>11)
			{
				 $(this).css("border-color","red");
				 retvalue=false;
			}
		}	
	  });
	  
	  
	  
//========validation for textarea==========//	
	$("."+string+" textarea").each(function(){  
		  if($(this).val()=="")
		  {
			  retvalue=false;
			 $(this).css("border-color","red");
		  }
		  $(this).keyup(function(){
			$(this).css("border-color","green");
		  });
		  
	 });
	
	return retvalue;
}

/* $('.my-button').bind('click', function(e) {
                e.preventDefault();
                $('.element_to_pop_up1').bPopup();
            });
			*/
		  function get_popup(id)
		  {
                $('.'+id).bPopup();
		  }
			
			(function(b){b.fn.bPopup=function(z,F){function K(){a.contentContainer=b(a.contentContainer||c);switch(a.content){case "iframe":var h=b('<iframe class="b-iframe" '+a.iframeAttr+"></iframe>");h.appendTo(a.contentContainer);r=c.outerHeight(!0);s=c.outerWidth(!0);A();h.attr("src",a.loadUrl);k(a.loadCallback);break;case "image":A();b("<img />").load(function(){k(a.loadCallback);G(b(this))}).attr("src",a.loadUrl).hide().appendTo(a.contentContainer);break;default:A(),b('<div class="b-ajax-wrapper"></div>').load(a.loadUrl,a.loadData,function(){k(a.loadCallback);G(b(this))}).hide().appendTo(a.contentContainer)}}function A(){a.modal&&b('<div class="b-modal '+e+'"></div>').css({backgroundColor:a.modalColor,position:"fixed",top:0,right:0,bottom:0,left:0,opacity:0,zIndex:a.zIndex+t}).appendTo(a.appendTo).fadeTo(a.speed,a.opacity);D();c.data("bPopup",a).data("id",e).css({left:"slideIn"==a.transition||"slideBack"==a.transition?"slideBack"==a.transition?g.scrollLeft()+u:-1*(v+s):l(!(!a.follow[0]&&m||f)),position:a.positionStyle||"absolute",top:"slideDown"==a.transition||"slideUp"==a.transition?"slideUp"==a.transition?g.scrollTop()+w:x+-1*r:n(!(!a.follow[1]&&p||f)),"z-index":a.zIndex+t+1}).each(function(){a.appending&&b(this).appendTo(a.appendTo)});H(!0)}function q(){a.modal&&b(".b-modal."+c.data("id")).fadeTo(a.speed,0,function(){b(this).remove()});a.scrollBar||b("html").css("overflow","auto");b(".b-modal."+e).unbind("click");g.unbind("keydown."+e);d.unbind("."+e).data("bPopup",0<d.data("bPopup")-1?d.data("bPopup")-1:null);c.undelegate(".bClose, ."+a.closeClass,"click."+e,q).data("bPopup",null);H();return!1}function G(h){var b=h.width(),e=h.height(),d={};a.contentContainer.css({height:e,width:b});e>=c.height()&&(d.height=c.height());b>=c.width()&&(d.width=c.width());r=c.outerHeight(!0);s=c.outerWidth(!0);D();a.contentContainer.css({height:"auto",width:"auto"});d.left=l(!(!a.follow[0]&&m||f));d.top=n(!(!a.follow[1]&&p||f));c.animate(d,250,function(){h.show();B=E()})}function L(){d.data("bPopup",t);c.delegate(".bClose, ."+a.closeClass,"click."+e,q);a.modalClose&&b(".b-modal."+e).css("cursor","pointer").bind("click",q);M||!a.follow[0]&&!a.follow[1]||d.bind("scroll."+e,function(){B&&c.dequeue().animate({left:a.follow[0]?l(!f):"auto",top:a.follow[1]?n(!f):"auto"},a.followSpeed,a.followEasing)}).bind("resize."+e,function(){w=y.innerHeight||d.height();u=y.innerWidth||d.width();if(B=E())clearTimeout(I),I=setTimeout(function(){D();c.dequeue().each(function(){f?b(this).css({left:v,top:x}):b(this).animate({left:a.follow[0]?l(!0):"auto",top:a.follow[1]?n(!0):"auto"},a.followSpeed,a.followEasing)})},50)});a.escClose&&g.bind("keydown."+e,function(a){27==a.which&&q()})}function H(b){function d(e){c.css({display:"block",opacity:1}).animate(e,a.speed,a.easing,function(){J(b)})}switch(b?a.transition:a.transitionClose||a.transition){case "slideIn":d({left:b?l(!(!a.follow[0]&&m||f)):g.scrollLeft()-(s||c.outerWidth(!0))-C});break;case "slideBack":d({left:b?l(!(!a.follow[0]&&m||f)):g.scrollLeft()+u+C});break;case "slideDown":d({top:b?n(!(!a.follow[1]&&p||f)):g.scrollTop()-(r||c.outerHeight(!0))-C});break;case "slideUp":d({top:b?n(!(!a.follow[1]&&p||f)):g.scrollTop()+w+C});break;default:c.stop().fadeTo(a.speed,b?1:0,function(){J(b)})}}function J(b){b?(L(),k(F),a.autoClose&&setTimeout(q,a.autoClose)):(c.hide(),k(a.onClose),a.loadUrl&&(a.contentContainer.empty(),c.css({height:"auto",width:"auto"})))}function l(a){return a?v+g.scrollLeft():v}function n(a){return a?x+g.scrollTop():x}function k(a){b.isFunction(a)&&a.call(c)}function D(){x=p?a.position[1]:Math.max(0,(w-c.outerHeight(!0))/2-a.amsl);v=m?a.position[0]:(u-c.outerWidth(!0))/2;B=E()}function E(){return w>c.outerHeight(!0)&&u>c.outerWidth(!0)}b.isFunction(z)&&(F=z,z=null);var a=b.extend({},b.fn.bPopup.defaults,z);a.scrollBar||b("html").css("overflow","hidden");var c=this,g=b(document),y=window,d=b(y),w=y.innerHeight||d.height(),u=y.innerWidth||d.width(),M=/OS 6(_\d)+/i.test(navigator.userAgent),C=200,t=0,e,B,p,m,f,x,v,r,s,I;c.close=function(){a=this.data("bPopup");e="__b-popup"+d.data("bPopup")+"__";q()};return c.each(function(){b(this).data("bPopup")||(k(a.onOpen),t=(d.data("bPopup")||0)+1,e="__b-popup"+t+"__",p="auto"!==a.position[1],m="auto"!==a.position[0],f="fixed"===a.positionStyle,r=c.outerHeight(!0),s=c.outerWidth(!0),a.loadUrl?K():A())})};b.fn.bPopup.defaults={amsl:50,appending:!0,appendTo:"body",autoClose:!1,closeClass:"b-close",content:"ajax",contentContainer:!1,easing:"swing",escClose:!0,follow:[!0,!0],followEasing:"swing",followSpeed:500,iframeAttr:'scrolling="no" frameborder="0"',loadCallback:!1,loadData:!1,loadUrl:!1,modal:!0,modalClose:!0,modalColor:"#000",onClose:!1,onOpen:!1,opacity:0.7,position:["auto","auto"],positionStyle:"absolute",scrollBar:!0,speed:250,transition:"fadeIn",transitionClose:!1,zIndex:9997}})(jQuery);
