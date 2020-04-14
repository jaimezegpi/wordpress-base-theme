/*animation-duration*/
( function(){
	var sec = 0;
	var ade = document.querySelectorAll("[class*='animation-duration_']");
	for (i = 0; i < ade.length; i++) {
		var ade_cl = ade[i].classList;
		for (c=0; c < ade_cl.length; c++ ){
			if( ade_cl[c].indexOf("animation-duration_") > -1 ){
				sec = ade_cl[c].split("animation-duration_")[1];
			}
		}
		if (sec){ ade[i].style.animationDuration = sec + "s"; }
	}
})();


/*animation-count*/
( function(){
	var sec = 0;
	var ade = document.querySelectorAll("[class*='animation-count_']");
	for (i = 0; i < ade.length; i++) {
		var ade_cl = ade[i].classList;
		for (c=0; c < ade_cl.length; c++ ){
			if( ade_cl[c].indexOf("animation-count_") > -1 ){
				sec = ade_cl[c].split("animation-count_")[1];
			}
		}
		if (sec){ ade[i].style.animationIterationCount = sec; }
	}
})();

/*opacity*/
( function(){
	var sec = 0;
	var ade = document.querySelectorAll("[class*='opacity_']");
	for (i = 0; i < ade.length; i++) {
		var ade_cl = ade[i].classList;
		for (c=0; c < ade_cl.length; c++ ){
			if( ade_cl[c].indexOf("opacity_") > -1 ){
				sec = ade_cl[c].split("opacity_")[1];
			}
		}
		if (sec){ ade[i].style.opacity = sec; }
	}
})();


/*scaling*/
( function(){
	var ade = document.querySelectorAll("[class*='scaling']");
	if (ade.length){
		scaleOnResize();
		window.onresize = window.onresize = function(){ scaleOnResize(); };
	}
})();
function scaleOnResize(){
	var ade = document.querySelectorAll("[class*='scaling']");
	for (i = 0; i < ade.length; i++) {
		var ade_cl = ade[i].classList;

		let oh = ade[i].offsetHeight;
		let ow = ade[i].offsetWidth;
		let scale = Math.min(
			ade[i].parentElement.clientHeight/oh,
			ade[i].parentElement.clientWidth/ow
		);

		let marg = ( (1-scale)/2 )*100;
		ade[i].style.transformOrigin = "0 0";
		ade[i].style.transform = "scale(" + scale + ")";

		//ade[i].style.transform = "scale(" + scale + ")";
		oh = ade[i].getBoundingClientRect().height;
		ow = ade[i].getBoundingClientRect().width;
		let mrl = ( ade[i].parentElement.clientWidth-ow )/2;
		let mrt = ( ade[i].parentElement.clientHeight-oh )/2;
		ade[i].style.position = "relative";
		ade[i].style.marginLeft = mrl+"px";
		ade[i].style.top = mrt+"px";
		//let left = ( (( ade[i].parentElement.clientWidth-ow )/2)*100)/ade[i].parentElement.clientWidth;

	}
}


/*actions*/
/* Add Class fadeIn to an specific Element
in: el, individual element or group of elements. use  querySelectorAll Logic
return: na
*/
function base_fadeIn(el){
	if (!el){ return false; }
	var target  = document.querySelectorAll(el);
	if ( target.length ){
		for( t = 0; t<target.length; t++){
			if( target[t].classList.contains("fadeOut") ){
				target[t].classList.remove("fadeOut");
			}
			if( !target[t].classList.contains("fadeIn") ){
				target[t].classList.add("fadeIn");
			}
		}
	}else{
		return false;
	}
}

/*actions*/
/* Add Class fadeIn to an specific Element
in: el, individual element or group of elements. use  querySelectorAll Logic
return: na
*/
function base_fadeOut(el){
	if (!el){ return false; }
	var target  = document.querySelectorAll(el);
	if ( target.length ){
		for( t = 0; t<target.length; t++){
			if( target[t].classList.contains("fadeIn") ){
				target[t].classList.remove("fadeIn");
			}
			if( !target[t].classList.contains("fadeOut") ){
				target[t].classList.add("fadeOut");
			}
		}
	}else{
		return false;
	}
}

