<?php
if($_SESSION['statut'] == 'admin')
{
?>
	<h1>Mini-tutoriel d'administration</h1>
	<p>Bienvenue, <?php echo $_SESSION['username']; ?> ! Vous avez le choix entre un menu 'Groupes' et un menu 'Utilisateurs' (Il suffit de cliquer sur respectivement 'Groupes' ou 'Utilisateurs' pour changer de menu).</p>
	
	<p>Dans la barre du haut vous avez deux boutons : 	<?php echo '<img src="'.$CONSTANTES['cheminImages'].'addGroupe.svg" title="Ajouter un groupe" alt="Ajouter un groupe" width="30px"/>'; ?> et <?php echo '<img src="'.$CONSTANTES['cheminImages'].'addUser.svg" title="Ajouter un utilisateur" alt="Ajouter un utilisateur" width="30px"/>'; ?>.<br />
	Le premier sert à ajouter un nouveau groupe, le deuxième est pour ajouter un autre utilisateur.</p>
	<p>Dans le menu 'Groupes' (plus complexe) vous pouvez :
	<ul>
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'groupe.svg" title="Groupe" alt="Groupe" width="30px"/>'; ?>Voir la liste des utilisateurs d'un groupe</li>
		<li>Modifier un groupe (cliquer sur le nom du groupe)</li>
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'addAdmin.svg" title="Ajouter un admin" alt="Ajouter un admin" width="30px"/>'; ?>Ajouter un admin pour ce groupe</li>
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'deleteGroupe.svg" title="Supprimer un groupe" alt="Supprimer un groupe" width="30px"/>'; ?>Supprimer un groupe</li>
		
		<li>Une fois la liste des utilisateurs d'un groupe affichée vous remarquerez que les admins d'un groupe sont repérés par l'image admin <?php echo '<img src="'.$CONSTANTES['cheminImages'].'admin.svg" alt="Admin" title="Admin" width="30px"/>'; ?></li>
		
		
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
	<p>
	
	</p>
<?php
}
elseif($_SESSION['statut'] == 'adminGroupe')
{
?>
	<h1>Mini-tutoriel d'administration</h1>
	<p>Bienvenue, <?php echo $_SESSION['username']; ?> ! Vous avez le choix entre un menu 'Groupes' et un menu 'Utilisateurs' (Il suffit de cliquer sur respectivement 'Groupes' ou 'Utilisateurs' pour changer de menu).</p>
	
	<p>Dans le menu 'Groupes' (plus complexe) vous pouvez :
	<ul>
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'groupe.svg" title="Groupe" alt="Groupe" width="30px"/>'; ?>Voir la liste des utilisateurs d'un groupe</li>
		<li>Modifier un groupe (cliquer sur le nom du groupe)</li>
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'addAdmin.svg" title="Ajouter un admin" alt="Ajouter un admin" width="30px"/>'; ?>Ajouter un admin pour ce groupe</li>
		
		<li>Une fois la liste des utilisateurs d'un groupe affichée vous remarquerez que les admins d'un groupe sont repérés par l'image admin <?php echo '<img src="'.$CONSTANTES['cheminImages'].'admin.svg" alt="Admin" title="Admin" width="30px"/>'; ?></li>
		
		
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'removeAdmin.svg" alt="Supprimer l\'admin" title="Supprimer l\'admin" width="30px"/>'; ?>Vous pouvez à ce moment là supprimer ses droits en tant qu'administrateur du groupe (Il vous sera demandé d'en ajouter un autre s'il est unique)</li>
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'profil.png" alt="Utilisateur" title="Utilisateur" width="30px"/>'; ?>Modifier un utilisateur (cliquer sur son image de profil ou son nom)</li>
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'removeUser.svg" alt="Enlever un utilisateur" title="Enlever un utilisateur" width="30px"/>'; ?>Enlever un utilisateur d'un groupe (pour tous les autres groupes )</li>
	</ul>
	</p>
<?php
}
else
{
?>
	<h1>Bienvenue, <?php echo $_SESSION['username']; ?> !</h1>
	<p> Vous avez le choix entre un menu 'Groupes' et un menu 'Utilisateurs' (Il suffit de cliquer sur respectivement 'Groupes' ou 'Utilisateurs' pour changer de menu).</p>
	
	<p>Dans le menu 'Groupes' (plus complexe) vous pouvez :
	<ul>
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'groupe.svg" title="Groupe" alt="Groupe" width="30px"/>'; ?>Voir la liste des utilisateurs d'un groupe</li>
		
		<li>Une fois la liste des utilisateurs d'un groupe affichée vous remarquerez que les admins d'un groupe sont repérés par l'image admin <?php echo '<img src="'.$CONSTANTES['cheminImages'].'admin.svg" alt="Admin" title="Admin" width="30px"/>'; ?> (n'hésitez pas à les contacter en cas de problèmes)</li>
		
		<li><?php echo '<img src="'.$CONSTANTES['cheminImages'].'profil.png" alt="Utilisateur" title="Utilisateur" width="30px"/>'; ?>Modifier votre profil (cliquer sur votre image de profil ou votre nom)</li>

	</ul>
	</p>
<?php
}
			
		