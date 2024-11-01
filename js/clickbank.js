var setCheckboxVal = function()
{
  var obj  		   = arguments[0];	
  if(obj.checked)
     obj.value = 'enabled';
  else
     obj.value = 'disabled';
}


jQuery(document).ready(function($) {
    var msgDv        = jQuery('#dv_message');
	var defaultmsgDv = jQuery('div#message');
	if(typeof(defaultmsgDv) != 'undefined') {
		if(defaultmsgDv.length > 1) {
		 jQuery(defaultmsgDv[0]).remove();
		}
	}
	if(typeof(msgDv) != null && typeof(msgDv) != 'undefined') {
		  setTimeout(function () {
				msgDv.hide('slow');
			}, 10000);
	}	
	
	$("#loading").css("visibility","hidden");
	
	$('#addMoreProfile').bind('click',function() {
	    var totalProfiles = parseInt($('#totalprofiles').val()) + 1;
		var eHtml = $('#accordion .main-panel')[0].innerHTML;
		var nHtml = '<h3>Profile '+totalProfiles+' <span class="ui-icon ui-icon-trash" id="trash_'+parseInt( totalProfiles - 1)+'" title="Remove This Profile." style="float:right;">Remove</span></h3>';
		nHtml    += '<div class="main-panel">' + eHtml + '</div>';
		$('#accordion').append(nHtml).accordion("refresh");
		var fields = $($('#accordion .main-panel')[parseInt( totalProfiles - 1)]).find('input[type=text]');
		$.each(fields,function(k,v) {
		   $(v).attr('name',$(v).attr('name').replace(/\[\d+](?!.*\[\d)/, '['+parseInt( totalProfiles - 1)+']'));
		   $(v).attr('value','');
		});
		$("#accordion").accordion({active:parseInt( totalProfiles - 1)});;
	    $('#totalprofiles').val(totalProfiles);
	});
	
	function renderAccordion()
	{
		var icons = {
			header: "ui-icon-circle-arrow-e",
			activeHeader: "ui-icon-circle-arrow-s"
		};
		$( "#accordion" ).accordion({
			icons        : icons,
			collapsible  : true
		});
	}
	renderAccordion();
	
	$('.ui-icon-trash').live('click',function(event) {
		event.stopPropagation();
		var conf = confirm('Are you sure,you want to remove this profile ?');
		if(conf === true) {
			var trashID = parseInt($(this).attr('id').split('trash_')[1]);
			$(this).parent().next().hide();
			$(this).parent().hide();
			$('#accordion').accordion("refresh");
			var input = {
				action  : 'cb_remove_profile',
				profile : trashID, 
				whatever: 1      // We pass php values differently!
			};
			$.ajax({
			  type: "POST",
			  url: wpAdminUrl.url+"admin-ajax.php",
			  data: input,
			  success: function(html){
                    var reducedVal = parseInt(parseInt($('#totalprofiles').val()) - 1);
					if(reducedVal < 1) reducedVal = 1;
					$('#totalprofiles').val(reducedVal);
				/* Do success stuff here */
			  },
			  error: function(){
				/* do error stuff here */
			  }
		   });
		}
		return false;
	});
	
	$('#cbProfiles').live('change',function() {
	    var selVal = $(this).val();
		if(selVal == '') return;
		var newVal = parseInt($.trim(selVal.replace('profile_',''))) - 1;
		var location = window.location.href.split('?');;
		location = location[1].split('&');;
		location = location[0].split('=')[1];
		if($('#cbMapTbl').next().is('table')) $('#cbMapTbl').next().remove();
		var loadingimage = '<img id="loadingImg" src="'+plugin_url.url+'/images/loading.gif" />';;
		$('#cbMapTbl').append(loadingimage);
		var input = {
			action  : 'cb_fetch_profile_products',
			profile : newVal,
			post    : location, 
			whatever: 1      // We pass php values differently!
		};
		$.ajax({
		  type: "POST",
		  url: wpAdminUrl.url+"admin-ajax.php",
		  data: input,
		  success: function(html){
			 $('#loadingImg').remove(); 
			 var tbl = '<table width="100%" ><tbody><tr><td>Product : </td><td>'+html+'</td></table>'; 
             $('#cbMapTbl').after(tbl);
			/* Do success stuff here */
		  },
		  error: function(){
			/* do error stuff here */
		  }
	   });
	});
});