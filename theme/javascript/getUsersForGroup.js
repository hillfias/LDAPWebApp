function getUsersForGroup(group) {
	
	

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

			xhr.onreadystatechange = function()
			{
				
				if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					
					var mydata=eval("("+xhr.responseText+")"); //retrieve result as an JavaScript object
					
					// on affiche les données et on toggle le menu
					
					var output='';
					if(mydata.length == 0)
					{
						output+='<p>';
						output+='Erreur : '+mydata.erreur;
						output+='</p>';
					}
					else
					{
						for (var i=0; i<mydata.length; i++)
						{
							output+='<p>';
							output+='<img class="imageprofil" src="data:image/jpeg;base64,'+ mydata[i].photo +'" width="25px" />';
							if(mydata[i].isAdmin == "true")
							{
								output+= '<span class="icon-admin icon-admin-menu" title="Administrateur" alt="Administrateur"></span>';
							}
							output+='<strong onclick="alert(\'tadaaa\');" style="cursor:pointer;">'+mydata[i].forname+' '+mydata[i].lastname+'</strong>';
							if(mydata[i].isRemovable == "true")
							{
								if(group == 'admin') output+= '<a href="" class="right icon-remove-admin" title="Supprimer les droits admin" onclick="kickUser(\''+mydata[i].pseudo+'\',\''+group+'\'); return false;"></a>';
								else output+= '<a href="" class="right icon-remove-user" title="Enlever l\'utilisateur de ce groupe" onclick="kickUser(\''+mydata[i].pseudo+'\',\''+group+'\'); return false;"></a>';
							}
							else
							{
								output+= '<a href="" class="right icon-delete-user" title="Supprimer l\'utilisateur" onclick="deleteUser(\''+mydata[i].pseudo+'\'); return false;"></a>';
							}
							if(mydata[i].isAdminRemovable == "true")
							{
								output+= '<a href="" class="right icon-remove-admin" title="Supprimer les droits admin"></a>';
							}
							output+='</p>';
						}
					}
				   
					document.getElementById(group).innerHTML=output;
				   
					var classes = document.getElementById('title'+group).className.split(" ");
					if(classes)
					{
						for(var x = 0; x < classes.length; x++)
						{
						   
							if(classes[x] == "accordionTitle")
							{
								var title = document.getElementById('title'+group);

								//next element sibling needs to be tested in IE8+ for any crashing problems
								var content = document.getElementById('title'+group).parentNode.nextElementSibling;
							  
								//use classie to then toggle the active class which will then open and close the accordion
							 
								classie.toggle(title, 'accordionTitleActive');
								//this is just here to allow a custom animation to treat the content
								if(classie.has(content, 'accordionItemCollapsed'))
								{
									if(classie.has(content, 'animateOut'))
									{
										classie.remove(content, 'animateOut');
									}
									
									classie.add(content, 'animateIn');

								}
								else
								{
									classie.remove(content, 'animateIn');
									classie.add(content, 'animateOut');
								}
								
								//remove or add the collapsed state
								classie.toggle(content, 'accordionItemCollapsed');
							}
						}
					}
				}
			};
			
			xhr.open("POST", "api/getUsersForGroup.php", true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
			xhr.send("attributes=jpegphotoSTOPgivennameSTOPsnSTOPcn&group=" + group);
			
		}

}