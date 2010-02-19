<h2>Configurer</h2>

<h3>Listes des champs supplémentaires :</h3>

<table>
<?php foreach($extraRows as $row): ?>
  <tr>
    <td><?php echo $row->getLabel() ?></td>
    <td><?php echo $row->getType() ?></td>
  </tr>
<?php endforeach ?>
</table>

<h3>Ajouter un champ :</h3>
<form action="<?php echo url_for('@config_members') ?>" method="post">
<table class="formtable">
  <?php echo $form ?>
  <tr><td colspan="2"><input type="submit" /></td></tr>
</table>
</form>