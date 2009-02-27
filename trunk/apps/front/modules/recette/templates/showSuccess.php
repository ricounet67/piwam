<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $recette->getId() ?></td>
    </tr>
    <tr>
      <th>Libelle:</th>
      <td><?php echo $recette->getLibelle() ?></td>
    </tr>
    <tr>
      <th>Montant:</th>
      <td><?php echo $recette->getMontant() ?></td>
    </tr>
    <tr>
      <th>Compte:</th>
      <td><?php echo $recette->getCompteId() ?></td>
    </tr>
    <tr>
      <th>Activite:</th>
      <td><?php echo $recette->getActiviteId() ?></td>
    </tr>
    <tr>
      <th>Date:</th>
      <td><?php echo $recette->getDate() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $recette->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $recette->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('recette/edit?id='.$recette->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('recette/index') ?>">List</a>
