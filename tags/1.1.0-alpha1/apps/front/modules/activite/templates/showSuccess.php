<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $activite->getId() ?></td>
    </tr>
    <tr>
      <th>Libelle:</th>
      <td><?php echo $activite->getLibelle() ?></td>
    </tr>
    <tr>
      <th>Actif:</th>
      <td><?php echo $activite->getActif() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $activite->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $activite->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('activite/edit?id='.$activite->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('activite/index') ?>">List</a>
