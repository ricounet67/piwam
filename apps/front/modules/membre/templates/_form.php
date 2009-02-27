<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('membre/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('membre/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'membre/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
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
        <th><?php echo $form['prenom']->renderLabel() ?></th>
        <td>
          <?php echo $form['prenom']->renderError() ?>
          <?php echo $form['prenom'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['pseudo']->renderLabel() ?></th>
        <td>
          <?php echo $form['pseudo']->renderError() ?>
          <?php echo $form['pseudo'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['statut_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['statut_id']->renderError() ?>
          <?php echo $form['statut_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['dateinscription']->renderLabel() ?></th>
        <td>
          <?php echo $form['dateinscription']->renderError() ?>
          <?php echo $form['dateinscription'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['exemptecotis']->renderLabel() ?></th>
        <td>
          <?php echo $form['exemptecotis']->renderError() ?>
          <?php echo $form['exemptecotis'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['rue']->renderLabel() ?></th>
        <td>
          <?php echo $form['rue']->renderError() ?>
          <?php echo $form['rue'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['cp']->renderLabel() ?></th>
        <td>
          <?php echo $form['cp']->renderError() ?>
          <?php echo $form['cp'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['ville']->renderLabel() ?></th>
        <td>
          <?php echo $form['ville']->renderError() ?>
          <?php echo $form['ville'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['pays']->renderLabel() ?></th>
        <td>
          <?php echo $form['pays']->renderError() ?>
          <?php echo $form['pays'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['website']->renderLabel() ?></th>
        <td>
          <?php echo $form['website']->renderError() ?>
          <?php echo $form['website'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['telfixe']->renderLabel() ?></th>
        <td>
          <?php echo $form['telfixe']->renderError() ?>
          <?php echo $form['telfixe'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['telportable']->renderLabel() ?></th>
        <td>
          <?php echo $form['telportable']->renderError() ?>
          <?php echo $form['telportable'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['actif']->renderLabel() ?></th>
        <td>
          <?php echo $form['actif']->renderError() ?>
          <?php echo $form['actif'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['updated_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_at']->renderError() ?>
          <?php echo $form['updated_at'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
