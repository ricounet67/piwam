<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<h2>E-mail envoyé</h2>

<table class="details">
  <tbody>
    <tr>
      <th>Envoyé le</th>
      <td><?php echo $email->getCreatedAt() ?> par <?php echo $email->getSentByMember() ?></td>
    </tr>
    <tr>
      <th>Destinataires</th>
      <td><?php foreach($email->getAddresses() as $key => $value) { echo $value.', '; } ?></td>
    </tr>
    <tr>
      <th>Sujet</th>
      <td><?php echo $email->getObject() ?></td>
    </tr>
    <tr>
      <th>Contenu</th>
      <td><?php echo html_entity_decode($email->getMessage()) ?></td>
    </tr>
    <tr>
      <th>Nombre d'envois avec succès</th>
      <td><?php echo $email->getSuccess() ?></td>
    </tr>
    <tr>
      <th>Nombre d'erreurs</th>
      <td><?php echo $email->getErrors() ?></td>
    </tr>
  </tbody>
</table>