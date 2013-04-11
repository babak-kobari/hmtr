/**
 *@author Subash
 *@date 30 Jan 2012 
 */

$(document).ready(function (){

	$(".tempdeleterec").live("click",function () {
		if(confirm("Are you sure to change the status to Deleted ?")) {
			postString = getFilterParamString ();
			item_id=$(this).attr('id').substring(3);
			$.ajax({
				url : "shareexp/changestatus/"+item_id+'/Deleted',
				type : "post",
				data : postString,
				dataType :'html',
				success:function (data){
					$("#span_content").html(data);
				}
			});
		}else {
			return false;
		}
	});
	$(".makewiprec").live("click",function () {
		if(confirm("Are you sure to change the status to WIP ?")) {
			postString = getFilterParamString ();
			item_id=$(this).attr('id').substring(3);
			$.ajax({
				url : "shareexp/changestatus/"+item_id+'/WIP',
				type : "post",
				data : postString,
				dataType :'html',
				success:function (data){
					$("#span_content").html(data);
				}
			});
		}else {
			return false;
		}
	});

	
	$(".deleterec").live("click",function () {
		if(confirm("Are you sure to permanently delete this Experience ?")) {
			postString = getFilterParamString ();
			item_id=$(this).attr('id').substring(3);
			$.ajax({
				url : "shareexp/changestatus/"+item_id+'/PD',
				type : "post",
				data : postString,
				dataType :'html',
				success:function (data){
					$("#span_content").html(data);
				}
			});
		}
	});
	$("#filter").click(function (){
		
		postString = getFilterParamString ();
		
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
function getFilterParamString () {
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
	return postString;
}

function getexp_id(){
	
}