<h1>Activite List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Libelle</th>
      <th>Actif</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($activite_list as $activite): ?>
    <tr>
      <td><a href="<?php echo url_for('activite/show?id='.$activite->getId()) ?>"><?php echo $activite->getId() ?></a></td>
      <td><?php echo $activite->getLibelle() ?></td>
      <td><?php echo $activite->getActif() ?></td>
      <td><?php echo $activite->getCreatedAt() ?></td>
      <td><?php echo $activite->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('activite/new') ?>">New</a>
