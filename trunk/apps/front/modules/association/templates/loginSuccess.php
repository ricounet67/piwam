<p class="notice">Ce programme est en version Beta et peut contenir des bugs.<br />
En cas de problème n'hésitez pas à <a
    href="http://code.google.com/p/piwam/issues/entry">rapporter un bug</a>.</p>

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
        <td><input type="submit" value="S'identifier" class="button"
            name="S'identifier" /></td>
    </tr>
</table>
</form>

<h2>Nouveau compte</h2>
<p>Pas encore de compte Piwam ? Vous pouvez enregistrer votre association sur <?php echo link_to('la page d\'inscription', 'association/new')?></p>
