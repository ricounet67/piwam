<?php use_javascripts_for_form($form) ?>

<h2>Envoi en masse</h2>

<!-- Display success or error message -->

<?php if ($sf_user->hasFlash('notice')): ?>
  <p class="notice"><?php echo $sf_user->getFlash('notice') ?></p>
<?php endif ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <p class="error">
    <?php echo image_tag('/pwCorePlugin/images/error', array('align' => 'top', 'alt' => 'Erreur')) ?>
    <strong>ERREUR</strong>:
    <?php echo $sf_user->getFlash('error') ?>
  </p>
<?php endif ?>


<!-- Display sent mail if form has been submit -->

<?php  if (isset($content)): ?>

  <div class="mailPreview">
    <p><strong>Votre message :</strong></p>
    <hr />
    <?php echo html_entity_decode($content) ?>
  </div>

<?php else: ?>

  <form action="<?php echo url_for('mailing/index') ?>" method="post">
  <?php echo $form->renderHiddenFields() ?>

    <!-- if message or subject is empty -->

    <?php if ($form->hasErrors()): ?>
      <div class="global_errors">
        <?php echo $form->renderGlobalErrors() ?>
      </div>
    <?php endif ?>


    <table class="formtable" title="mailing">
      <tr>
        <th><?php echo $form['subject']->renderLabel() ?></th>
        <td><?php echo $form['subject'] ?></td>
      </tr>
      <tr>
        <th>Destinataires</th>
        <td>Tout le monde</td>
      </tr>
      <tr>
        <th valign="top"><?php echo $form['mail_content']->renderLabel() ?></th>
        <td><?php echo $form['mail_content'] ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <input type="submit" class="grey button" value="Envoyer" />
          <?php echo link_to('Liste des emails envoyés', '@mailing_list', array('class' => 'blue button')) ?>
        </td>
      </tr>
    </table>
  </form>

<?php endif ?>