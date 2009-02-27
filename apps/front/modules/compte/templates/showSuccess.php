<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $compte->getId() ?></td>
    </tr>
    <tr>
      <th>Libelle:</th>
      <td><?php echo $compte->getLibelle() ?></td>
    </tr>
    <tr>
      <th>Reference:</th>
      <td><?php echo $compte->getReference() ?></td>
    </tr>
    <tr>
      <th>Actif:</th>
      <td><?php echo $compte->getActif() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $compte->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $compte->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('compte/edit?id='.$compte->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('compte/index') ?>">List</a>
