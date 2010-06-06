<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<h2>Ajouter un nouveau compte</h2>

<div class="global_errors">
  <?php echo $form->renderGlobalErrors() ?>
</div>

<form method="POST" action="<?php echo url_for('account/create') ?>">
  <table class="formtable">
    <tfoot>
      <tr>
        <th>&nbsp;</th>
        <td><input type="submit" value="Valider" class="button blue" /></td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderHiddenFields() ?>
      <tr>
        <th>Compte parent</th>
        <td><?php echo $parent ?></td>
      </tr>
      <tr>
        <th><?php echo $form['code']->renderLabel() ?></th>
        <td>
          <?php echo $form['code'] . $form['code']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['label']->renderLabel() ?></th>
        <td><?php echo $form['label'] . $form['label']->renderError() ?></td>
      </tr>
    </tbody>
  </table>
</form>