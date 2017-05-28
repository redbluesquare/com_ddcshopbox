function addFavshop(id)
{
	jQuery.ajax({
		url:'index.php?',
		type:'POST',
		data:{"jform[table]":"uservendorinterests","option":"com_ddcshopbox","controller":"update","format":"raw","jform[vendor_id]":id,"jform[comment]":""},
		dataType:'JSON',
		success:function(data)
	  	{
			if ( data.success ) {
				jQuery("#favShopImg"+id).src = '/images/heart-icon.png';
				jQuery("#favShopCounter"+id).text(data.counter);
	  		}else{
	  			//jQuery(".ddccartarea").html(data.result);
	  		}
	  	}
	});
}
function addCoupon()
{
	var coupInfo = {};
	jQuery("#ddcshopcart :input").each(function(idx,ele){
		coupInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});
	console.log(coupInfo)
	var coupon = coupInfo['jform[coupon_code]'];
	var sch = coupInfo['jform[ddc_shoppingcart_header_id]'];
	jQuery.ajax({
		url:'index.php?option=com_ddcshopbox&controller=update&format=raw&tmpl=component&jform[table]=coupon&jform[coupon_code]='+coupon+'&jform[ddc_shoppingcart_header_id]='+sch,
		type:'UPDATE',
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				
				jQuery("#jform_coupon_code").modal('hide');
				jQuery("#addCouponbtn").modal('hide');
				jQuery('#coupon_code_info').append(data.couponcode);
				jQuery('#coupon_value').val(data.msg);
				jQuery("#shopcart_status_msg").removeClass('alert');
				jQuery("#shopcart_status_msg").removeClass('alert-danger');
				jQuery("#shopcart_status_msg").addClass('alert');
				jQuery("#shopcart_status_msg").addClass('alert-success');
				jQuery('#shopcart_status_msg').html('Coupon Added');
				scPriceTotals();
			}else{
				jQuery('#jform_coupon_code').css('color','red');
				jQuery("#shopcart_status_msg").addClass('alert');
				jQuery("#shopcart_status_msg").addClass('alert-danger');
				jQuery('#shopcart_status_msg').html('Coupon not valid');
			}
		}
	});

}

function saveContactAddress()
{
	var caInfo = {};
	jQuery("#contactAddressForm :input").each(function(idx,ele){
		caInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcshopbox&controller=edit&format=raw&tmpl=component',
		type:'POST',
		data:caInfo,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				jQuery("#profileaddressModal").modal('hide');
			}else{
				jQuery(".modal-header").append(data.msg);
			}
		}
	});

}

function scPriceTotals()
{
	var valCheck = Number(jQuery('#jform_free_del_stop').val());
	var myval2 = Number(jQuery("#products_total").text());
	var couponValue = Number(jQuery('#coupon_value').val());
	if(myval2 >= valCheck)
	{
		var myval1 = Number(0);
		jQuery("#jform_delivery_price").val('0.00');
		jQuery("#jform_delivery_price2").val('0.00');
	}
	else
	{
		var myval1 = Number(jQuery("#ship_price").text());
		jQuery("#jform_delivery_price").val(jQuery("#ship_price").text());
		jQuery("#jform_delivery_price2").val(jQuery("#ship_price").text());
	}
	if(couponValue > (myval1+myval2))
	{
		couponValue = (myval1+myval2);
	}
	jQuery("#discountValue").text(couponValue.toFixed(2));
	jQuery("#subtotal").text((myval1+myval2-couponValue).toFixed(2));
	jQuery("#subtotal2").text((myval1+myval2-couponValue).toFixed(2));
}

