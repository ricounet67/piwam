<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('cotisation/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('cotisation/index') ?>">Annuler</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'cotisation/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Sauvegarder" class="button" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <td>Compte bénéficiaire :</td>
        <td>
          <?php echo $form['compte_id']->renderError() ?>
          <?php echo $form['compte_id'] ?>
        </td>
      </tr>
      <tr>
        <td>Type de cotisation</td>
        <td>
          <?php echo $form['cotisation_type_id']->renderError() ?>
          <?php echo $form['cotisation_type_id'] ?>
        </td>
      </tr>
      <tr>
        <td>Membre :</td>
        <td>
          <?php echo $form['membre_id']->renderError() ?>
          <?php echo $form['membre_id'] ?>
        </td>
      </tr>
      <tr>
        <td>Date de versement :</td>
        <td>
          <?php echo $form['date']->renderError() ?>
          <?php echo $form['date'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
