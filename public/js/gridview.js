/**
 *@author Subash
 *@date 30 Jan 2012 
 */

$(document).ready(function (){
	$("#filter").click(function (){
		var title = $("#exptitle"). val ();
		var country = $("#expcountry"). val ();
		var month = $("#expmonth"). val ();
		
		var days = $("#expdays"). val ();
		
		var travelwith = $("#exptravelwith"). val ();
		var travelobj = $("#exptravelobj"). val ();
		var totalcost = $("#exptotalcost"). val ();
		
		var status = $("#expstatus"). val ();
		
		
		
		var postString = "";
		postString += "exp_title="+title;
		postString += "&exp_country="+country;
		postString += "&exp_mount="+month;
		
		postString += "&exp_days="+days;
		
		postString += "&exp_travel_with="+travelwith;
		postString += "&exp_travel_objective="+travelobj;
		postString += "&exp_total_cost="+totalcost;
		postString += "&exp_status="+status;
		
		
		$.ajax({
			url : "shareexp/applyfilter",
			type : "post",
			data : postString,
			dataType :'html',
			success:function (data){
				$("#span_content").html(data);
			}
		});
	});
	/*
	 * Autocomplete
	 */
	$( "#exptitle" ).autocomplete({
        source: "shareexp/gettitles"
    });
	$( "#expcity" ).autocomplete({
        source: "shareexp/getcity"
    });
});