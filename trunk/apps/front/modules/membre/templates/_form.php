<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form
    action="<?php echo url_for('membre/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>><?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" /> <?php endif; ?>
<table>
    <tfoot>
        <tr>
            <td colspan="2">
                <?php echo $form->renderHiddenFields() ?>
                <a href="<?php echo url_for('membre/index') ?>">Annuler</a>
                <?php if (!$form->getObject()->isNew()): ?>
                    &nbsp;<?php echo link_to('Supprimer', 'membre/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Etes vous sur ?')) ?>
                <?php endif; ?>
                <input type="submit" value="Sauvegarder" class="button" />
            </td>
        </tr>
    </tfoot>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <td><?php echo $form['nom']->renderLabel() ?>*</td>
            <td><?php echo $form['nom']->renderError() ?> <?php echo $form['nom'] ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form['prenom']->renderLabel() ?>*</td>
            <td><?php echo $form['prenom']->renderError() ?> <?php echo $form['prenom'] ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form['pseudo']->renderLabel() ?>*</td>
            <td><?php echo $form['pseudo']->renderError() ?> <?php echo $form['pseudo'] ?>
            </td>
        </tr>
        <tr>
            <td>Mot de passe*</td>
            <td><?php echo $form['password']->renderError() ?> <?php echo $form['password'] ?>
            </td>
        </tr>
        <tr>
            <td>Statut</td>
            <td><?php echo $form['statut_id']->renderError() ?> <?php echo $form['statut_id'] ?>
            </td>
        </tr>
        <tr>
            <td>Date d'inscription</td>
            <td><?php echo $form['date_inscription']->renderError() ?> <?php echo $form['date_inscription'] ?>
            </td>
        </tr>
        <tr>
            <td>Exempté de cotisation</td>
            <td><?php echo $form['exempte_cotisation']->renderError() ?> <?php echo $form['exempte_cotisation'] ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form['rue']->renderLabel() ?></td>
            <td><?php echo $form['rue']->renderError() ?> <?php echo $form['rue'] ?>
            </td>
        </tr>
        <tr>
            <td>Code postal</td>
            <td><?php echo $form['cp']->renderError() ?> <?php echo $form['cp'] ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form['ville']->renderLabel() ?></td>
            <td><?php echo $form['ville']->renderError() ?> <?php echo $form['ville'] ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form['pays']->renderLabel() ?></td>
            <td><?php echo $form['pays']->renderError() ?> <?php echo $form['pays'] ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form['email']->renderLabel() ?></td>
            <td><?php echo $form['email']->renderError() ?> <?php echo $form['email'] ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form['website']->renderLabel() ?></td>
            <td><?php echo $form['website']->renderError() ?> <?php echo $form['website'] ?>
            </td>
        </tr>
        <tr>
            <td>Téléphone fixe</td>
            <td><?php echo $form['tel_fixe']->renderError() ?> <?php echo $form['tel_fixe'] ?>
            </td>
        </tr>
        <tr>
            <td>Téléphone portable</td>
            <td><?php echo $form['tel_portable']->renderError() ?> <?php echo $form['tel_portable'] ?>
            </td>
        </tr>
    </tbody>
</table>
</form>
