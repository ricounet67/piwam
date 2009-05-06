<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('Javascript') ?>

<form
    action="<?php
    	if (!isset($first)) {
    		echo url_for('membre/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : ''));
    	}
    	else {
    		echo url_for('membre/firstcreate');
    	}
    	?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
		<input type="hidden" name="sf_method" value="put" />
	<?php endif; ?>
<table class="formArray">
    <tfoot>
        <tr>
            <td colspan="2">
                <?php echo $form->renderHiddenFields() ?>


                <?php if (!isset($first)): ?>
	                <?php echo link_to('Annuler', 'membre/index', array(
	                	'class'	=> 'formLinkButton'
	                )) ?>
                <?php endif; ?>

                <?php if (!$form->getObject()->isNew()): ?>
                	<?php echo link_to('Supprimer', 'membre/delete?id='.$form->getObject()->getId(), array(
                		'class'		=> 'formLinkButton',
                		'method' 	=> 'delete', 'confirm' => 'Etes vous sûr ?'
                	)) ?>
                <?php endif; ?>

                <?php if ((isset($first)) && ($first)): ?>
	                <input type="submit" value="Étape suivante >" class="button" />
	            <?php else: ?>
	            	<input type="submit" value="Sauvegarder" class="button" />
	            <?php endif; ?>
            </td>
        </tr>
    </tfoot>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <th><?php echo $form['nom']->renderLabel() ?>*</th>
            <td><?php echo $form['nom'] ?><?php echo $form['nom']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['prenom']->renderLabel() ?>*</th>
            <td><?php echo $form['prenom'] ?><?php echo $form['prenom']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Pseudo <?php echo ($form->isFirstRegistration()) ? '*' : ''; ?></th>
            <td><?php echo $form['pseudo'] ?><?php echo $form['pseudo']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Mot de passe <?php echo ($form->isFirstRegistration()) ? '*' : ''; ?></th>
            <td>
            	<?php echo $form['password'] ?><?php echo $form['password']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Statut</th>
            <td><?php echo $form['statut_id'] ?><?php echo $form['statut_id']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Date d'inscription</th>
            <td><?php echo $form['date_inscription'] ?><?php echo $form['date_inscription']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Exempté de cotisation</th>
            <td>
            	<?php echo $form['exempte_cotisation'] ?><?php echo $form['exempte_cotisation']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['rue']->renderLabel() ?></th>
            <td><?php echo $form['rue'] ?><?php echo $form['rue']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Code postal</th>
            <td><?php echo $form['cp'] ?><?php echo $form['cp']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['ville']->renderLabel() ?></th>
            <td><?php echo $form['ville'] ?><?php echo $form['ville']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['pays']->renderLabel() ?></th>
            <td><?php echo $form['pays'] ?><?php echo $form['pays']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['email']->renderLabel() ?></th>
            <td><?php echo $form['email'] ?><?php echo $form['email']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Site internet/blog</th>
            <td><?php echo $form['website'] ?><?php echo $form['website']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Téléphone fixe</th>
            <td><?php echo $form['tel_fixe'] ?><?php echo $form['tel_fixe']->renderError() ?>
            </td>
        </tr>
        <tr>
            <th>Téléphone portable</th>
            <td><?php echo $form['tel_portable'] ?><?php echo $form['tel_portable']->renderError() ?>
            </td>
        </tr>
    </tbody>
</table>
</form>
