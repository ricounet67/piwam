
<form
  action="<?php echo url_for('@acl_group_'.($form->getObject()->isNew() ? 'create' : 'update?id='.$form->getObject()->getId())) ?>"
  method="post">

  <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <?php endif ?>
    


  <table class="formtable" summary="Register a new Acl Group">

    <!-- Form footer, displays buttons -->

    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          <?php echo link_to('Annuler', '@acl_groups_list', array('class'	=> 'blue button')) ?>

          <!-- Display delete button if object exists -->

          <?php if (!$form->getObject()->isNew()): ?>
             <?php echo link_to('Supprimer', '@acl_group_delete?id=' . $form->getObject()->getId(),
                        array('class' => 'blue button', 'method' => 'delete', 'confirm' => 'Êtes vous sûr ?')) ?>
          <?php endif ?>

          <input type="submit" value="Sauvegarder" class="blue button" />
        </td>
      </tr>
    </tfoot>


    <!-- Form body, displays fields -->

    <tbody>
    	<?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td><?php echo $form['name'] ?><?php echo $form['name']->renderError() ?></td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td><?php echo $form['description'] ?><?php echo $form['description']->renderError() ?></td>
      </tr>
      <tr>
        <th><?php echo $form['selected_new_member']->renderLabel() ?></th>
        <td><?php echo $form['selected_new_member'] ?><?php echo $form['selected_new_member']->renderError() ?></td>
      </tr>
    </tbody>
  </table>
</form>