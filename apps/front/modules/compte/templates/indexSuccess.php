<h1>Compte List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Libelle</th>
      <th>Reference</th>
      <th>Actif</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($compte_list as $compte): ?>
    <tr>
      <td><a href="<?php echo url_for('compte/show?id='.$compte->getId()) ?>"><?php echo $compte->getId() ?></a></td>
      <td><?php echo $compte->getLibelle() ?></td>
      <td><?php echo $compte->getReference() ?></td>
      <td><?php echo $compte->getActif() ?></td>
      <td><?php echo $compte->getCreatedAt() ?></td>
      <td><?php echo $compte->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('compte/new') ?>">New</a>
