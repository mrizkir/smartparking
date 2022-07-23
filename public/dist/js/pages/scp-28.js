//checking data type is json
function isJSON(data) {
	try 
	{
		JSON.parse(data);		
	}
	catch(e) 
	{
		console.log(data);	
		return false;
	}
	return true;
}
//parsing ajax error
function parseMessageAjaxError(xhr, status, error) {
	var message = 'Unknown';	
	if (isJSON(xhr.responseText)) {			
		var jsonResponseText = JSON.parse(xhr.responseText);
		$.each(jsonResponseText, function(name, val) {
			switch(name) {
				case 'message' :
					message = 'message: ' + val + ' # ';
				break;
				case 'exception' :
					message = message + 'exception: ' + val;
				break;
			}            
		});		
	}
	return message;
}