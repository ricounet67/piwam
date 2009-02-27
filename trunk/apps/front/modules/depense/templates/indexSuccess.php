<h1>Depense List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Libelle</th>
      <th>Montant</th>
      <th>Compte</th>
      <th>Activite</th>
      <th>Date</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($depense_list as $depense): ?>
    <tr>
      <td><a href="<?php echo url_for('depense/show?id='.$depense->getId()) ?>"><?php echo $depense->getId() ?></a></td>
      <td><?php echo $depense->getLibelle() ?></td>
      <td><?php echo $depense->getMontant() ?></td>
      <td><?php echo $depense->getCompteId() ?></td>
      <td><?php echo $depense->getActiviteId() ?></td>
      <td><?php echo $depense->getDate() ?></td>
      <td><?php echo $depense->getCreatedAt() ?></td>
      <td><?php echo $depense->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('depense/new') ?>">New</a>
