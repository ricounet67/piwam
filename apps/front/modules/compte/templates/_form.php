<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('compte/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="formArray">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          <?php echo link_to('Annuler', 'compte/index', array(
            	'class'	=> 'formLinkButton'
            )) ?>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Supprimer', 'compte/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Sauvegarder" class="button" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th>Libellé</th>
        <td>
          <?php echo $form['libelle'] ?>
          <?php echo $form['libelle']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th>Référence</th>
        <td>
          <?php echo $form['reference'] ?>
          <?php echo $form['reference']->renderError() ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
