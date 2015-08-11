		 </dl>
  </div>
		</div>
		<div class="main-panel" id=""><!--large-9 columns-->
			<!--main panel, ici c'est les commandes et tout ... -->
			<h1>Mini-tutoriel d'administration</h1>
			<p>Bienvenue, Admin ! Vous avez le choix entre un menu 'Groupes' et un menu 'Utilisateurs' (Il suffit de cliquer sur respectivement 'Groupes' ou 'Utilisateurs' pour changer de menu).</p>
			
			<p>Dans la barre du haut vous avez deux boutons : 	<?php echo '<img src="'.$CONSTANTES['cheminImages'].'addGroupe.svg" title="Ajouter un groupe" alt="Ajouter un groupe" width="30px"/>'; ?> et <?php echo '<img src="'.$CONSTANTES['cheminImages'].'addUser.svg" title="Ajouter un utilisateur" alt="Ajouter un utilisateur" width="30px"/>'; ?>.<br />
			Le premier sert à ajouter un nouveau groupe, le deuxième est pour ajouter un autre utilisateur.</p>
			<p>Dans le menu 'Groupes' (plus complexe) vous pouvez :
			<ul>
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'groupe.svg" title="Groupe" alt="Groupe" width="30px"/>'; ?>Voir la liste des utilisateurs d'un groupe</li>
				<li>Modifier un groupe (cliquer sur le nom du groupe)</li>
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'addAdmin.svg" title="Ajouter un admin" alt="Ajouter un admin" width="30px"/>'; ?>Ajouter un admin pour ce groupe</li>
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'deleteGroupe.svg" title="Supprimer un groupe" alt="Supprimer un groupe" width="30px"/>'; ?>Supprimer un groupe</li>
				
				Une fois la liste des utilisateurs d'un groupe affichée vous remarquerez que les admins d'un groupe sont repérés par l'image admin <?php echo '<img src="'.$CONSTANTES['cheminImages'].'admin.svg" alt="Admin" title="Admin" width="30px"/>'; ?>
				
				
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'removeAdmin.svg" alt="Supprimer l\'admin" title="Supprimer l\'admin" width="30px"/>'; ?>Vous pouvez à ce moment là supprimer ses droits en tant qu'administrateur du groupe (Il vous sera demandé d'en ajouter un autre s'il est unique)</li>
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'profil.png" alt="Utilisateur" title="Utilisateur" width="30px"/>'; ?>Modifier un utilisateur (cliquer sur son image de profil ou son nom)</li>
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'deleteUser.svg" alt="Supprimer un utilisateur" title="Supprimer un utilisateur" width="30px"/>'; ?>Supprimer un utilisateur (lorsque vous développez le groupe 'all')</li>
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'removeUser.svg" alt="Enlever un utilisateur" title="Enlever un utilisateur" width="30px"/>'; ?>Enlever un utilisateur d'un groupe (pour tous les autres groupes )</li>
			</ul>
			</p>
			<p>Dans le menu 'Utilisateurs' (plus simple) vous avez une vue globale de tous les utilisateurs pour pouvoir simplement :
			<ul>
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'profil.png" alt="Utilisateur" title="Utilisateur" width="30px"/>'; ?>Modifier un utilisateur (cliquer sur son image de profil ou son nom)</li>
				<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'deleteUser.svg" alt="Supprimer un utilisateur" title="Supprimer un utilisateur" width="30px"/>'; ?>Supprimer un utilisateur</li>
			</ul>
			</p>
			
		</div>
	</div>
</div>

<script>
/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );

//fake jQuery
var $ = function(selector){
  return document.querySelector(selector);
}
var accordion = $('.accordion');





//add event listener to all anchor tags with accordion title class
accordion.addEventListener("click",function(e) {
  e.stopPropagation();
  e.preventDefault();
  if(e.target && e.target.nodeName == "A") {
    var classes = e.target.className.split(" ");
    if(classes) {
      for(var x = 0; x < classes.length; x++) {
        if(classes[x] == "accordionTitle") {
          var title = e.target;

          //next element sibling needs to be tested in IE8+ for any crashing problems
          var content = e.target.parentNode.nextElementSibling;
          
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
});
</script>