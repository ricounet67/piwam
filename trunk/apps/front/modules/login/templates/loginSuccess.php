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
        <h1>Piwam 1.2-dev</h1>

        <?php if ($sf_user->hasFlash('error')):?>
            <p class="error">
                <?php echo image_tag('error', array('alt' => '[erreur]', 'align' => 'top')) . ' ' . $sf_user->getFlash('error') ?>
            </p>
        <?php endif ?>


        <form action="<?php echo url_for('@login') ?>" method="post">
            <div>
                <?php echo $form->renderGlobalErrors() ?>

                <?php echo $form['username']->renderLabel() ?>
                <?php echo $form['username']->renderError() ?>
                <div class="input">
                    <?php echo $form['username'] ?>
                </div>

                <?php echo $form['password']->renderLabel() ?>
                <?php echo $form['password']->renderError() ?>
                <div class="input">
                    <?php echo $form['password'] ?>
                    <?php echo link_to('Mot de passe oublié ?', '@retrieve_password') ?>
                </div>
            </div>


            <div>
                <h2>Ou utilisez OpenID</h2>

                <?php echo $form['openid']->renderLabel() ?>
                <?php echo $form['openid']->renderError() ?>
                <div class="input">
                    <?php echo $form['openid'] ?>
                </div>
            </div>


            <br />
            <input type="submit" value="S'identifier" class="button" name="S'identifier" />

        </form>
    </div>


    <?php if ($displayRegisterLink): ?>
        <div id="topLeftCorner">
            <?php echo link_to(image_tag('new_association.jpg', array('alt' => 'Nouvelle association')), '@association_new') ?>
        </div>
    <?php endif ?>
</body>
</html>
