function tablewrap() {
	var z = document.getElementById("mw-content-text").clientWidth;
	var x = document.querySelectorAll("#mw-content-text table");
	for(var i=x.length;i--;){
		var y = document.createElement( "div" );
		y.className = "liberty-table-wrapper";
		if (x[i].clientWidth > z && x[i].parentNode.className !== "liberty-table-wrapper") {
			x[i].parentNode.insertBefore(y,x[i]);y.appendChild(x[i])
		} 
		else if (x[i].clientWidth < z && x[i].parentNode.className == "liberty-table-wrapper")
    {x[i].parentNode.parentNode.insertBefore(x[i],x[i].parentNode);x[i].nextSibling.remove()}
	}
}
window.onresize = function() {tablewrap()}
window.onload = function() {tablewrap()}