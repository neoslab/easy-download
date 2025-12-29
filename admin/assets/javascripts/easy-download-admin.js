(function($)
{
	'use strict';
	$(function()
	{
		if($('.input-stats').length > 0)
		{
			$('.input-stats').on('click',function()
			{
		    	if($(this).is(':checked'))
		    	{
		        	$("#handler-stats").show(100)
		    	}
		    	else
		    	{
		    		$("#handler-stats").hide(500)
		    	}
			});

			if($("#handler-stats.show").length)
			{
			    $("#handler-stats").show()
			}
		}

		$('#links-table').dataTable(
		{
			"paging": true,
			"ordering": true,
			"info": false,
			"columns":
			[
    			{ "width": "60%" },
    			{ "width": "20%" },
    			{ "width": "10%" },
    			{ "width": "10%" }
  			]
		});
	});
})(jQuery);