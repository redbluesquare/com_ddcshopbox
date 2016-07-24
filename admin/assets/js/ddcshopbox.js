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
			console.log(data);
			if ( data.success ){
				jQuery("#profileaddressModal").modal('hide');
			}else{
				jQuery(".modal-header").append(data.msg);
			}
		}
	});

}
