$(document).ready(function(){
	$( ".main-search" ).autocomplete({
		source: 'search-item-all',
		select: function(event, ui){
		window.location='item?s='+ui.item.data;
		}
	});

	$( ".main-search" )
	.focus(function(e){
		$(this).attr("placeholder","Search for Item Name or SKU Code.");
		$(this).animate({
		  width: "400px"
		}, 400);
	})
	.blur(function(e){
		$(this).animate({
		  width: "75px"
		}, 1000);
	});
});

	 $(document).on("click",".shutdown-server",function(e){
	 	e.preventDefault();
	 	if(confirm("Are you sure you want to shutdown the server?")){
	 		$.ajax({
	 			type: "POST",
	 			url: "shutdown-server",
	 			data: "confirm=1",
	 			cache: false,
	 			success: function(data){
	 				
	 			}
	 		});
	 	}
	 });