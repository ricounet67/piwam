<?php
/* 
 * Partial to display a new EntryForm instance
 */
?>

<div class="global_errors">
  <?php echo $form->renderGlobalErrors() ?>
</div>

<form action="<?php echo url_for('bookkeeping/updateEntry') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>
<table class="formtable">
  <tfoot>
    <tr>
      <td colspan="2">
        <?php echo link_to('Retour', '@bk_overview', array('class' => 'blue button')) ?>
        <input type="submit" value="Valider" class="blue button" />
      </td>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <th><?php echo $form['date']->renderLabel() ?></th>
      <td><?php echo $form['date'] . $form['date']->renderError() ?></td>
    </tr>
    <tr>
      <th><?php echo $form['label']->renderLabel() ?></th>
      <td><?php echo $form['label'] . $form['label']->renderError() ?></td>
    </tr>
    <tr>
      <th><?php echo $form['credits']->renderLabel() ?></th>
      <td>
        <table summary="list of credits">
          <tfoot>
            <tr>
              <td>
                <a id="add_credit"><?php echo image_tag('/pwCorePlugin/images/add.png', array('align' => 'top')) ?> Ajouter un crédit</a>
              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <td id="credits_container">
                <?php $counter = 0 ?>
                <?php foreach ($form['credits'] as $key => $creditForm): ?>
                  <?php include_partial('addCreditForm', array('form' => $creditForm, 'num' => $counter++)) ?>
                <?php endforeach ?>
                <!-- Credits input will be dynamically added here -->
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <th><?php echo $form['debits']->renderLabel() ?></th>
      <td>
        <table summary="list of debits">
          <tfoot>
            <tr>
              <td>
                <a id="add_debit"><?php echo image_tag('/pwCorePlugin/images/add.png', array('align' => 'top')) ?> Ajouter un débit</a>
              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <td id="debits_container">
                <?php $counter = 0 ?>
                <?php foreach ($form['debits'] as $key => $debitForm): ?>
                  <?php include_partial('addDebitForm', array('form' => $debitForm, 'num' => $counter++)) ?>
                <?php endforeach ?>
                <!-- Debits input will be dynamically added here -->
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
</form>