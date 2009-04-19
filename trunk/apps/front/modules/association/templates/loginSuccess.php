<h2>Identification</h2>
<form action="<?php echo url_for('association/login') ?>" method="POST">
<table>
	<tr>
		<td colspan="2"><?php echo $form->renderGlobalErrors() ?></td>
	</tr>
	<tr>
		<td>Nom d'utilisateur :</td>
		<td><?php echo $form['username'] . $form['username']->renderError() ?></td>
	</tr>
	<tr>
		<td>Mot de passe :</td>
		<td><?php echo $form['password'] . $form['password']->renderError() ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="submit" value="S'identifier" class="button" />
		</td>
	</tr>
</table>
</form>

<h2>Nouveau compte</h2>
<p>Pas encore de compte Piwam ? Vous pouvez enregistrer votre association sur <?php echo link_to('la page d\'inscription', 'association/new')?></p>
