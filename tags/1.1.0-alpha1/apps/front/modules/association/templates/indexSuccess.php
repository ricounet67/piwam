<h1>Association List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nom</th>
      <th>Description</th>
      <th>Site web</th>
      <th>Enregistre par</th>
      <th>Mis a jour par</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($association_list as $association): ?>
    <tr>
      <td><a href="<?php echo url_for('association/edit?id='.$association->getId()) ?>"><?php echo $association->getId() ?></a></td>
      <td><?php echo $association->getNom() ?></td>
      <td><?php echo $association->getDescription() ?></td>
      <td><?php echo $association->getSiteWeb() ?></td>
      <td><?php echo $association->getEnregistrePar() ?></td>
      <td><?php echo $association->getMisAJourPar() ?></td>
      <td><?php echo $association->getCreatedAt() ?></td>
      <td><?php echo $association->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('association/new') ?>">New</a>
