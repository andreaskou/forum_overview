$("#toggle").click(function(){
	$("#extra-info").toggle("normal");
});


$(function(){
	$("#extra-info").click(function(e){
		e.preventDefault();
		alert('Test!');
	});
});
