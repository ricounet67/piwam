<h2>Mailing</h2>

<?php if ($sf_user->hasFlash('notice')): ?>
  <?php echo '<p class="notice">' . $sf_user->getFlash('notice') . '</p>' ?>
<?php endif; ?>

<form action=""<?php echo url_for('association/mailing') ?>" method="POST">
<table>
	<tr>
		<td>Objet :</td>
		<td><?php echo $form['subject'] ?></td>
	</tr>
	<tr>
		<td>Message :</td>
		<td><?php echo $form['mail_content'] ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" class="button" value="envoyer" /></td>
	</tr>
</table>
</form>