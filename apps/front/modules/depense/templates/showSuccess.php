<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $depense->getId() ?></td>
    </tr>
    <tr>
      <th>Libelle:</th>
      <td><?php echo $depense->getLibelle() ?></td>
    </tr>
    <tr>
      <th>Montant:</th>
      <td><?php echo $depense->getMontant() ?></td>
    </tr>
    <tr>
      <th>Compte:</th>
      <td><?php echo $depense->getCompteId() ?></td>
    </tr>
    <tr>
      <th>Activite:</th>
      <td><?php echo $depense->getActiviteId() ?></td>
    </tr>
    <tr>
      <th>Date:</th>
      <td><?php echo $depense->getDate() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $depense->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $depense->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('depense/edit?id='.$depense->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('depense/index') ?>">List</a>
