<h2>Enregistrer une cotisation</h2>

<?php if ($sf_user->hasFlash('notice')): ?>
<p class="notice">
  <?php echo $sf_user->getFlash('notice') ?>
</p>
<?php endif; ?>

<?php include_partial('form', array('form' => $form)) ?>
