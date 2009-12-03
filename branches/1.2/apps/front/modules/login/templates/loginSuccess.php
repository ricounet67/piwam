<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/favicon.ico" />
</head>
<body>

    <!-- Set Jquery's noConflict mode -->

    <script type="text/javascript">var J = jQuery.noConflict();</script>

    <div id="login">
        <h1>Piwam</h1>

        <form action="<?php echo url_for('@login') ?>" method="post">
        <table class="formtable">
            <tr>
                <td colspan="2">
                    <h2>Authentification</h2>
                    <?php echo $form->renderGlobalErrors() ?>
                </td>
            </tr>
            <tr>
                <th>
                    Nom d'utilisateur<br />
                    <?php echo $form['username']->renderError() ?>
                </th>
                <td>
                    <div class="input">
                        <?php echo $form['username'] ?>
                    </div>
                </td>
            </tr>
            <tr>
                <th>
                    Mot de passe<br />
                    <?php echo $form['password']->renderError() ?>
                </th>
                <td>
                    <div class="input">
                        <?php echo $form['password'] ?>
                        <?php echo link_to('Mot de passe oublié ?', 'association/forgottenpassword') ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2"><h2>Ou utilisez OpenID</h2></td>
            </tr>
            <tr>
                <th>
                    Open ID<br />
                    <?php echo $form['openid']->renderError() ?>
                </th>
                <td>
                    <div class="input">
                        <?php echo $form['openid'] ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="S'identifier" class="button" name="S'identifier" />
                </td>
            </tr>
        </table>
        </form>

    </div>
</body>
</html>
