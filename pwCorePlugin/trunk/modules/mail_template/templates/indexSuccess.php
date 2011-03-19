<?php use_helper('Image') ?>

<h2>Liste des modèles d'email</h2>

<table class="datalist" summary="list of templates email">
  <thead>
    <tr>
      <th>Identifiant</th>
      <th>Description</th>
      <th width="10%">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($templates as $template): ?>
      <tr>
      	<td><?php echo $template->getTemplateKey() ?></td>
      	<td><?php echo $template->getDescription() ?></td>
      	<td><?php echo clickable_image('/pwCorePlugin/images/icons/edit', '@mail_template_edit?id=' . $template->getId(), '[modifier]') ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
