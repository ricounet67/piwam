<h2>Mot de passe oublié</h2>

<?php if ($sf_user->hasFlash('error')): ?>
  <p class="error">
      <?php echo image_tag('/pwCorePlugin/images/error', array('alt' => '[erreur]', 'align' => 'top')) ?>
      <?php echo $sf_user->getFlash('error') ?>
  </p>
<?php endif ?>

<?php if ($sf_user->hasFlash('notice')): ?>
  <p class="notice">
    <?php echo $sf_user->getFlash('notice') ?>
  </p>
<?php endif ?>


<form action="<?php echo url_for('@retrieve_password') ?>" method="post">
  <?php echo $form->renderHiddenFields() ?>
  <table class="formtable">
    <tr>
      <td colspan="2"><?php echo $form->renderGlobalErrors() ?></td>
    </tr>
    <tr>
      <th>Quelle est votre nom <br/>d'utilisateur ou email :</th>
      <td><?php echo $form['username'] . $form['username']->renderError() ?></td>
    </tr>
    <tr>
      <td><?php echo link_to('Retour','@login',array('class'=>'grey button'))?></td>
      <td>
        <input type="submit" value="Valider" class="grey button" name="Valider" />
      </td>
    </tr>
  </table>
</form>