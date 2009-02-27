<h1>Recette List</h1>

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
    <?php foreach ($recette_list as $recette): ?>
    <tr>
      <td><a href="<?php echo url_for('recette/show?id='.$recette->getId()) ?>"><?php echo $recette->getId() ?></a></td>
      <td><?php echo $recette->getLibelle() ?></td>
      <td><?php echo $recette->getMontant() ?></td>
      <td><?php echo $recette->getCompteId() ?></td>
      <td><?php echo $recette->getActiviteId() ?></td>
      <td><?php echo $recette->getDate() ?></td>
      <td><?php echo $recette->getCreatedAt() ?></td>
      <td><?php echo $recette->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('recette/new') ?>">New</a>
