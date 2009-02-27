<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $membre->getId() ?></td>
    </tr>
    <tr>
      <th>Nom:</th>
      <td><?php echo $membre->getNom() ?></td>
    </tr>
    <tr>
      <th>Prenom:</th>
      <td><?php echo $membre->getPrenom() ?></td>
    </tr>
    <tr>
      <th>Pseudo:</th>
      <td><?php echo $membre->getPseudo() ?></td>
    </tr>
    <tr>
      <th>Password:</th>
      <td><?php echo $membre->getPassword() ?></td>
    </tr>
    <tr>
      <th>Statut:</th>
      <td><?php echo $membre->getStatutId() ?></td>
    </tr>
    <tr>
      <th>Dateinscription:</th>
      <td><?php echo $membre->getDateinscription() ?></td>
    </tr>
    <tr>
      <th>Exemptecotis:</th>
      <td><?php echo $membre->getExemptecotis() ?></td>
    </tr>
    <tr>
      <th>Rue:</th>
      <td><?php echo $membre->getRue() ?></td>
    </tr>
    <tr>
      <th>Cp:</th>
      <td><?php echo $membre->getCp() ?></td>
    </tr>
    <tr>
      <th>Ville:</th>
      <td><?php echo $membre->getVille() ?></td>
    </tr>
    <tr>
      <th>Pays:</th>
      <td><?php echo $membre->getPays() ?></td>
    </tr>
    <tr>
      <th>Email:</th>
      <td><?php echo $membre->getEmail() ?></td>
    </tr>
    <tr>
      <th>Website:</th>
      <td><?php echo $membre->getWebsite() ?></td>
    </tr>
    <tr>
      <th>Telfixe:</th>
      <td><?php echo $membre->getTelfixe() ?></td>
    </tr>
    <tr>
      <th>Telportable:</th>
      <td><?php echo $membre->getTelportable() ?></td>
    </tr>
    <tr>
      <th>Actif:</th>
      <td><?php echo $membre->getActif() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $membre->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $membre->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('membre/edit?id='.$membre->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('membre/index') ?>">List</a>