function updateCartItem(id)
{
	var valCheck = Number(jQuery('#jform_free_del_stop').val());
	var myval1 = Number(jQuery("#ship_price").text());
	var itemQty = Number(jQuery("#itemQty"+id).val());
	var itemPrice = Number(jQuery("#itemPrice"+id).text());
	var itemTotal = Number(jQuery("#itemTotal"+id).text());
	var diffPrice = itemTotal - (itemQty*itemPrice);
	var subTotal = Number(jQuery("#subtotal").text());
	var productsTotal = Number(jQuery("#products_total").text());
	jQuery.ajax({
		url:'index.php?option=com_ddcshopbox&controller=update&format=raw&jform[table]=shopcartdetails&jform[ddc_shoppingcart_detail_id]='+id+'&jform[product_quantity]='+itemQty+'&jform[product_price]='+itemPrice,
		type:'UPDATE',
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				jQuery("#itemTotal"+id).text((itemTotal-diffPrice).toFixed(2));
				jQuery("#products_total").text((productsTotal-diffPrice).toFixed(2));
				var myval2 = Number(jQuery("#products_total").text());
				var couponValue = Number(jQuery('#coupon_value').val());
				if(myval2 >= valCheck)
				{
					jQuery("#ship_price").text('0.00');
					jQuery("#jform_delivery_price").val('0.00');
					jQuery("#jform_delivery_price2").val('0.00');
				}
				else
				{
					jQuery("#ship_price").text('4.00');
					jQuery("#jform_delivery_price").val('4.00');
					jQuery("#jform_delivery_price2").val('4.00');
				}
				if(couponValue > (myval2+Number(jQuery("#ship_price").text())))
				{
					couponValue = (myval2+Number(jQuery("#ship_price").text()));
				}
				jQuery("#discountValue").text(couponValue.toFixed(2));
				jQuery("#subtotal").text((myval2+Number(jQuery("#ship_price").text())-couponValue).toFixed(2));
				jQuery("#subtotal2").text((myval2+Number(jQuery("#ship_price").text())-couponValue).toFixed(2));
				GetCartData();
			}else{
				
			}
		}
	});
}

function ddcsubmit(task)
{
	var caInfo = {};
	jQuery(".ddcform :input").each(function(idx,ele){
		caInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?format=raw&task='+task,
		type:'POST',
		data:caInfo,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				window.setTimeout(window.location = data.data, 500);
			}else{
				
			}
		}
	});

}

function removeCartItem(id)
{
	jQuery.ajax({
		url:'index.php?option=com_ddcshopbox&controller=update&format=raw&jform[table]=shopcartdetails&jform[ddc_shoppingcart_detail_id]='+id,
		type:'DELETE',
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				location.reload();
			}else{
				
			}
		}
	});
}

function ddcUpdateCart(id)
{
	var cartInfo = {};
	jQuery("#ddcCart"+id+" :input").each(function(idx,ele){
		cartInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php',
		type:'POST',
		data:cartInfo,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				GetCartData();
				jQuery("#product_status"+id).addClass('alert');
				jQuery("#product_status"+id).removeClass('alert-danger');
				jQuery("#product_status"+id).addClass('alert-success');
				setTimeout(function(){ 
					jQuery("#product_status"+id).removeClass('alert', 'alert-success');
					jQuery("#product_status"+id).text("");
				},1500);
				jQuery("#product_status"+id).text(data.msg);
			}else{
				if ( data.locationset == 1 ){
					jQuery("#getPCModal").modal('show');
					jQuery("#ddc_vendor_product_id").val(id);
				}
				if ( data.locationset == 2 ){
					jQuery("#product_status"+id).addClass('alert');
					jQuery("#product_status"+id).addClass('alert-danger');
					jQuery("#product_status"+id).text(data.msg);
					jQuery("#ddcCart"+id).hide();
					jQuery("#ddcCartBtn"+id).hide();
				}
			}
		}
	});
}

