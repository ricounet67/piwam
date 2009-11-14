<?php
/**
 * Display a SearchUserForm instance
 */
?>

<div id="searchBar">
    <form action="<?php echo url_for('membre/search'); ?>" method="post">
        <?php echo $form->renderHiddenFields() ?>
        <?php echo $form['magic'] ?> <input type="submit" name="submit" value="rechercher" class="button" />
    </form>
</div>