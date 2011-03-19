
<h2>Bonjour <?php echo $user->getName() ?></h2>

<h3>Veuillez saisir 2 fois votre nouveau mot de passe ci dessous.</h3>

<form action="<?php echo url_for('@change_password?unique_key='.$unique_key) ?>" method="POST">
  <table>
    <tbody>
      <?php echo $form->renderHiddenFields() ?>
      <tr><td>Mot de passe :</td><td><?php echo $form['password']. ' ' . $form['password']->renderError() ?></td></tr>
      <tr><td>Confirmer :</td><td><?php echo $form['password_again']. ' ' . $form['password_again']->renderError() ?></td></tr>
    </tbody>
    <tfoot><tr><td><input type="submit" name="change" value="Changer" class="blue button"/></td></tr></tfoot>
  </table>
</form>