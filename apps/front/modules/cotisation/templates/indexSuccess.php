<h1>Cotisation List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Compte</th>
      <th>Cotisation type</th>
      <th>Membre</th>
      <th>Date</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cotisation_list as $cotisation): ?>
    <tr>
      <td><a href="<?php echo url_for('cotisation/show?id='.$cotisation->getId()) ?>"><?php echo $cotisation->getId() ?></a></td>
      <td><?php echo $cotisation->getCompteId() ?></td>
      <td><?php echo $cotisation->getCotisationTypeId() ?></td>
      <td><?php echo $cotisation->getMembreId() ?></td>
      <td><?php echo $cotisation->getDate() ?></td>
      <td><?php echo $cotisation->getCreatedAt() ?></td>
      <td><?php echo $cotisation->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('cotisation/new') ?>">New</a>
