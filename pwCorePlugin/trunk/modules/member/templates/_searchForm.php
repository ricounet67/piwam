<?php
/**
 * Display a SearchUserForm instance
 */
?>

<?php use_helper('jQuery') ?>
<?php use_stylesheet('/pwCorePlugin/css/jquery.autocompleter.css') ?>
<?php jq_add_plugins_by_name(array('autocomplete', 'ui')) ?>
<?php use_javascript('/pwCorePlugin/js/effects/searchBar.js') ?>

<div id="searchBar">
  <form action="<?php echo url_for('@members_list') ?>" method="post">
    <?php echo $form->renderHiddenFields() ?>

    <?php echo $form['due_state']->renderLabel() ?> :
    <?php echo $form['due_state']->render() ?>

    <?php echo $form['by_page']->renderLabel() ?> :
    <?php echo $form['by_page']->render() ?>

    <?php echo $form['magic']->renderLabel() ?> :
    <?php echo $form['magic'] ?>

    <input type="submit" name="submit" value="rechercher" class="small blue button" />
  </form>
</div>

<div id="searchBar_toggle">
  <a href="#" id="toggle-searchbar">Rechercher</a>
</div>