function checkMyPostCode()
{
	var postcodeData = {};
	jQuery("#getPostCode :input").each(function(idx,ele){
		postcodeData[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php',
		type:'POST',
		data:postcodeData,
		dataType:'JSON',
		ajaxStart: function() { jQuery("body").addClass("loading");    },
	    ajaxStop: function() { jQuery("body").removeClass("loading"); },
		success:function(data)
		{
			if ( data.success ){
				jQuery("#getPCModal").modal('hide');
				jQuery("#ddclocation").val(postcodeData.ddclocation)
				ddcUpdateCart(postcodeData.ddc_vendor_product_id);
			}else{
				jQuery(".modal-header").append(data.msg);
			}
		}
	});
}

function checkPayment(id)
{
	var cartInfo = {};
	var result = false;
	var login = 0;
	if((id == 1) || (id ==0))
	{
		jQuery("#ddcshopcart :input").each(function(idx,ele){
			cartInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
		});
	}
	if(id == 2)
	{
		jQuery("#deliveryInfo :input").each(function(idx,ele){
			cartInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
		});
	}

	jQuery.ajax({
		url:'index.php',
		type:'POST',
		data:cartInfo,
		dataType:'JSON',
		ajaxStart: function() { jQuery("body").addClass("loading");    },
	    ajaxStop: function() { jQuery("body").removeClass("loading"); },
		success:function(data)
		{
			if ( data.success ){
				//console.log(data);
				if(id == 0)
				{
					jQuery('#ddcshopcart').removeClass("hide");
					jQuery('#processPayment1').removeClass("hide");
					jQuery('#deliveryInfo').delay( 800 ).addClass("hide");
					jQuery('#processPayment2').addClass("hide");
				}
				else
				{
					
					jQuery('#processPayment1').addClass("hide");
					jQuery('#deliveryInfo').delay( 800 ).removeClass("hide");
					jQuery('#processPayment2').removeClass("hide");
					jQuery('html,body').animate({scrollTop: jQuery("#deliveryInfo").offset().top-50},'slow');
					if(id == 2)
					{
						window.location = data;
					}
				}
				
			}
		}
	});
}
function _(el){
    return document.getElementById(el);
}

jQuery(document).ready(function(){
	runslide();
	jQuery('#GetIntBtn').click(function(){
		jQuery('#GetIntBtn').fadeOut(500);
		jQuery('#getInterest').slideDown( "slow",function(){

		});
	});
});
function runslide() {
	jQuery('#IntroText1').fadeIn(1500).delay(3500).fadeIn(1500, function() {
		jQuery('#IntroText2').fadeIn(1500).delay(3500).fadeIn(1500, function() {
			jQuery('#IntroText3').fadeIn(1500).delay(3500).fadeIn(1500, function() {
				jQuery('#IntroText4').fadeIn(1500).delay(3500).fadeIn(1500, function() {
					jQuery('#IntroText5').fadeIn(1500).delay(3500).fadeIn(1500, function() {
						jQuery('#IntroText6').fadeIn(1500);
					});
				});
			});
		});
	});
}



function uploadPhoto(item,id){

	var file = _("upload_photo").files[0];
    //alert(file.name+" | "+file.size+" | "+file.type);
    var formdata = new FormData();
    formdata.append("upload_photo", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "index.php?option=com_ddcshopbox&controller=edit&format=raw&tmpl=component&jform[table]=images&jform[linkedtable]="+item+"&jform[item_id]="+id);
    ajax.send(formdata);
}
function progressHandler(event){
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
    _("status").innerHTML = "";
    _("progressBar").value = 0;
    jQuery("#imagetiles").append('<div class="col-xs-4" style="height:80px;"><img src="'+event.target.responseText+'" class="img-thumbnail"/></div>')
    //_(".new_upload_pic").src = event.target.responseText;
    _("upload_photo").value = "";
}
function errorHandler(event){
    _("status").innerHTML = event.responseText;
}
function abortHandler(event){
    _("status").innerHTML = "Upload Aborted";
}

var fromLong = 0;
var fromLat = 0;
var toLong = 0;
var toLat = 0;
var check_pc = 0;

jQuery(document).ready(function(){
	
	jQuery("input[name='jform[shipping_method]']").change(function(){
		jQuery("#ship_price").text(jQuery(this).val());
		myval2 = jQuery("#products_total").text();
		myvalue = Number(jQuery(this).val())+Number(myval2);
		jQuery("#subtotal").text(myvalue.toFixed(2));
	});
	scPriceTotals();
	jQuery('[data-toggle="popover"]').popover();
	
	jQuery("#btn_distcheck").click(function(){
		var delInfo = {};
		jQuery("#delivery_form_checker :input").each(function(idx,ele){
			delInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
		});
		
		jQuery.ajax({
			url:'index.php?option=com_ddcshopbox&controller=get&format=raw',
			type:'POST',
			data:delInfo,
			dataType:'JSON',
			async: false,
			ajaxStart: function() { jQuery("body").addClass("loading");    },
		    ajaxStop: function() { jQuery("body").removeClass("loading"); },
			success:function(data)
			{
				if ( data.success ){
					if((data.from_pc==1) && (data.to_pc==1)){
						check_pc = 1;
					}else{
						if(data.from_pc==0){
							jQuery("#printText").html("Please enter correct 'Collection Postcode' format");
						}else if(data.to_pc==0){
							jQuery("#printText").html("Please enter correct 'Destination Postcode' format");
						}
					}
				}else{
					jQuery(".modal-header").append(data.msg);
				}
			}
		});
		if(check_pc == 1){
			var fromPC = jQuery("#from_postcode").val();
			
			//var postcodeData = '{"postcodes":["'+fromPC+'"]}';
			jQuery.ajax({
				url:'https://api.postcodes.io/postcodes/'+fromPC+'?key=1',
				type:'GET',
				dataType:'JSONP',
				crossDomain: true,
				async: false,
				ajaxStart: function() { jQuery("body").addClass("loading");    },
			    ajaxStop: function() { jQuery("body").removeClass("loading"); },
				success:function(data)
				{
					if ( data.status==200 ){
						fromLong = data.result.longitude;
						fromLat = data.result.latitude;
					}else{
						jQuery(".modal-header").append(data.msg);
					}
				}
			});
			var toPC = jQuery("#to_postcode").val();
			if(toPC!=null){
			jQuery.ajax({
				url:'https://api.postcodes.io/postcodes/'+toPC+'?key=1',
				type:'GET',
				async: false,
				dataType:'JSONP',
				crossDomain: true,
				ajaxStart: function() { jQuery("body").addClass("loading");    },
			    ajaxStop: function() { jQuery("body").removeClass("loading"); },
				success:function(data)
				{
					if ( data.status==200 ){
						toLong = data.result.longitude;
						toLat = data.result.latitude;
					}else{
						jQuery(".modal-header").append(data.msg);
					}
				}
			});
			}
			var deltype = "Local delivery (less than 15km distance)";
			if(getDistanceFromLatLonInKm(fromLat,fromLong,toLat,toLong)>15){
				deltype = "National Delivery (more than 15km distance)";
			}
			jQuery("#btn_distcheck").hide();
			jQuery("#dims_group").removeClass('hide');
			jQuery(".delivery_parcel_destination").addClass('hide');
			jQuery("#printText").html(deltype);
		}	
	});
	jQuery("#btn_dimscheck").click(function(){
		var weightcheck;
		var lencheck;
		var heightcheck;
		var widthcheck;
		var sweight = 5;
		var mweight = 12;
		var lweight = 25;
		var slen = 45;
		var swidth = 35;
		var sheight= 16;
		var mlen = 61;
		var mwidth = 45;
		var mheight= 45;
		var llen = 80;
		var lwidth = 60;
		var lheight= 60;
		var dims;
		if(jQuery("#dim_weight").val()<=sweight){
			weightcheck = 0;
		}else if(jQuery("#dim_weight").val()<=mweight){
			weightcheck = 1;
		}else if(jQuery("#dim_weight").val()<=lweight){
			weightcheck = 2;
		}else{
			weightcheck = 3;
		}
		if(jQuery("#dim_length").val()<=slen){
			lencheck = 0;
		}else if(jQuery("#dim_length").val()<=mlen){
			lencheck = 1;
		}else if(jQuery("#dim_length").val()<=llen){
			lencheck = 2;
		}else{
			lencheck = 3;
		}
		if(jQuery("#dim_width").val()<=swidth){
			widthcheck = 0;
		}else if(jQuery("#dim_width").val()<=mwidth){
			widthcheck = 1;
		}else if(jQuery("#dim_width").val()<=lwidth){
			widthcheck = 2;
		}else{
			widthcheck = 3;
		}
		if(jQuery("#dim_height").val()<=sheight){
			heightcheck = 0;
		}else if(jQuery("#dim_height").val()<=mheight){
			heightcheck = 1;
		}else if(jQuery("#dim_height").val()<=lheight){
			heightcheck = 2;
		}else{
			heightcheck = 3;
		}

		if((lencheck == 0) && (widthcheck == 0) && (heightcheck == 0) && (weightcheck == 0)){
			dims = 'Small parcel';
		}else if((lencheck <= 1) && (widthcheck <= 1) && (heightcheck <= 1) && (weightcheck <= 1)){
			dims = 'Medium sized parcel';
		}else if((lencheck <= 2) && (widthcheck <= 2) && (heightcheck <= 2) && (weightcheck <= 2)){
			dims = 'Large sized parcel';
		}else{dims = 'X-large sized parcel';}
		jQuery("#btn_dimscheck").hide();
		jQuery("#service_group").removeClass('hide');
		jQuery(".delivery_parcel_sizes").addClass('hide');
		jQuery("#printText2").html(dims);
	});
	var service_check = 0;
	jQuery("input[type=radio][name='jform[service_type]']").change(function(){
		if(jQuery("input[type=radio][name=service_type]:checked").val()==0){
			jQuery("#printText3").html("Our Economic delivery service is 5 - 7 days");
			if(service_check==1){
				//do nothing
			}else if(service_check==2){
				//hide del date and time window
				jQuery("#delivery_date").addClass('hide');
				jQuery("#delivery_window").addClass('hide');
				jQuery("#delivery_time_to").val("19:00");
			}
			else if(service_check==3){
				//hide del date and time window
				jQuery("#delivery_date").addClass('hide');
				jQuery("#delivery_window").addClass('hide');
				jQuery(".delivery_parcel_services").addClass('hide');
				jQuery("#delivery_time_to").val("19:00");
			}
			service_check = 0;
		}
		if(jQuery("input[type=radio][name='jform[service_type]']:checked").val()==1){
			jQuery("#printText3").html("Our Standard delivery service is 2 - 3 days");
			if(service_check==0){
				//do nothing
			}else if(service_check==2){
				//hide del date and time window
				jQuery("#delivery_date").addClass('hide');
				jQuery("#delivery_window").addClass('hide');
				jQuery("#delivery_time_to").val("19:00");
			}
			else if(service_check==3){
				//hide del date and time window
				jQuery("#delivery_date").addClass('hide');
				jQuery("#delivery_window").addClass('hide');
				jQuery("#delivery_time_to").val("19:00");
			}
			service_check = 1;
		}
		if(jQuery("input[type=radio][name='jform[service_type]']:checked").val()==2){
			jQuery("#printText3").html("Our Standard delivery service is 2 - 3 days");
			if(service_check==0){
				jQuery("#delivery_date").removeClass('hide');
				jQuery("#delivery_window").removeClass('hide');
			}else if(service_check==1){
				jQuery("#delivery_date").removeClass('hide');
				jQuery("#delivery_window").removeClass('hide');
			}
			else if(service_check==3){
				//hide del date and time window
				jQuery("#delivery_time_to").val("19:00");
			}
			service_check = 2;
		}
		if(jQuery("input[type=radio][name='jform[service_type]']:checked").val()==3){
			jQuery("#printText3").html("Our Standard delivery service is 2 - 3 days");
			if(service_check==0){
				jQuery("#delivery_date").removeClass('hide');
				jQuery("#delivery_window").removeClass('hide');
				jQuery("#delivery_time_to").val("12:00");
			}else if(service_check==1){
				jQuery("#delivery_date").removeClass('hide');
				jQuery("#delivery_window").removeClass('hide');
				jQuery("#delivery_time_to").val("12:00");
			}
			else if(service_check==2){
				//hide del date and time window
				jQuery("#delivery_time_to").val("12:00");
			}
			service_check = 2;
		}
	});
	jQuery("#btn_sevicecheck").click(function(){
		
		jQuery("#btn_sevicecheck").hide();
		jQuery("#service_group").addClass('hide');
		jQuery("#dims_group").addClass('hide');
		jQuery("#dest_group").addClass('hide');
		jQuery("#email_group").removeClass('hide');
		jQuery("html, body").delay(200).animate({
	        scrollTop: jQuery('#email_group').offset().top-100
	    }, 500);
	});
	jQuery("#btn_submitinfo").click(function(){
		var delInfo = {};
		jQuery("#delivery_form_checker :input").each(function(idx,ele){
			delInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
		});
		jQuery.ajax({
			url:'index.php?option=com_ddcshopbox&controller=edit&format=raw&tmpl=component',
			type:'POST',
			data:delInfo,
			dataType:'JSON',
			ajaxStart: function() { jQuery("body").addClass("loading");    },
		    ajaxStop: function() { jQuery("body").removeClass("loading"); },
			success:function(data)
			{
				if ( data.success ){
					jQuery("#email_group").addClass('hide');
					jQuery('#delivery_parcel_services').addClass('hide');
					jQuery('.del_request_complete').removeClass('hide');
				}else{
					jQuery(".modal-header").append(data.msg);
				}
			}
		});
		
		jQuery("#btn_sevicecheck").hide();
		jQuery("#service_group").addClass('hide');
		jQuery("#dims_group").addClass('hide');
		jQuery("#dest_group").addClass('hide');
		jQuery("#email_group").removeClass('hide');
		jQuery("html, body").delay(200).animate({
	        scrollTop: jQuery('#email_group').offset().top-100
	    }, 500);
	});

	jQuery("input[name='jform[payment_method]']").change(function(){
		//enter function to check card payment method
		checkCardPmnt();
	});
	jQuery("#deliveryInfo").on("change",function(){
		if(jQuery("input[type=radio][name='jform[change_card]']:checked").val()==1){
			jQuery("#jform_stripeCustToken").val("true");
		}
		else{
			jQuery("#jform_stripeCustToken").val("false");
		}
	});
	var email_to;
	email_to = jQuery("#jform_email_to").val();
	jQuery("#jform_email_to").on('blur',function(){
		email_to = jQuery("#jform_email_to").val();
	});
	
	jQuery("#submitIntBtn").click(function(){
		var delInfo = {};
		jQuery("#getInterestForm :input").each(function(idx,ele){
			delInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
		});
		jQuery.ajax({
			url:'index.php?option=com_ddcshopbox&controller=edit&format=raw&tmpl=component',
			type:'POST',
			data:delInfo,
			dataType:'JSON',
			success:function(data)
			{
				if ( data.success ){
					jQuery("#getInterest").addClass('hide');
					jQuery("#system-message-container").addClass('alert');
					jQuery("#system-message-container").addClass('alert-success');
					jQuery("#system-message-container").html(data.msg);
				}else{
					jQuery(".modal-header").append(data.msg);
				}
			}
		});
		jQuery("html, body").delay(1000).animate({
	        scrollTop: jQuery('#system-message-container').offset().top-150
	    }, 800);
	});
	
	
});
	
function clickMe(id)
{
	var id2 = jQuery("#ddc_service_id").val();
	if(id2!=""){
		jQuery("#productItemBox"+id2).removeClass("active");
	}
	jQuery("#productItemBox"+id).addClass("active");
	jQuery(".daysBox").removeClass("hide");
	jQuery("#serviceName").text(jQuery("#serviceName"+id).text());
	jQuery("#priceName").text(jQuery("#priceName"+id).text());
	jQuery("#ddc_service_id").val(id);
	jQuery("html, body").delay(200).animate({
        scrollTop: jQuery('#system-message-container').offset().top+300
    }, 800);
}
function Dayclick(day,open)
{
	var dt = jQuery("#"+day+"dateNm").text();
	if(open != 0)
	{
		var id2 = jQuery("#ddc_day_id").val();
		if(id2!=""){
			jQuery("#"+id2+"Date").removeClass("active");
		}
		jQuery("#"+day+"Date").addClass("active");
		jQuery("#dayName").text(jQuery("#"+day+"Date > p").text());
		jQuery("#dateName").text(dt);
		jQuery("#ddc_day_id").val(day);
		jQuery(".earlyLateBox").removeClass("hide");
		jQuery("html, body").delay(200).animate({
	        scrollTop: jQuery('#system-message-container').offset().top+600
	    }, 800);
		var delInfo = {};
		jQuery("#newBookingService :input").each(function(idx,ele){
			delInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
		});
		jQuery.ajax({
			url:'?option=com_ddcshopbox&controller=get&format=raw&component=tmpl&jform[table]=vendors&task=get.times',
			type:'GET',
			data:delInfo,
			dataType:'JSON',
			success:function(data)
			{
				if ( data.success ){
					console.log(data);
					for(var i = 0; i < 9; i++){
						if(data.result[i][1]==1){
							jQuery("#"+data.result[i][0]+"time").addClass("timeBooked");
							jQuery("#"+data.result[i][0]+"time").prop('onclick',null).off('click');
						}
					}
					jQuery("#system-message-container").html(data.msg);
				}else{
					jQuery(".modal-header").append(data.msg);
				}
			}
		});
	}
	
}
function elclick(el)
{
	var id2 = jQuery("#ddc_el_id").val();
	if(id2!=""){
		jQuery("#"+id2+"Check").removeClass("active");
	}
	jQuery("#"+el+"Check").addClass("active");
	jQuery("#ddc_el_id").val(el);
	//jQuery(".daysBox").addClass("hide");
	jQuery("."+id2+"Box").addClass("hide");
	jQuery("."+el+"Box").removeClass("hide");
	jQuery("html, body").delay(200).animate({
        scrollTop: jQuery('#system-message-container').offset().top+850
    }, 800);
}
function addTime(el,booked)
{
	if(booked==0)
	{
		var id2 = jQuery("#ddc_el2_id").val();
		if(id2!=""){
			jQuery("#"+id2+"time").removeClass("active");
		}
		jQuery("#"+el+"time").addClass("active");
		jQuery("#timeName").text(jQuery("#"+el+"time > p").text());
		jQuery("#ddc_el2_id").val(el);
		jQuery(".summaryBox").removeClass("hide");
		jQuery("html, body").delay(200).animate({
	        scrollTop: jQuery('#system-message-container').offset().top+1100
	    }, 800);
	}
	
}
// Close Checkout on page navigation:
//window.addEventListener('popstate', function() {
//  handler.close();
//});
function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
	  var R = 6371; // Radius of the earth in km
	  var dLat = deg2rad(lat2-lat1);  // deg2rad below
	  var dLon = deg2rad(lon2-lon1); 
	  var a = 
	    Math.sin(dLat/2) * Math.sin(dLat/2) +
	    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
	    Math.sin(dLon/2) * Math.sin(dLon/2)
	    ; 
	  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
	  var d = R * c; // Distance in km
	  return d;
}
function deg2rad(deg) {
	  return deg * (Math.PI/180)
}
function checkCardPmnt(){
	if(jQuery("input[type=radio][name='jform[payment_method]']:checked").val()==2){
		jQuery('#paypal_payment').addClass('hide');
		jQuery('#cardPaymentbtn').removeClass('hide');
		jQuery.ajax({
			url:'index.php?option=com_ddcshopbox&controller=get&format=raw&tmpl=component&jform[table]=ddcstripecustomer',
			type:'GET',
			dataType:'JSON',
			ajaxStart: function() { jQuery("body").addClass("loading");    },
		    ajaxStop: function() { jQuery("body").removeClass("loading"); },
			success:function(data)
			{
				if ( data.success == true ){
					jQuery(".stripeCard").removeClass('hide');
					jQuery("#stripeBrand").html(data.cardInfo.stripeCustomerBrand);
					jQuery("#stripeExpire").html(data.cardInfo.stripeCustomerExp_month+" / "+data.cardInfo.stripeCustomerExp_year);
					jQuery("#stripeLast4").html("... "+data.cardInfo.stripeCustomerlast4);
					jQuery("#jform_stripeCustToken").val("true");
					jQuery("#jform_change_card_0").attr('checked', false);
				}else{
					jQuery(".stripeCard").removeClass('hide');
					jQuery("#stripePayWith").addClass('hide');
					jQuery("#jform_stripeCustToken").val("false");
					jQuery("#jform_change_card_0").attr('checked', true);
				}
			}
		});
	}
	else{
		jQuery('#paypal_payment').removeClass('hide');
		jQuery('#cardPaymentbtn').addClass('hide');
		jQuery(".stripeCard").addClass('hide');
	}
	document.getElementById('cardPaymentbtn').addEventListener('click', function(e) {
		var email_to;
		email_to = jQuery("#jform_email_to").val();
		var sch = jQuery("#jform_ddc_shoppingcart_header_id").val();
		if(jQuery("#jform_stripeCustToken").val()=="false")
		{
			// Open Checkout with further options:
	  		handler.open({
	    		name: 'Ushbub',
	    		email: email_to,
	    		description: 'Shopping cart #'+sch,
	    		zipCode: false,
	    		currency: 'gbp'
	  		});
		}
		else
		{
			submitDel();
		}
	  e.preventDefault();
	});
}

