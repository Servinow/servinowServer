$(function(){
	var drawer = new _servinow.Drawer();
	
	if( !drawer.start() ) {
		console.log("Wrong start");
		alert("Se necesita un navegador de verdad como Firefox o Chrome.");
	}
	
	drawer.sendOnClick($('#confirmDraw'));
});