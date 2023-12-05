// AJAX demo with anonymous callback function

function loadXMLDoc() {
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			document.getElementById("messagetext").innerHTML = xmlhttp.responseText;
		}
	} //end of anonymous func.

	xmlhttp.open("GET". "ajax_info.txt");
	xmlhttp.send();
}
