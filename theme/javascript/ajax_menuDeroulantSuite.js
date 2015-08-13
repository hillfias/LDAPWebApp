function request(group,callback) {
	var classes = document.getElementById('title'+group).className.split(" ");
		if(typeof classes[1] !== 'undefined') {
		 
		   if(classes[1] == "accordionTitleActive") {
				var title = document.getElementById('title'+group);

			  //next element sibling needs to be tested in IE8+ for any crashing problems
			  var content = document.getElementById('title'+group).parentNode.nextElementSibling;
			  
			  //use classie to then toggle the active class which will then open and close the accordion
			 
			  classie.toggle(title, 'accordionTitleActive');
			  //this is just here to allow a custom animation to treat the content
			  if(classie.has(content, 'accordionItemCollapsed')) {
				if(classie.has(content, 'animateOut')){
				  classie.remove(content, 'animateOut');
				}
				classie.add(content, 'animateIn');

			  }else{
				 classie.remove(content, 'animateIn');
				 classie.add(content, 'animateOut');
			  }
			  //remove or add the collapsed state
			  classie.toggle(content, 'accordionItemCollapsed');
			}
		}
		else
		{

		var xhr = new XMLHttpRequest();

		

		xhr.onreadystatechange = function() {

			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {

				var jsondata=eval("("+xhr.responseText+")"); //retrieve result as an JavaScript object
				var mydata=jsondata.items;
				callback(group,mydata);

			}

		};

		

		xhr.open("POST", "ldap/getData.php", true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		xhr.send("group=" + group);
		}

}


function readData(group,mydata) {

	 var output='';
   for (var i=0; i<mydata.length; i++){
	output+='<p>';
	output+='<img class="imageprofil" src="data:image/jpeg;base64,'+ mydata[i].photo +'" width="25px" />';
	output+=mydata[i].yes;
	output+='<strong>'+mydata[i].forname+' '+mydata[i].lastname+'</strong>';
	output+=mydata[i].yes2;
	output+=mydata[i].yes3;
	output+='</p>';
   }
   
   document.getElementById(group).innerHTML=output;
   
	
		
		
		
		var classes = document.getElementById('title'+group).className.split(" ");
		if(classes) {
		  for(var x = 0; x < classes.length; x++) {
		   
			if(classes[x] == "accordionTitle") {
			  var title = document.getElementById('title'+group);

			  //next element sibling needs to be tested in IE8+ for any crashing problems
			  var content = document.getElementById('title'+group).parentNode.nextElementSibling;
			  
			  //use classie to then toggle the active class which will then open and close the accordion
			 
			  classie.toggle(title, 'accordionTitleActive');
			  //this is just here to allow a custom animation to treat the content
			  if(classie.has(content, 'accordionItemCollapsed')) {
				if(classie.has(content, 'animateOut')){
				  classie.remove(content, 'animateOut');
				}
				classie.add(content, 'animateIn');

			  }else{
				 classie.remove(content, 'animateIn');
				 classie.add(content, 'animateOut');
			  }
			  //remove or add the collapsed state
			  classie.toggle(content, 'accordionItemCollapsed');



			  
			}
			
			
			 
			
			
		  }
		}
		
		

	
	
	
	
  

	
}