function submitDel()
{
	var delInfo = {};
	jQuery("#deliveryInfo :input").each(function(idx,ele){
		delInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});
	jQuery.ajax({
		url:'index.php?option=com_ddcshopbox&controller=update&format=raw&tmpl=component',
		type:'POST',
		data:delInfo,
		dataType:'JSON',
		ajaxStart: function() { jQuery("#cardPaymentbtn").html("processing..");    },
	    ajaxStop: function() { jQuery("#cardPaymentbtn").html("Pay Now"); },
		success:function(data)
		{
			if ( data.success ){
				jQuery("#cardPaymentbtn").addClass('hide');
				jQuery(".payMethods").html("");
				jQuery("#jform_coupon_code").addClass('hide');
				jQuery("#addCouponbtn").addClass('hide');
				jQuery("#system-message-container").html(data.result[2]);
				jQuery("#system-message-container").addClass('alert');
				jQuery("#system-message-container").addClass('alert-success');
				jQuery("#deliveryInfo :input").prop('readonly', true);
				jQuery("#ddcshopcart :input").prop('readonly', true);
				jQuery(".removeCartItem").addClass('hide');
				GetCartData();
				jQuery("html, body").delay(200).animate({
			        scrollTop: jQuery('.body').offset().top-30
			    }, 1000);
			}else{
				jQuery(".modal-header").append(data.msg);
			}
		}
	});
}
function bookAndPay()
{
	var email_to;
	email_to = jQuery("#jform_email_to").val();
	var id = jQuery("#jform_ddc_service_id").val();
	if(jQuery("#jform_payment_method").val()==2){
		if(jQuery("#jform_stripeCustToken").val()=="false")
		{
			// Open Checkout with further options:
	  		handler.open({
	    		name: 'Ushbub',
	    		email: email_to,
	    		description: jQuery("#serviceName").text(),
	    		zipCode: false,
	    		currency: 'gbp'
	  		});
		}
	}
	else
	{
		submitBooking();
	}
}

