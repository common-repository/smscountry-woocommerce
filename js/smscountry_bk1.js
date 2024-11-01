$(document).ready(function(){
	//$('#datetimepicker').datetimepicker();
	
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
		 format:'d.m.Y'
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
		 format:'d.m.Y'
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
		// $(".table_div9").show(); 
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

