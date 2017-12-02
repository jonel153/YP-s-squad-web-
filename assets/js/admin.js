$(document).ready(function(){
	var base_url = $("#base_url").val();
	$(document).on('change', '#company', function(){
		var company = $(this).val();
		$.ajax({
			type: "GET",
			url: base_url + 'admin/get-account/' + company,
			dataType: 'html',
			success: function(res){
				$("#account").empty();
				$("#account").append(res);
			}
		});
	});
});