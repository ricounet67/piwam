<p class="notice">
    Bienvenue dans la version 1.1.2 de Piwam !<br />
    Ceci est une version de développement, des bugs peuvent subsister.
</p>

<h2>Identification</h2>
<form action="<?php echo url_for('association/login') ?>" method="POST">
<table class="formArray">
    <tr>
        <td colspan="2"><?php echo $form->renderGlobalErrors() ?></td>
    </tr>
    <tr>
        <th>Nom d'utilisateur :</th>
        <td><?php echo $form['username'] . $form['username']->renderError() ?></td>
    </tr>
    <tr>
        <th>Mot de passe :</th>
        <td><?php echo $form['password'] . $form['password']->renderError() ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo link_to('Mot de passe oublié ?', 'association/forgottenpassword') ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?php use_helper('Form') ?>
            <input type="submit" value="S'identifier" class="button" name="S'identifier" />
        </td>
    </tr>
</table>
</form>

<!-- If multi mode -->
<?php if ($displayRegisterLink): ?>

    <h2>Nouveau compte</h2>
    <p>Pas encore de compte Piwam ? Vous pouvez enregistrer votre association sur <?php echo link_to('la page d\'inscription', 'association/new')?></p>

<?php else: ?>

    <h2>S'inscrire</h2>
    <?php echo link_to('Créer un compte',  'membre/requestsubscription') ?>

<?php endif; ?>