<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('JavascriptBase') ?>
<?php use_helper('Tooltip') ?>

<form
  action="<?php echo url_for('@duetype_'.($form->getObject()->isNew() ? 'create' : 'update?id='.$form->getObject()->getId())) ?>"
  method="post"
  <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

  <?php if (!$form->getObject()->isNew()): ?>
      <input type="hidden" name="sf_method" value="put" />
  <?php endif ?>

  <div class="global_errors">
    <?php echo $form->renderGlobalErrors() ?>
  </div>

  <table class="formtable" summary="Register a new Fee">

    <!-- Form footer, displays buttons -->

    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          <?php echo link_to('Annuler', '@duetypes_list', array('class'	=> 'blue button')) ?>

          <!-- Display delete button if object exists -->

          <?php if (!$form->getObject()->isNew()): ?>
             <?php echo link_to('Supprimer', '@duetype_delete?id=' . $form->getObject()->getId(),
                        array('class' => 'blue button', 'method' => 'delete', 'confirm' => 'Êtes vous sûr ?')) ?>
          <?php endif ?>

          <input type="submit" value="Enregistrer" class="blue button" />
        </td>
      </tr>
    </tfoot>


    <!-- Form body, displays fields -->

    <tbody>
      <tr>
        <th><?php echo $form['label']->renderLabel() ?></th>
        <td><?php echo $form['label'] ?><?php echo $form['label']->renderError() ?></td>
      </tr>
      <tr>
        <th><?php echo $form['amount']->renderLabel() ?></th>
        <td><?php echo $form['amount'] ?> &euro; <?php echo $form['amount']->renderError() ?></td>
      </tr>
      <tr class="subitem">
        <th colspan="2">Valide sur la période</th>
      </tr>
      <tr>
        <th><?php echo $form['start_period']->renderLabel() ?></th>
        <td><?php echo $form['start_period'] ?> <?php echo $form['start_period']->renderError() ?></td>
      </tr>
      <tr>
        <th><?php echo $form['end_period']->renderLabel() ?></th>
        <td><?php echo $form['end_period'] ?> <?php echo $form['end_period']->renderError() ?></td>
      </tr>
      <tr class="subitem">
        <th colspan="2">ou</th>
      </tr>
      <tr>
        <th><?php echo $form['period']->renderLabel() ?></th>
        <td><?php echo $form['period'] ?> mois <?php echo $form['period']->renderError() ?></td>
      </tr>
    </tbody>
  </table>
</form>