/*Show El Into View ini */
(function(){
	var items = document.getElementsByClassName("showIntoViewport");
	if (items){ 
		for( i=0;i<items.length;i++ ){
			if ( !isScrolledIntoView(items[i]) ){
				items[i].style.opacity="0";
			}
		}
	}
})()

function isScrolledIntoView(el) {
	var rect = el.getBoundingClientRect();
	var elemTop = rect.top;
	var elemBottom = rect.bottom;

	// Only completely visible elements return true:
	var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
	// Partially visible elements return true:
	//isVisible = elemTop < window.innerHeight && elemBottom >= 0;
	return isVisible;
}

window.addEventListener("scroll",function(){
	var items = document.getElementsByClassName("showIntoViewport");
	if (!items){ return false; }
	for( i=0;i<items.length;i++ ){
		if ( isScrolledIntoView(items[i]) ){
			if ( items[i].classList.contains("efx-fadeIn") && !items[i].classList.contains("fadeIn") ){
				items[i].classList.add("fadeIn");
			}

			if ( items[i].classList.contains("efx-fadeOut") && !items[i].classList.contains("fadeOut") ){
				items[i].classList.add("fadeOut");
			}

			if ( items[i].classList.contains("efx-slideInFromLeft") && !items[i].classList.contains("slideInFromLeft") ){
				items[i].classList.add("slideInFromLeft");
				items[i].style.opacity="1";
			}

			if ( items[i].classList.contains("efx-slideInFromRight") && !items[i].classList.contains("slideInFromRight") ){
				items[i].classList.add("slideInFromRight");
				items[i].style.opacity="1";
			}

		}
	}
});
/*Show El Into View end */

/*calculate bounding box ini*/
function base_resizeToBoundingBox( parent_id, ele_id ){
	/*
	if ( !parent_id || !ele_id ){ return false; }
	if ( !document.getElementById(parent_id) || !document.getElementById(ele_id) ){ return false; }
	*/
	var el = document.getElementById(parent_id);
	var img = document.getElementById(ele_id);
	var w = el.offsetWidth;
	var h = el.offsetHeight;

	var angle_a = getCurrentRotation(el);
	var angle_img = getCurrentRotation(el)*-1;
	

	var angle = angle_a * Math.PI / 180,
	    sin   = Math.sin(angle),
	    cos   = Math.cos(angle);

	var x1 = cos * w,
	    y1 = sin * w;

	var x2 = -sin * h,
	    y2 = cos * h;

	var x3 = cos * w - sin * h,
	    y3 = sin * w + cos * h;

	var minX = Math.min(0, x1, x2, x3),
	    maxX = Math.max(0, x1, x2, x3),
	    minY = Math.min(0, y1, y2, y3),
	    maxY = Math.max(0, y1, y2, y3);

	var rotatedWidth  = maxX - minX,
	    rotatedHeight = maxY - minY;

	var pimgl = ( (rotatedWidth-w)/2 )*-1;
	var pimgt = ( (rotatedHeight-h)/2 )*-1;
	
	img.style.width=rotatedWidth+"px";
	
	img.style.left=pimgl+"px";
	img.style.top=pimgt+"px";

	img.style.height=rotatedHeight+"px";

	img.style.transform="rotate("+angle_img+"deg)";
} 

function getCurrentRotation(el){
	var st = window.getComputedStyle(el, null);
	var tm = st.getPropertyValue("-webkit-transform") ||
	st.getPropertyValue("-moz-transform") ||
	st.getPropertyValue("-ms-transform") ||
	st.getPropertyValue("-o-transform") ||
	st.getPropertyValue("transform") ||
	"none";
	if (tm != "none") {
		var values = tm.split('(')[1].split(')')[0].split(',');
		var angle = Math.round(Math.atan2(values[1],values[0]) * (180/Math.PI));
		return (angle < 0 ? angle + 360 : angle);
	}
	return 0;
}
/*calculate bounding box ini*/