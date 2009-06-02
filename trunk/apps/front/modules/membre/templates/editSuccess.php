<?php use_javascript('domtab/domtab.js') ?>
<?php use_stylesheet('domtab.css') ?>

<div class="domtab">
    <ul class="domtabs">
        <li><a href="#t1">Profil du membre</a></li>
        <li><a href="#t2">Gestion des droits</a></li>
    </ul>
    <div>
        <h2><a name="t1" id="t1">Editer les informations</a></h2>
        <?php include_partial('form', array('form' => $form)) ?>
    </div>
    <div>
        <h2><a name="t2" id="t2">Gérer les droits</a></h2>
        <?php include_partial('aclForm', array('form' => $aclForm, 'user_id' => $user_id)) ?>
    </div>
</div>