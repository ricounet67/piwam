<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('association/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('association/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'association/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['nom']->renderLabel() ?></th>
        <td>
          <?php echo $form['nom']->renderError() ?>
          <?php echo $form['nom'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['site_web']->renderLabel() ?></th>
        <td>
          <?php echo $form['site_web']->renderError() ?>
          <?php echo $form['site_web'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['enregistre_par']->renderLabel() ?></th>
        <td>
          <?php echo $form['enregistre_par']->renderError() ?>
          <?php echo $form['enregistre_par'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mis_a_jour_par']->renderLabel() ?></th>
        <td>
          <?php echo $form['mis_a_jour_par']->renderError() ?>
          <?php echo $form['mis_a_jour_par'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
