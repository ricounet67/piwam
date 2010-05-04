<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use_helper('Date');
?>
<h2>E-mails envoyés</h2>

<table class="datalist" summary="Sent emails">
  <thead>
    <tr>
      <th width="130px">Date d'envoi</th>
      <th>Sujet</th>
      <th width="60px">Succès</th>
      <th width="60px">Erreurs</th>
      <th width="100px">Actions</th>
    </tr>
  </thead>
  <tbody>

    <?php foreach ($emails->getResults() as $email): ?>
      <?php include_partial('emailRow', array('email' => $email)) ?>
    <?php endforeach ?>

  </tbody>
</table>

<?php include_partial('global/pager', array('pager' => $emails, 'route' => '@mailing_list', 'params' => array())) ?>