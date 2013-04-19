$(document).ready(function() {
	//Jquery start
	//Sign-box positioning (onready)
	var offset=$(window).width()-($("#content").offset().left+$("#content").width()+1);
	if (offset<=-9) {
		offset=-9;	
	}
	$("#sign-box").css("right",offset);
	//End Sign-box positioning (onready)
	
	/*Problem trigger
	if ($("#pform-pid").val()!=""){
		$("#pidform-cont").show();
	}
	$(".logo").click(function(){
		if($("#pidform-cont").css("display") == "none"){
			$("#pidform-cont").slideDown("slow");
			$("#pform-pid").focus();
		} else {
			$("#pidform-cont").slideUp("slow");
		}
	});
	//Problem trigger end
	//Problem navigation
	$("#pidform").submit(function() {
		if ($("#pform-pid").val()!=""){
			window.location="problems."+$("#pform-pid").val();
		} else {
			$("#pidform-cont").slideDown("slow");
		}
	});
	//Problem navigation end*/
	
	// Log in trigger
	$("#sign-trigger").click(function(){
		if($("#sign-box").css("display") == "none"){
			$("#sign-box").slideDown("slow");
			//$("#content-right").css("margin-top","200px");
		} else {
			$("#sign-box").slideUp("slow");
			//$("#content-right").css("margin-top","0px");
		}
	});
	// Log in trigger end
	
	// Log in
	$("#sign-form").submit(function(){
		if($("#sign-uid").val() == ""){
			$("#sign-msg").html("Input user name");
			$("#sign-uid").focus();
			$("#sign-msg").fadeIn();
			setTimeout('$("#sign-msg").fadeOut();',2000);
			return false;
		}else if($("#sign-pass").val() == ""){
			$("#sign-msg").html("Input password");
			$("#sign-pass").focus();
			$("#sign-msg").fadeIn();
			setTimeout('$("#sign-msg").fadeOut();',2000);
			return false;
		}
		
		$("#sign-msg").show();
		$("#sign-msg").html("Processing");
		$("#sign-msg").append(" <img src='"+base_url+"assets/img/loading.gif' height='10'></img>");
		$("#sign-submit").attr('disabled', 'disabled');
		$.ajax({
			   type: "POST",
			   url: base_url+"assets/resc/processlogin.php",
			   data: $("#sign-form").serialize(),
			   dataType: "json",
			   success: function(data) {
				   if(data['status'] != "OK"){
						$("#sign-msg").html(data['message']);
						$("#sign-msg").fadeIn();
						$("#sign-submit").focus();
						$("#sign-submit").removeAttr("disabled");      
					}else{
						$("#sign-msg").html(data['message']);
						$("#sign-submit").focus();
						//$("#sign-msg").fadeIn();
						$("#sign-msg").append(" <img src='"+base_url+"assets/img/loading.gif' height='10'></img>");    
						$("#sign-submit").removeAttr("disabled");
						setTimeout('window.location.reload();',1000);		
					}	
				},
				error:function (xhr, ajaxOptions, thrownError){ alert(xhr.statusText) }
			   });
		$("#sign-submit").removeAttr("disabled");
		return false;
	});
	// End log in
	
	// Log out
	$("#sign-out").click(function () {
		$("#sign-msg").show();
		$("#sign-msg").html("Processing");
		$("#sign-msg").append(" <img src='"+base_url+"assets/img/loading.gif' height='10'></img>");
		$.getJSON(base_url+"assets/resc/processlogout.php",0,function(json){
			$('#sign-msg').html("Logged out");
			$('#sign-msg').append(" <img src='"+base_url+"assets/img/loading.gif' height='10'></img>");
			setTimeout('window.location.href=window.location.href;',1000);
		});
	});
	// End log out
	
	//Sign-box scrolling
	$(window).scroll(function () { 
		if ($("#top").offset().top>$("#content").offset().top-40) {
			$("#sign-box").css("margin-top","0px");
		} else {
			var offset=($("#content").offset().top-$("#top").offset().top)-40;
			offset = offset + "px";
			$("#sign-box").css("margin-top",offset);
		}
							   });
	//End Sign-box scrollong
	
	//Sign-box positioning (onresize)
	$(window).resize(function () { 
										var offset=$(window).width()-($("#content").offset().left+$("#content").width()+1);
										if (offset<=-9) {
											offset=-9;	
										}
										//alert(offset);
										$("#sign-box").css("right",offset);
							   });
	//End Sign-box positioning (onresize)
	
	//Table colouring
	$("#content-managepost tr:even").addClass("kyaa");
	$("#content-managepost tr:odd").addClass("kyaa2");
	//End Table coloring
});