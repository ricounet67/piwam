<h2>Mailing</h2>

<form action=""<?php echo url_for('association/mailing') ?>">
<table>
	<tr>
		<td>Objet :</td>
		<td><?php echo $form['subject'] ?></td>
	</tr>
	<tr>
		<td>Message :</td>
		<td><?php echo $form['content'] ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" class="button" value="envoyer" /></td>
	</tr>
</table>
</form>