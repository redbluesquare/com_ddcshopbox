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
	var myval1 = Number(jQuery("#ship_price").text());
	var myval2 = Number(jQuery("#products_total").text());
	jQuery("#subtotal").text((myval1+myval2).toFixed(2));
	jQuery("#subtotal2").text((myval1+myval2).toFixed(2));
}

function updateCartItem(id)
{
	var itemQty = Number(jQuery("#itemQty"+id).val());
	var itemPrice = Number(jQuery("#itemPrice"+id).text());
	var itemTotal = Number(jQuery("#itemTotal"+id).text());
	var diffPrice = itemTotal - (itemQty*itemPrice);
	var subTotal = Number(jQuery("#subtotal").text());
	var productsTotal = Number(jQuery("#products_total").text());
	jQuery.ajax({
		url:'index.php?option=com_ddcshopbox&controller=update&format=raw&jform[table]=shopcartdetails&jform[ddc_shoppingcart_detail_id]='+id+'&jform[product_quantity]='+itemQty,
		type:'UPDATE',
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				console.log(itemQty+"|"+itemPrice+"|"+itemTotal+"|"+productsTotal+"|"+subTotal);
				jQuery("#itemTotal"+id).text((itemTotal-diffPrice).toFixed(2));
				jQuery("#products_total").text((productsTotal-diffPrice).toFixed(2));
				jQuery("#subtotal").text((subTotal-diffPrice).toFixed(2));
				jQuery("#subtotal2").text((subTotal-diffPrice).toFixed(2));
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
				//console.log(data);
			}else{
				console.log(data);
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
			}else{
				jQuery(".ddccartarea").append(data.msg);
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

jQuery(document).ready(function(){
	jQuery("input[name='jform[shipping_method]']").change(function(){
		jQuery("#ship_price").text(jQuery(this).val());
		myval2 = jQuery("#products_total").text();
		myvalue = Number(jQuery(this).val())+Number(myval2);
		jQuery("#subtotal").text(myvalue.toFixed(2));
	});
	myval1 = Number(jQuery("#ship_price").text());
	myval2 = Number(jQuery("#products_total").text());
	jQuery("#subtotal").text((myval1+myval2).toFixed(2));
	jQuery("#subtotal2").text((myval1+myval2).toFixed(2));
});