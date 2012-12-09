if(!_servinow)
	var _servinow = {};

(function(servinow){
	var url_addTable = "api/addTable/";
	var url_saveDrawer = "api/saveDrawer/";
	
	servinow.DrawerKnowledge = function(){
		
		this.addNewTable = function(def, onID){
			$.ajax({
				url: url_addTable,
				dataType: 'json',
				type: 'POST',
				data: def,
				success: function(data){
					def.id = data.id;
					
					onID();
				}
			});
		}
		
		this.saveDrawer = function(knowledge){
			$.ajax({
				url: url_saveDrawer,
				dataType: 'json',
				type: 'POST',
				data: knowledge,
				success: function(data){
					console.log("Hecho!");
				}
			});
		}
	}
})(_servinow);