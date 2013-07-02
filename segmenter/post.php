<!DOCTYPE HTML>
<html>
  <head>
	<title>Region Growing Border finding v 1.7</title>
	<script src="js/pXY.js"></script>
	<script src="js/pxChkr.js"></script>
	<script src="js/pxTrcr.js"></script>
	<script src="js/rAF.js"></script>
	
	<script src="html5slider.js"></script>
	<script>
	onload = function() {
	  var $ = function(id) { return document.getElementById(id); };
	  $('mini').oninput = function() { $('minimo').innerHTML = this.value; };
	  $('mini').oninput();
	};
	</script>
	
	<script type="text/javascript">
	/*----------------------------------------------------------------------------
	-- Main function
	----------------------------------------------------------------------------*/
	function drawImage(imageObj) {
		/*----------------------------------------------------------------------------
		-- Initializzation of the Canvas containers, in the first canvas
		-- myCanvas, we print the image, in the second one we can show
		-- the result of the Region growing algorithm
		----------------------------------------------------------------------------*/
        var canvas = document.getElementById('myCanvas');
        var context = canvas.getContext('2d');		
		var canvas_1 = document.getElementById('myCanvas_1');
        var context_1 = canvas_1.getContext('2d');
		
		
        var x = 0;
        var y = 0;

		var imageWidth = imageObj.width;
		var imageHeight = imageObj.height;
		
        context.drawImage(imageObj, x, y);														//Print of the image in the canvas.
		
		var can = document.getElementById("myCanvas"),
		pxy = new pXY(can);																			//Initializzation of the pXY library for a simpler movement.
		
		
		/*----------------------------------------------------------------------------
		-- Util function search an array composed by the x,y coordinates
		-- "element" [x,y] in an array "container" that contains all the 
		-- coordinates [[a,b],[c,d],...,]
		----------------------------------------------------------------------------*/
		function find_element(element, container){
			var z = 0;
			var found = false;
			for(z = 0; z<container.length; z++){
				if(container[z][0] == element[0] && container[z][1] == element[1]) found = true;
			}
			return found;
		}
		
		/*----------------------------------------------------------------------------
		-- Util function that adds an Event Listener to the canvas for
		-- a mouse Click. When you click on the canvas, ve get the click
		-- coordinates and start the region growing.
		----------------------------------------------------------------------------*/
		
		function getMousePos(canvas, evt) {
			var rect = canvas.getBoundingClientRect();
			return {
			x: evt.clientX - rect.left,
			y: evt.clientY - rect.top
			};
		} 
		var canvas = document.getElementById('myCanvas');
			canvas.addEventListener('click', function(evt) {
			var mousePos = getMousePos(canvas, evt);
			var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;	//Spy function for let display the starting node coordinates.
			//console.log(message);
			onclick_mouse(mousePos.x,mousePos.y)										//Start of the algorithm.
		}, false);
		
		/*----------------------------------------------------------------------------
		-- This functions print small squares in the two canvas.
		-- In the fist canvas we print a square of dimensions 
		-- sense/2 x sense/2 for the readability of the image, in the 
		-- second canvas we fill al the internal square.
		----------------------------------------------------------------------------*/
		function fill_internal(x_tmp,y_tmp,sense,sense){
					context.fillStyle = "rgb(0,0,150)";
					context.fillRect(x_tmp,y_tmp,sense,sense);					
					context_1.fillStyle = "rgb(0,0,0)";
					context_1.fillRect(x_tmp,y_tmp,sense,sense);
					return true;
		}
		
		function fill_border(x_tmp,y_tmp,sense,sense){
					context.fillStyle = "rgb(0,0,150)";
					context.fillRect(x_tmp,y_tmp,sense,sense);					
					context_1.fillStyle = "rgb(0,0,0)";
					context_1.fillRect(x_tmp,y_tmp,sense,sense);
					return true;
		}
		
		
		/*----------------------------------------------------------------------------
		-- This function is the main one, checks the luminosity of the clicked 
		-- area, expand the nodes "to_expand", checks that "to_expand" nodes
		-- were already expanded and fills the border array nodes "border"
		----------------------------------------------------------------------------*/
		function check_pix(lumin,border,to_expand,expanded,i,sense){
				if(to_expand.length != 0 && i>0){
					
					var x_tmp = to_expand[0][0];
					var y_tmp = to_expand[0][1];	
					
					internal_square = fill_internal(x_tmp,y_tmp,sense,sense); 						//Print internal RED Squares
					
					pxy1 = pxy.moveTo(x_tmp,y_tmp);															//Move the cursor in the recursion
					
					//Nord growing vector.
					light_value = pxy1.moveTo(x_tmp,y_tmp-sense).lum();
					if(light_value < lumin && !find_element([x_tmp,y_tmp-sense],expanded)) {
						border.push([x_tmp,y_tmp-sense]);
						fill_border(x_tmp,y_tmp-sense,sense,sense);
					}
					else{
							if(!find_element([x_tmp,y_tmp-sense],expanded) && !find_element([x_tmp,y_tmp-sense],to_expand) ){
								to_expand.push([x_tmp,y_tmp-sense]);
							}
						}
					//Sud growing vector.
					light_value = pxy1.moveTo(x_tmp,y_tmp+sense).lum();
					if(light_value < lumin && !find_element([x_tmp,y_tmp+sense],expanded)) {
						border.push([x_tmp,y_tmp+sense]);
						fill_border(x_tmp,y_tmp+sense,sense,sense);
					}
					else{
							if(!find_element([x_tmp,y_tmp+sense],expanded) && !find_element([x_tmp,y_tmp+sense],to_expand) ){
								to_expand.push([x_tmp, y_tmp+sense]);
							}
						}
					//Ovest growing vector.
					light_value = pxy1.moveTo(x_tmp-sense,y_tmp).lum();
					if(light_value < lumin && !find_element([x_tmp-sense,y_tmp],expanded)) {
						border.push([x_tmp-sense,y_tmp]);						
						fill_border(x_tmp-sense,y_tmp,sense,sense);
					}
					else{
							if(!find_element([x_tmp-sense,y_tmp],expanded) && !find_element([x_tmp-sense,y_tmp],to_expand) ){
								to_expand.push([x_tmp-sense,y_tmp]);
							}
						}
					//Est growing vector.	
					light_value = 	pxy1.moveTo(x_tmp+sense,y_tmp).lum();	
					if(light_value < lumin && !find_element([x_tmp+sense,y_tmp],expanded)) {
						border.push([x_tmp+sense,y_tmp]);						
						fill_border(x_tmp+sense,y_tmp,sense,sense);
					}
					else{
							if(!find_element([x_tmp+sense,y_tmp],expanded) && !find_element([x_tmp+sense,y_tmp],to_expand) ){
								to_expand.push([x_tmp+sense,y_tmp]);
							}
						}
					
					expanded.push([x_tmp,y_tmp]);										//After expansion, we push the current node in the "expanded" array.
					to_expand.shift([x_tmp,y_tmp]);										//After expansion, we delete the current node in "to expand" array.
					//console.log(expanded);
					//console.log(to_expand_2);
					i--;
					check_pix(lumin,border,to_expand,expanded,i,sense);		//Recursive call for the expansion algorithm.
					return border;																//Exit if the "to_expand" array is empty.
				}
		}
		
		
		function check_pix_black(lumin,border,to_expand,expanded,i,sense){
				if(to_expand.length != 0 && i>0){
					
					var x_tmp = to_expand[0][0];
					var y_tmp = to_expand[0][1];	
					
					internal_square = fill_internal(x_tmp,y_tmp,sense,sense); 						//Print internal RED Squares
					
					pxy1 = pxy.moveTo(x_tmp,y_tmp);		
					//Nord growing vector.
					light_value = pxy1.moveTo(x_tmp,y_tmp-sense).lum();
					if(light_value > lumin && !find_element([x_tmp,y_tmp-sense],expanded)) {
						border.push([x_tmp,y_tmp-sense]);
						fill_border(x_tmp,y_tmp-sense,sense,sense);
					}
					else{
							if(!find_element([x_tmp,y_tmp-sense],expanded) && !find_element([x_tmp,y_tmp-sense],to_expand) ){
								to_expand.push([x_tmp,y_tmp-sense]);
							}
						}
					//Sud growing vector.
					light_value = pxy1.moveTo(x_tmp,y_tmp+sense).lum();
					if(light_value > lumin && !find_element([x_tmp,y_tmp+sense],expanded)) {
						border.push([x_tmp,y_tmp+sense]);
						fill_border(x_tmp,y_tmp+sense,sense,sense);
					}
					else{
							if(!find_element([x_tmp,y_tmp+sense],expanded) && !find_element([x_tmp,y_tmp+sense],to_expand) ){
								to_expand.push([x_tmp, y_tmp+sense]);
							}
						}
					//Ovest growing vector.
					light_value = pxy1.moveTo(x_tmp-sense,y_tmp).lum();
					if(light_value > lumin && !find_element([x_tmp-sense,y_tmp],expanded)) {
						border.push([x_tmp-sense,y_tmp]);						
						fill_border(x_tmp-sense,y_tmp,sense,sense);
					}
					else{
							if(!find_element([x_tmp-sense,y_tmp],expanded) && !find_element([x_tmp-sense,y_tmp],to_expand) ){
								to_expand.push([x_tmp-sense,y_tmp]);
							}
						}
					//Est growing vector.	
					light_value = 	pxy1.moveTo(x_tmp+sense,y_tmp).lum();	
					if(light_value > lumin && !find_element([x_tmp+sense,y_tmp],expanded)) {
						border.push([x_tmp+sense,y_tmp]);						
						fill_border(x_tmp+sense,y_tmp,sense,sense);
					}
					else{
							if(!find_element([x_tmp+sense,y_tmp],expanded) && !find_element([x_tmp+sense,y_tmp],to_expand) ){
								to_expand.push([x_tmp+sense,y_tmp]);
							}
						}
					
					expanded.push([x_tmp,y_tmp]);										//After expansion, we push the current node in the "expanded" array.
					to_expand.shift([x_tmp,y_tmp]);										//After expansion, we delete the current node in "to expand" array.
					//console.log(expanded);
					//console.log(to_expand_2);
					i--;
					check_pix_black(lumin,border,to_expand,expanded,i,sense);		//Recursive call for the expansion algorithm.
					return border;																//Exit if the "to_expand" array is empty.
				}
		}
		
		/*----------------------------------------------------------------------------
		-- Initializzation of the supply array:
		-- "to_expand": the container of the new frontier to expand
		-- "expanded": the container of the already visited nodes
		-- "border": the edge frontier of the image
		----------------------------------------------------------------------------*/
		to_expand = new Array();
		expanded = new Array();
		border = new Array();
		
		/*----------------------------------------------------------------------------
		-- On the mouse Click we initialize the begin node for the growing
		-- function, by this we can start wherever we want to grow.
		-- HOW TO CALL GROWING FUNCTION:
		-- check_pix(<lum>,border,to_expand,expanded,<maxium iterations>, <sense>)
		-- <lum>: Luminosity range for the check, if the target is in range
		-- continue growing, else border edge
		-- <maxium iterations>: Limit for the iterations of recursive functions
		-- <sense>: square and movement sensibility, we recomend 2.
		----------------------------------------------------------------------------*/
		function onclick_mouse(begin_x,begin_y){			
		
			lumin = pxy.moveTo(begin_x,begin_y).lum();
			to_expand[0] = [begin_x,begin_y]; 															//Initializzation of the first node.
			
			//console.log(expanded);
			//console.log(to_expand.length);
			
			console.log(lumin);
			sensibility = 25;
			
			
			var  dimension 	= Math.floor(document.getElementById('mini').value);												//Dimensions of the sensibility squares
			
			if(lumin-sensibility > 0){
				border_array = check_pix(lumin-sensibility,border,to_expand,expanded,1000000000,dimension);	//Call for the growing function.			
			}
			else{
				border_array = check_pix_black(3,border,to_expand,expanded,1000000000,dimension);				//Call for the growing function.			
			}
			
		}
		
      }
      
	  /*----------------------------------------------------------------------------
		-- Image canvas CALL.
		----------------------------------------------------------------------------*/
      var imageObj = new Image();
	  
	  function changed(){
		drawImage(imageObj);		
	  };
	  
      imageObj.src = '<?php print($_POST['dataurl']);?>';
	  
	  
	  /*----------------------------------------------------------------------------
		-- UTILS FUNCTION FOR POST THE CANVAS
		----------------------------------------------------------------------------*/
		function showDataURL(){
            var canvas = document.getElementById('myCanvas');
            var context = canvas.getContext('2d'); 
            var dataURL = canvas.toDataURL();
			return dataURL;
        };
		
		function postwith (to,p) {
		  var myForm = document.createElement("form");
		  myForm.method="post" ;
		  myForm.action = to ;
		  var k = 'dataurl';
			var myInput = document.createElement("input") ;
			myInput.setAttribute("name", k) ;
			myInput.setAttribute("value", p);
			myForm.appendChild(myInput) ;
		  document.body.appendChild(myForm) ;
		  myForm.submit() ;
		  document.body.removeChild(myForm) ;
		};
		
		function send_to_segmenter(){
			var url = showDataURL();
			console.log(url);
			postwith('/segmenter/image2segment.php',url);
		}
		</script>
  </head>
  <body onLoad="changed()">
  
  <table BORDER="0">
	<tr>
		<td>
			<canvas id="myCanvas" width="1050" height="600"></canvas>
		</td>
  <td align="justify"><h1>Region Selection</h1> Click on the region you are interested to and Submit it to Segmenter by Clicking on the button "Send to Segmenter".<br><br> <input type="button" value="Send to Segmenter" onClick="send_to_segmenter()" style="width: 100%"></td>
	</tr>
	<tr><td><br><br>Border Approx.:<br> 1 <input type="range" id="mini"  value="1" min="1" max="5" step="1" / style="width: 200px;"> 5
							<div id="minimo">&nbsp;</div><br><br></td></tr>
	<tr>
		<td>
			<canvas id="myCanvas_1" width="1050" height="600"></canvas>
		</td>
	</tr>
	<tr><td></td></tr>
	</table>
	
	
  </body>
</html>

