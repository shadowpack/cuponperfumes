$(document).ready(function(){ 
	$.ajax({
		url: "controller/ajax/handler.php",
		type: "POST",
		data: {
			lib: "ventas",
			method: "grafico",
			data: JSON.stringify({
			})
		},
		success: function(resultado){
			var result = JSON.parse(resultado);
			// var result = JSON.parse(resultado);
			// $("#userlogin").html('<i class="fa fa-user">&nbsp;</i>'+result.nombre+'<b class="caret"></b>');
			// $("#confirm-modal").modal('hide');
			Morris.Area({
			  // ID of the element in which to draw the chart.
			  element: 'morris-chart-area',
			  // Chart data records -- each entry in this array corresponds to a point on
			  // the chart.
			  data: result,
			  // The name of the data record attribute that contains x-visitss.
			  xkey: 'd',
			  // A list of names of data record attributes that contain y-visitss.
			  ykeys: ['ventas'],
			  // Labels for the ykeys -- will be displayed when you hover over the
			  // chart.
			  labels: ['Ventas'],
			  // Disables line smoothing
			  smooth: false,
			});
		}
	});
});