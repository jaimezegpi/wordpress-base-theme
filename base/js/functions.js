function base_loadDataToId(data_url, id) {
	if (!id || !data_url){ return false; }
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById(id).innerHTML = this.responseText;
		}else{
			document.getElementById(id).innerHTML = "Error "+this.status;
		}
	};
	xhttp.open("GET", data_url, true);
	xhttp.send();
}

function base_loadDataToFunction(data_url, custom_function) {
	if (!custom_function || !data_url){ return false; }
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			custom_function(this);
		}
	};
	xhttp.open("GET", data_url, true);
	xhttp.send();
	/*
	example: 
	base_loadDataToFunction("datos.txt", mostrarDatos);
	function mostrarDatos( xhttp ){
		// Magic
	}
	*/
}

function base_getJson(data_url, custom_function) {
	if (!custom_function || !data_url){ return false; }
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			custom_function(this);
		}
	};
	xhttp.open("GET", data_url, true);
	xhttp.responseType = 'json';
	xhttp.send();
	/*
	// IEXPLORE not support fetch.. Dam Iexplore you AGAIN!!
	fetch(data_url)
	.then(function(response) {
	return response.json();
	})
	.then(function(myJson) {
		custom_function(myJson);
	});
	*/
}


/*
* Menu sticky
*/
var header = document.getElementById("navbar");
var sticky = header.offsetTop;
function base_stickyNavbar() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}