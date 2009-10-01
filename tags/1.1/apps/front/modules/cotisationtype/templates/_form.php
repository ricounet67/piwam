<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('Tooltip') ?>

<form
    action="<?php echo url_for('cotisationtype/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>><?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" /> <?php endif; ?>
<table class="formArray">
    <tfoot>
        <tr>
            <td colspan="2"><?php echo $form->renderHiddenFields() ?> <?php echo link_to('Annuler', 'cotisationtype/index', array(
            	'class'	=> 'formLinkButton'
            	)) ?> <?php if (!$form->getObject()->isNew()): ?> <?php echo link_to('Supprimer', 'cotisationtype/delete?id='.$form->getObject()->getId(), array(
                	'class'		=> 'formLinkButton',
                	'method' 	=> 'delete', 'confirm' => 'Êtes vous sûr ?'
                	)) ?> <?php endif; ?> <input type="submit" value="Enregistrer"
                class="button" /></td>
        </tr>
    </tfoot>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <th>Libellé</th>
            <td><?php echo $form['libelle'] ?><?php echo $form['libelle']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Valide</th>
            <td><?php echo $form['valide'] ?> mois <?php echo $form['valide']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Montant</th>
            <td><?php echo $form['montant'] ?> &euro; <?php echo $form['montant']->renderError() ?>
            </td>
        </tr>
    </tbody>
</table>
</form>
