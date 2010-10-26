<?php
/**
 * Display the default delete icon, and associate
 * a modal popup which asks for confirmation.
 *
 * Required inputs :
 *
 *  - string $route the route for deleting
 * Optionnal inputs:
 *  - string objectMessage the type of objet to delete
*/
?>

<a href="#" class="modalInput" rel="#deleteFrame_<?php echo $id ?>">
<?php echo image_tag('/pwCorePlugin/images/icons/delete', array('alt' => '[supprimer]','title'=>'Supprimer')) ?></a>

<div class="modal" id="deleteFrame_<?php echo $id ?>">

    <h2>Confirmation</h2>
    <p>
        Êtes vous sûr de vouloir supprimer <?php echo (isset($objectMessage)? $objectMessage : "cet élément")?> ?
    </p>

    <!-- yes/no buttons -->
    <p>
        <a class="close grey button">Annuler</a>
        <?php echo link_to('Supprimer !', $route . '?id=' . $id, array('class' => 'close grey button')) ?>
    </p>
</div>
