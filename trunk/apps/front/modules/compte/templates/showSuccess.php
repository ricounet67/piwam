<h2>Détails du compte <?php echo $compte->getReference() ?></h2>


<table>
  <tbody>
    <tr>
      <td>Libellé :</td>
      <td><?php echo $compte->getLibelle() ?></td>
    </tr>
    <tr>
      <td>Référence :</td>
      <td><?php echo $compte->getReference() ?></td>
    </tr>
    <tr>
      <td>Enregistré le :</td>
      <td><?php echo $compte->getCreatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('compte/edit?id='.$compte->getId()) ?>">Editer</a>
&bull;
<a href="<?php echo url_for('compte/index') ?>">Retour &agrave; la liste</a>
