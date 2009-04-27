<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $statut->getId() ?></td>
    </tr>
    <tr>
      <th>Nom:</th>
      <td><?php echo $statut->getNom() ?></td>
    </tr>
    <tr>
      <th>Actif:</th>
      <td><?php echo $statut->getActif() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $statut->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $statut->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('statut/edit?id='.$statut->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('statut/index') ?>">List</a>
