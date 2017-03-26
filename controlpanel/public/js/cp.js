function confirmDelete(item, url){
	var result = confirm("Are You Sure you want to delete " + item + " ?");
	if(result)
		window.location.href = url;
}

function itemDeleteImage(filename){
	$('#item_image_div').hide();
	$('#item_image_del').val(filename);
	$('#item_image_del_btn').hide();
	$('#item_image_group').append('<input name="store_image" type="file" />');
}
