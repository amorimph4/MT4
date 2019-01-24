$(document).ready(function(){
	$("#link-login").click(function(){
		var username = $('#login-username').val();
		var userpass = $('#login-password').val();
		var conditions = [ {'collun':'user','value':username,'typeQuery':'='},{'collun':'pass','value':userpass,'typeQuery':'='} ];		
		var json = {
	        			'table': 'user',
	        			'condition':conditions
	    	  	   };
		$.ajax('http://bigdata.fiesp.com.br:8080/request',{
	    data: JSON.stringify(json),
	    type: 'POST',
	    'processData': false,
	    dataType: 'json',
	    success: function(data){var obj = jQuery.parseJSON( JSON.stringify(data) );
								var result = jQuery.parseJSON( JSON.stringify(obj.result[0]) );
								alert( result.token );},
		error : function(data){ alert('failed' +data);}
		});
	});
});

$("form").on("submit", function (event) {