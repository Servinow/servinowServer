if(!_servinow)
	var _servinow = {};

(function(servinow){
	servinow.Drawer = function(){
		var knowledge = {
			objects:[],
			tables:[],
			floor: []
		};
		var floors = [];
		
		var drawerKnowledge = new servinow.DrawerKnowledge();
		
		var canvasContainer = $('#drawerCanvasContainer');
		var canvasEl = $('#drawerCanvas');
		var ctx;
		
		var objectDef = {
			def: $('#formDraggers_object .objectElement'),
			defTitle: $('#formDraggers_object .objectElement .title'),
			defHandler: $('#formDraggers_object .objectElement .handler'),
			exampleObject: $('#exampleObject').children('.objectElement'),
			tallInput: $('#formDraggers_object .tall input'),
			wideInput: $('#formDraggers_object .wide input'),
			width: 40,
			height: 40
		};
		
		var tableDef = {
			def: $('#formDraggers_table .tableElement'),
			defTitle: $('#formDraggers_table .tableElement .title'),
			exampleTable: $('#exampleTable .tableElement'),
			tallInput: $('#formDraggers_table .tall input'),
			wideInput: $('#formDraggers_table .wide input'),
			minInput: $('#formDraggers_table .configBottom .min input'),
			maxInput: $('#formDraggers_table .configBottom .max input'),
			width: 40,
			height: 40
		};
		
		var colWidth;
		var rowHeight;
		var nCols = 15;
		var nRows = 10;
		
		this.start = function(){
			var goodStart = true;
			
			if(!canvasEl[0].getContext)
				goodStart = false;
			
			ctx = canvasEl[0].getContext('2d');
			if(goodStart && !ctx)
				goodStart = false;
			
			if(goodStart) {
				prepareCanvas();
				prepareFloorDrawerEvents();
				prepareInterfaceEvents();
				
				loadElements();
			}
			
			return goodStart;
		}
		
		this.sendOnClick = function(el){
			el.click(function(e){
				console.log(knowledge);
				drawerKnowledge.saveDrawer(knowledge);
			});
		}
		
		var prepareCanvas = function(){
			var width = canvasEl.prop('width');
			var height = canvasEl.prop('height');

			colWidth = width/nCols;
			rowHeight = height/nRows;

			//Vertical lines.
			for(var x=0; x<=nCols; x++){
				var posx = colWidth*x;

				ctx.beginPath();
				ctx.moveTo(posx,0);
				ctx.lineTo(posx,height);
				ctx.stroke();
			}

			//Horizontal lines.
			for(var y=0; y<=nRows; y++){
				var posy = rowHeight*y;

				ctx.beginPath();
				ctx.moveTo(0,posy);
				ctx.lineTo(width,posy);
				ctx.stroke();
			}
		}
		
		var prepareFloorDrawerEvents = function(){
			canvasContainer.on("click", ".floor, #drawerCanvas" ,function(e){
				var _t = $(this);
				
				var offset;
				if(_t.is('.floor'))
					offset = _t.parent().offset();
				else
					offset = _t.offset();
				
				var relX = e.pageX - offset.left;
				var relY = e.pageY - offset.top;
				
				var pos = {
					x: Math.floor(relX/colWidth),
					y: Math.floor(relY/rowHeight)
				};
				
				toogleFloor(pos);
			});
		}
		
		var prepareInterfaceEvents = function(){
			objectDef.tallInput.add( objectDef.wideInput )
				.change(function(){
					var wideSize = parseInt(objectDef.wideInput.val());
					var tallSize = parseInt(objectDef.tallInput.val());
					
					objectDef.width = wideSize*colWidth;
					objectDef.height = tallSize*rowHeight;
					
					objectDef.def.add( objectDef.defTitle )
						.css({
							'width' : objectDef.width,
							'height': objectDef.height
						});

					if(tallSize == wideSize){
						objectDef.def.removeClass('wide tall').addClass('square');
					} else if(tallSize < wideSize){
						objectDef.def.removeClass('square tall').addClass('wide');
					} else {
						objectDef.def.removeClass('square wide').addClass('tall');
					}
				});
				
			tableDef.tallInput.add( tableDef.wideInput )
				.change(function(){
					var wideSize = parseInt(tableDef.wideInput.val());
					var tallSize = parseInt(tableDef.tallInput.val());
					
					tableDef.width = wideSize*colWidth;
					tableDef.height = tallSize*rowHeight;
					
					tableDef.def.add( tableDef.defTitle )
						.css({
							'width' : tableDef.width,
							'height': tableDef.height
						});

					if(tallSize == wideSize){
						tableDef.def.removeClass('wide tall').addClass('square');
					} else if(tallSize < wideSize){
						tableDef.def.removeClass('square tall').addClass('wide');
					} else {
						tableDef.def.removeClass('square wide').addClass('tall');
					}
				});
				
			objectDef.def.draggable({
				scroll: false,
				containment: canvasContainer,
				appendTo: canvasContainer,
				handle: '.handle',
				helper: function(){
					var helper = objectDef.exampleObject.clone();

					var helperTitle = helper.find('.title').val( objectDef.defTitle.val() );
					helper.add(helperTitle)
						.css({
							'width' : objectDef.width,
							'height': objectDef.height
						});

					return helper;
				},
				stop: function(e, ui){
					var def = {
						x: Math.floor(ui.position.left/colWidth),
						y: Math.floor(ui.position.top/rowHeight),
						name: objectDef.defTitle.val(),
						wide: parseInt( objectDef.wideInput.val() ),
						tall: parseInt( objectDef.tallInput.val() ),

						id: Math.floor(Math.random()*1000)
					};

					addObject(def);
				}
			});
				
				
			tableDef.def.draggable({
				scroll: false,
				containment: canvasContainer,
				appendTo: canvasContainer,
				handle: '.handle',
				helper: function(){
					var helper = tableDef.exampleTable.clone();

					var helperTitle = helper.find('.title').text( " " );
					helper.add(helperTitle)
						.css({
							'width' : tableDef.width,
							'height': tableDef.height
						});

					return helper;
				},
				stop: function(e, ui){
					var def = {
						x: Math.floor(ui.position.left/colWidth),
						y: Math.floor(ui.position.top/rowHeight),
						name: tableDef.defTitle.text(),
						wide: parseInt( tableDef.wideInput.val() ),
						tall: parseInt( tableDef.tallInput.val() ),
						min: parseInt( tableDef.minInput.val() ),
						max: parseInt( tableDef.maxInput.val() )
					};

					addTable(def);
				}
			});
		}
		
		var loadElements = function(){
			var toLoad = $.parseJSON( $('#drawerKnowledge').text() );
			
			for(var i=0; i<toLoad.objects.length; i++){
				addObject( toLoad.objects[i] );
			}
			
			for(var i=0; i<toLoad.tables.length; i++){
				addTable( toLoad.tables[i] );
			}
			
			var size = nCols*nRows;
			for(var i=0; i<size; i++){
				if(toLoad.floor[i]){
					var pos = {
						x: i%nCols,
						y: Math.floor(i/nCols)
					};
					toogleFloor( pos );
				}
			}
		}
	
		var toogleFloor = function(pos){
			var p = pos.y*nCols + pos.x;
			if(!knowledge.floor[p]) {
				floors[p] = $('<div>').addClass("floor").css({
					top: pos.y*rowHeight+5,
					left: pos.x*colWidth+5,
					width: colWidth,
					height: rowHeight
				}).appendTo(canvasContainer);
				
				knowledge.floor[p] = true;
			} else {
				floors[p].remove();
				floors[p] = null;
				
				knowledge.floor[p] = false;
			}
		}
		
		var addObject = function(def){
			var width = def.wide*colWidth;
			var height = def.tall*rowHeight;
			var top = def.y*rowHeight + 5;
			var left = def.x*colWidth + 5;
			
			knowledge.objects.push(def);
			
			var newObject = objectDef.exampleObject.clone();
			var newObjectTitle = newObject.find('.title');
			newObject.add( newObjectTitle )
				.css({
					'width' : width,
					'height': height,
					'top' : top,
					'left': left
				});
				
			newObjectTitle.val(def.name);
			
			newObject.data('id', def.id);
			newObject.find('.removeHandler').click(function(){
				console.log("click!");
				removeObject(newObject);
			});
			
			newObject.css('position', 'absolute').draggable({
				scroll: false,
				containment: canvasContainer,
				appendTo: canvasContainer,
				handle: '.handle',
				stop: function(e, ui){
					def.y = Math.floor(ui.position.top/rowHeight);
					def.x = Math.floor(ui.position.left/colWidth);
					
					newObject.add(newObjectTitle)
						.css({
							top: def.y*rowHeight +5,
							left: def.x*colWidth +5
						});
				}
			});
			
			newObject.find('input.title').change(function(){
				def.name = $(this).val();
			});
			
			newObject.tooltip({
				delay: 0,
				bodyHandler: function(){
					return $('<p>').text(def.name);
				}
			});
			
			if(def.wide == def.tall){
				newObject.removeClass('wide tall').addClass('square');
			} else if(def.tall < def.wide){
				newObject.removeClass('square tall').addClass('wide');
			} else {
				newObject.removeClass('square wide').addClass('tall');
			}
			
			canvasContainer.append(newObject);
		}
		
		var addTable = function(def){
			var width = def.wide*colWidth;
			var height = def.tall*rowHeight;
			var top = def.y*rowHeight + 5;
			var left = def.x*colWidth + 5;
			
			knowledge.tables.push(def);
			
			var newObject = tableDef.exampleTable.clone();
			var newObjectTitle = newObject.find('.title');
			newObject.add( newObjectTitle )
				.css({
					'width' : width,
					'height': height,
					'top' : top,
					'left': left
				});
				
			var withID = function(){
				newObjectTitle.text(def.id);
				newObject.data('id', def.id);
				var h = newObject.find('.removeHandler').click(function(){
					removeTable(newObject);
				});
			}
			
			if(def.id > 0) {
				withID();
			} else {
				newObjectTitle.text(" ");
				newObject.find('.removeHandler');
				drawerKnowledge.addNewTable(def, withID);
			}
			
			newObject.css('position', 'absolute').draggable({
				scroll: false,
				containment: canvasContainer,
				appendTo: canvasContainer,
				handle: '.handle',
				stop: function(e, ui){
					def.y = Math.floor(ui.position.top/rowHeight);
					def.x = Math.floor(ui.position.left/colWidth);
					
					newObject.add(newObjectTitle)
						.css({
							top: def.y*rowHeight +5,
							left: def.x*colWidth +5
						});
				}
			});
			
			if(def.wide == def.tall){
				newObject.removeClass('wide tall').addClass('square');
			} else if(def.tall < def.wide){
				newObject.removeClass('square tall').addClass('wide');
			} else {
				newObject.removeClass('square wide').addClass('tall');
			}
			
			newObject.tooltip({
				delay: 0,
				bodyHandler: function(){
					return $('<p>').text('Comensales de '+def.min+" a "+def.max+" comensales");
				}
			});
			
			canvasContainer.append(newObject);
		}
		
		var removeObject = function(el){
			for(var i=0; i<knowledge.objects.length; i++){
				var id = el.data('id');

				if(id == knowledge.objects[i].id) { 
					knowledge.objects.splice(i, 1);
					el.remove();
					
					//Workarround
					$('#tooltip').hide();

					return;
				}
			}
		}
		
		var removeTable = function(el){
			for(var i=0; i<knowledge.tables.length; i++){
				var id = el.data('id');

				if(id == knowledge.tables[i].id) { 
					knowledge.tables.splice(i, 1);
					el.remove();
					
					//Workarround
					$('#tooltip').hide();

					return;
				}
			}
			
		}
	}
})(_servinow);