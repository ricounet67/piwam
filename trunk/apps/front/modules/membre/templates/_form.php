<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form
    action="<?php echo url_for('membre/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>><?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" /> <?php endif; ?>
<table class="formArray">
    <tfoot>
        <tr>
            <td colspan="2">
                <?php echo $form->renderHiddenFields() ?>
                <?php echo link_to('Annuler', 'membre/index', array(
                	'class'	=> 'formLinkButton'
                )) ?>
                <?php if (!$form->getObject()->isNew()): ?>
                	<?php echo link_to('Supprimer', 'membre/delete?id='.$form->getObject()->getId(), array(
                		'class'		=> 'formLinkButton',
                		'method' 	=> 'delete', 'confirm' => 'Etes vous sûr ?'
                	)) ?>
                <?php endif; ?>
                <input type="submit" value="Sauvegarder" class="button" />
            </td>
        </tr>
    </tfoot>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <th><?php echo $form['nom']->renderLabel() ?>*</th>
            <td><?php echo $form['nom']->renderError() ?> <?php echo $form['nom'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['prenom']->renderLabel() ?>*</th>
            <td><?php echo $form['prenom']->renderError() ?> <?php echo $form['prenom'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['pseudo']->renderLabel() ?>*</th>
            <td><?php echo $form['pseudo']->renderError() ?> <?php echo $form['pseudo'] ?>
            </td>
        </tr>
        <tr>
            <th>Mot de passe*</th>
            <td><?php echo $form['password']->renderError() ?> <?php echo $form['password'] ?>
            </td>
        </tr>
        <tr>
            <th>Statut</th>
            <td><?php echo $form['statut_id']->renderError() ?> <?php echo $form['statut_id'] ?>
            </td>
        </tr>
        <tr>
            <th>Date d'inscription</th>
            <td><?php echo $form['date_inscription']->renderError() ?> <?php echo $form['date_inscription'] ?>
            </td>
        </tr>
        <tr>
            <th>Exempté de cotisation</th>
            <td><?php echo $form['exempte_cotisation']->renderError() ?> <?php echo $form['exempte_cotisation'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['rue']->renderLabel() ?></th>
            <td><?php echo $form['rue']->renderError() ?> <?php echo $form['rue'] ?>
            </td>
        </tr>
        <tr>
            <th>Code postal</th>
            <td><?php echo $form['cp']->renderError() ?> <?php echo $form['cp'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['ville']->renderLabel() ?></th>
            <td><?php echo $form['ville']->renderError() ?> <?php echo $form['ville'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['pays']->renderLabel() ?></th>
            <td><?php echo $form['pays']->renderError() ?> <?php echo $form['pays'] ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form['email']->renderLabel() ?></th>
            <td><?php echo $form['email']->renderError() ?> <?php echo $form['email'] ?>
            </td>
        </tr>
        <tr>
            <th>Site internet/blog</th>
            <td><?php echo $form['website']->renderError() ?> <?php echo $form['website'] ?>
            </td>
        </tr>
        <tr>
            <th>Téléphone fixe</th>
            <td><?php echo $form['tel_fixe']->renderError() ?> <?php echo $form['tel_fixe'] ?>
            </td>
        </tr>
        <tr>
            <th>Téléphone portable</th>
            <td><?php echo $form['tel_portable']->renderError() ?> <?php echo $form['tel_portable'] ?>
            </td>
        </tr>
    </tbody>
</table>
</form>
