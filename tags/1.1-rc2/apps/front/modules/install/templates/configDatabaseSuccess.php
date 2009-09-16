<h2>Configuration de l'accès au serveur MySQL</h2>

<?php if ($sf_user->hasFlash('error')): ?>
<p class="error"><?php echo $sf_user->getFlash('error') ?></p>
<?php endif; ?>

<?php include_partial('form', array('form' => $form)); ?>