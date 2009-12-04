<?php
/**
 * Display a SearchUserForm instance
 */
?>
<?php use_javascript('/js/jquery-ui-1.7.1/js/jquery-1.3.2.min.js') ?>
<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>



<div id="searchBar">
    <form action="<?php echo url_for('@member_search'); ?>" method="post">
        <?php echo $form->renderHiddenFields() ?>
        <?php echo $form['magic'] ?> <input type="submit" name="submit" value="rechercher" class="small blue button" />
    </form>
</div>