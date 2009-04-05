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
