<p class="notice">
	Ce programme est en version Alpha et peut contenir des bugs.<br />
	Des mises à jour sont rapidement mises en place sur <a href="http://piwam.googlecode.com">le site du projet</a>.
</p>

<h2>Identification</h2>
<form action="<?php echo url_for('association/login') ?>" method="POST">
<table class="formArray">
	<tr>
		<td colspan="2"><?php echo $form->renderGlobalErrors() ?></td>
	</tr>
	<tr>
		<th>Nom d'utilisateur :</th>
		<td><?php echo $form['username'] . $form['username']->renderError() ?></td>
	</tr>
	<tr>
		<th>Mot de passe :</th>
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