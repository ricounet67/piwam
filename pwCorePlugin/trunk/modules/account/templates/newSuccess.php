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

<form method="POST" action="<?php echo url_for('account/create') ?>">
  <table class="formtable">
    <tfoot>
      <tr>
        <th>&nbsp;</th>
        <td><input type="submit" value="Valider" class="button blue" /></td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>