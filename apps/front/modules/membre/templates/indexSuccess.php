<h1>Membre List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nom</th>
      <th>Prenom</th>
      <th>Pseudo</th>
      <th>Password</th>
      <th>Statut</th>
      <th>Dateinscription</th>
      <th>Exemptecotis</th>
      <th>Rue</th>
      <th>Cp</th>
      <th>Ville</th>
      <th>Pays</th>
      <th>Email</th>
      <th>Website</th>
      <th>Telfixe</th>
      <th>Telportable</th>
      <th>Actif</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($membre_list as $membre): ?>
    <tr>
      <td><a href="<?php echo url_for('membre/show?id='.$membre->getId()) ?>"><?php echo $membre->getId() ?></a></td>
      <td><?php echo $membre->getNom() ?></td>
      <td><?php echo $membre->getPrenom() ?></td>
      <td><?php echo $membre->getPseudo() ?></td>
      <td><?php echo $membre->getPassword() ?></td>
      <td><?php echo $membre->getStatutId() ?></td>
      <td><?php echo $membre->getDateinscription() ?></td>
      <td><?php echo $membre->getExemptecotis() ?></td>
      <td><?php echo $membre->getRue() ?></td>
      <td><?php echo $membre->getCp() ?></td>
      <td><?php echo $membre->getVille() ?></td>
      <td><?php echo $membre->getPays() ?></td>
      <td><?php echo $membre->getEmail() ?></td>
      <td><?php echo $membre->getWebsite() ?></td>
      <td><?php echo $membre->getTelfixe() ?></td>
      <td><?php echo $membre->getTelportable() ?></td>
      <td><?php echo $membre->getActif() ?></td>
      <td><?php echo $membre->getCreatedAt() ?></td>
      <td><?php echo $membre->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('membre/new') ?>">New</a>
