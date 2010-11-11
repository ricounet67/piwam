
<h2>Inscription<?php echo $titlePerson ?> à l'événement </h2>
<h3><?php echo $event->getName() ?></h3>
<?php include_partial('form', array('form' => $form,'linkCancel' =>$linkCancel)) ?>