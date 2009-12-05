<a href="#" class="modalInput" rel="#deleteFrame_<?php echo $id ?>"><?php echo image_tag('icons/delete', array('alt' => '[supprimer]')) ?></a>

<div class="modal" id="deleteFrame_<?php echo $id ?>">

    <h2>Confirmation</h2>
    <p>
        Êtes vous sûr de vouloir supprimer ?
    </p>

    <!-- yes/no buttons -->
    <p>
        <a class="close grey button">Annuler</a>
        <?php echo link_to('Supprimer !', $route . '?id=' . $id, array('class' => 'close grey button')) ?>
    </p>
</div>
