<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('depense/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>&nbsp;<a href="<?php echo url_for('depense/index') ?>">Annuler</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Supprimer', 'depense/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Sauvegarder" class="button" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <td>Libellé : </td>
        <td>
          <?php echo $form['libelle']->renderError() ?>
          <?php echo $form['libelle'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['montant']->renderLabel() ?> : </td>
        <td>
          <?php echo $form['montant']->renderError() ?>
          <?php echo $form['montant'] ?> &euro;
        </td>
      </tr>
      <tr>
        <td>Compte affecté :</td>
        <td>
          <?php echo $form['compte_id']->renderError() ?>
          <?php echo $form['compte_id'] ?>
        </td>
      </tr>
      <tr>
        <td>Activité liée :</td>
        <td>
          <?php echo $form['activite_id']->renderError() ?>
          <?php echo $form['activite_id'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['date']->renderLabel() ?></td>
        <td>
          <?php echo $form['date']->renderError() ?>
          <?php echo $form['date'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
