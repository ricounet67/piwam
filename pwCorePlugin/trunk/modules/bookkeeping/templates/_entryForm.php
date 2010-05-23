<?php
/* 
 * Partial to display a new EntryForm instance
 */
?>
<table class="formtable">
  <tbody>
    <tr>
      <th><?php echo $form['date']->renderLabel() ?></th>
      <td><?php echo $form['date'] ?></td>
    </tr>
    <tr>
      <th><?php echo $form['label']->renderLabel() ?></th>
      <td><?php echo $form['label'] ?></td>
    </tr>
    <tr>
      <th><?php echo $form['credits']->renderLabel() ?></th>
      <td>
        <table>
          <tbody id="credits_container">
            <!-- Credits input will be dynamically added here -->
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <th><?php echo $form['debits']->renderLabel() ?></th>
      <td>
        <table>
          <tbody id="debits_container">
            <!-- Debits input will be dynamically added here -->
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>

<button id="add_credit" type="button"><?php echo "Ajouter un crédit" ?></button>
<button id="add_debit" type="button"><?php echo "Ajouter un débit" ?></button>