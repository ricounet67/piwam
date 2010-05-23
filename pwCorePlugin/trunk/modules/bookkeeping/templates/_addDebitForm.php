<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<table class="formtable" id="debit_<?php echo $num ?>">
  <tr>
    <th>Supprimer</th>
    <td><a href="#" onclick="deleteDebit(<?php echo $num ?>);return false;"> Supprimer</a></td>
  </tr>
  <tr>
    <th><?php echo $form['amount']->renderLabel() ?></th>
    <td><?php echo $form['amount']->render() ?><td>
  </tr>
  <tr>
    <th><?php echo $form['debited_account']->renderLabel() ?></th>
    <td><?php echo $form['debited_account']->render() ?><td>
  </tr>
  <tr>
    <th><?php echo $form['label']->renderLabel() ?></th>
    <td><?php echo $form['label']->render() ?><td>
  </tr>
</table>