<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

?>

<table class="datalist" summary="list of enabled accounts">
  <thead>
    <tr>
      <th>Numéro</th>
      <th>Label</th>
      <th width="100px">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($accounts as $account): ?>
      <?php include_partial('accountRow', array('account' => $account, 'depth' => 0)) ?>
    <?php endforeach ?>
  </tbody>
</table>