function submitBooking()
{
	var delInfo = {};
	jQuery("#newBookingService :input").each(function(idx,ele){
		delInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});
	jQuery.ajax({
		url:'index.php?option=com_ddcshopbox&tmpl=component&jform[table]=serviceheaders&controller=edit&format=raw&task=serviceheader.save',
		type:'POST',
		data:delInfo,
		dataType:'JSON',
		ajaxStart: function() { jQuery("#submitBooking").val("processing..");    },
	    ajaxStop: function() { jQuery("#submitBooking").val("Pay Now"); },
		success:function(data)
		{
			if ( data.success ){
				jQuery("#submitBooking").addClass('hide');
				jQuery("#system-message-container").addClass('alert');
				jQuery("#system-message-container").addClass('alert-success');
				jQuery("#system-message-container").text(data.bookmsg);
				jQuery("#newBookingService :input").prop('readonly', true);
				jQuery("html, body").delay(200).animate({
			        scrollTop: jQuery('.body').offset().top-30
			    }, 1000);
			}else{
				jQuery(".modal-header").append(data.msg);
			}
		}
	});
}

function postReview()
{
	var delInfo = {};
	jQuery("#reviewPost :input").each(function(idx,ele){
		delInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});
	jQuery.ajax({
		url:'index.php',
		type:'POST',
		data:delInfo,
		dataType:'JSON',
		beforeSend: function() { jQuery(".btnReview").html("processing..");    },
	    complete: function() { jQuery(".btnReview").html("Add Review"); },
		success:function(data)
		{
			if ( data.success ){
				jQuery(".btnReview").addClass('hide');
				jQuery("#reviewPost :input").prop('readonly', true);
				jQuery(".removeCartItem").addClass('hide');
				jQuery("#reviewPostStatus").addClass('alert');
				jQuery("#reviewPostStatus").addClass('alert-success');
				jQuery("#reviewPostStatus").append("Thank you for your review.");
			}else{
				jQuery("#reviewPostStatus").addClass('alert');
				jQuery("#reviewPostStatus").addClass('alert-error');
				jQuery("#reviewPostStatus").append("Thank you of your review. Unfortunately, something went wrong. If it continues please e-mail admin@ushbub.co.uk");
			}
		}
	});
}
function updateReview(state, id)
{
	var delInfo = {};
	jQuery("#reviewPost"+id+" :input").each(function(idx,ele){
		delInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});
	jQuery.ajax({
		url:'index.php?option=com_ddcshopbox&jform[state]='+state+'&jform[ddc_posting_id]='+id+'&jform[table]=ddcpostings&controller=edit&task=review.approval&format=raw',
		type:'POST',
		data:delInfo,
		dataType:'JSON',
		beforeSend: function() { jQuery(".btnReview").html("processing..");    },
	    complete: function() { jQuery(".btnReview").html("Add Review"); },
		success:function(data)
		{
			if ( data.success ){
				jQuery(".btnReview").addClass('hide');
				jQuery("#reviewPost"+id+" :input").prop('readonly', true);
				jQuery("#reviewPost"+id).addClass('alert');
				jQuery("#reviewPost"+id).addClass('alert-success');
				jQuery("#reviewPost"+id).append("The post is now updated.");
			}else{
				jQuery("#reviewPostStatus").addClass('alert');
				jQuery("#reviewPostStatus").addClass('alert-error');
				jQuery("#reviewPostStatus").append("Thank you of your review. Unfortunately, something went wrong. If it continues please e-mail admin@ushbub.co.uk");
			}
		}
	});
}

function changeTown()
{
	jQuery("#changeTown").removeClass("hide");
}
function showCardDetails()
{
	jQuery("#cardDetails").removeClass("hide");
}
function getProdPrice(id)
{
	jQuery.ajax({
		url:'index.php?',
		type:'POST',
		data:{"jform[table]":"vendorproducts","option":"com_ddcshopbox","controller":"get","format":"raw","jform[vendorproduct_id]":id,"task":"get.price"},
		dataType:'JSON',
		success:function(data)
	  	{
			if ( data.success ) {
				jQuery("#productPrice"+id).text((Number(data.price)*Number(jQuery("#product_qty"+id).val())).toFixed(2));
	  		}else{
	  			//jQuery(".ddccartarea").html(data.result);
	  		}
	  	}
	});
}