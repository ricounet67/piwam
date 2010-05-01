<?php use_stylesheet('/pwCorePlugin/css/main.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/login.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/buttons.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/form.css') ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_stylesheets() ?>
    <link rel="shortcut icon" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/pwCorePlugin/images/favicon.ico" />
</head>
<body>

  <!-- Set Jquery's noConflict mode -->

  <script type="text/javascript">var J = jQuery.noConflict();</script>


  <!-- Main centered panel, with several parts-->

  <div id="container">

    <!--
         Display a link to register a new association, but only if
         user is allowed to register a new one
    -->
    
    <?php if ($displayRegisterLink): ?>
      <h1>Nouvelle association ?</h1>
      <div>
        Ou enregistrez une <?php echo link_to('nouvelle association', '@association_new') ?>
      </div>
      <br /><br />
    <?php endif ?>


    <!-- The authentication form -->

    <h1>Authentification</h1>

    <?php if ($sf_user->hasFlash('error')):?>
      <p class="error">
        <?php echo image_tag('/pwCorePlugin/images/error', array('alt' => '[erreur]', 'align' => 'top')) . ' ' . $sf_user->getFlash('error') ?>
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

      
      <!-- Buttons on bottom -->

      <div id="foot">
        <?php echo $form->renderHiddenFields() ?>
        <input type="submit" value="S'identifier" class="grey button" name="S'identifier" />
        <?php echo link_to("Pas encore inscrit ?", '@member_ask_subscription', array('class' => 'grey button'))?>
      </div>
    </form>

  </div> <!-- container div -->

</body>
</html>