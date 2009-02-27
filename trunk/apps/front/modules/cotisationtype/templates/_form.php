<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form
    action="<?php echo url_for('cotisationtype/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>><?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" /> <?php endif; ?>
<table>
    <tfoot>
        <tr>
            <td colspan="2"><?php echo $form->renderHiddenFields() ?> &nbsp;<a
                href="<?php echo url_for('cotisationtype/index') ?>">Cancel</a>
                <?php if (!$form->getObject()->isNew()): ?> &nbsp;<?php echo link_to('Delete', 'cotisationtype/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
                <?php endif; ?> <input type="submit" value="Enregistrer" class="button" /></td>
        </tr>
    </tfoot>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <th><?php echo $form['libelle']->renderLabel() ?></th>
            <td><?php echo $form['libelle']->renderError() ?> <?php echo $form['libelle'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['valide']->renderLabel() ?></th>
            <td><?php echo $form['valide']->renderError() ?> <?php echo $form['valide'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['montant']->renderLabel() ?></th>
            <td><?php echo $form['montant']->renderError() ?> <?php echo $form['montant'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['actif']->renderLabel() ?></th>
            <td><?php echo $form['actif']->renderError() ?> <?php echo $form['actif'] ?>
            </td>
        </tr>
    </tbody>
</table>
</form>
