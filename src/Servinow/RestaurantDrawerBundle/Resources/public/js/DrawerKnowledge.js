if(!_servinow)
	var _servinow = {};

(function(servinow){
	var url_addTable = "api/addTable/";
	
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
	}
})(_servinow);