<?php use_helper('jQuery') ?>
<?php jq_add_plugins_by_name(array('ui')) ?>
<?php use_javascript('/pwCorePlugin/js/boxover/boxover.js') ?>
<?php use_javascript('/pwCorePlugin/js/jquery-tools/jquery.tools.min.js') ?>
<?php use_javascript('/pwCorePlugin/js/effects/deleteButton.js') ?>
<?php use_stylesheet('/pwCorePlugin/css/buttons.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/form.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/main.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/menu.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/overlay.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/pagination.css') ?>
<?php use_stylesheet('/pwCorePlugin/css/table.css') ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
    <link rel="shortcut icon" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/pwCorePlugin/images/favicon.ico" />
</head>
<body>

    <div id="container">

        <!-- Header of the application -->

        <h1><?php echo sfContext::getInstance()->getUser()->getAssociationName('Piwam') ?></h1>

        <div id="menu">

            <?php if ($sf_user->getUserId()): ?>
            <div id="user_box">
                <p>
                    Bonjour <span class="username"><?php echo $sf_user->getUsername() ?></span>
                </p>
                <?php echo link_to(image_tag('/pwCorePlugin/images/icons/user_edit') . ' Modifier mon profil', '@member_edit?id=' . $sf_user->getUserId()) ?>
                <?php echo link_to(image_tag('/pwCorePlugin/images/logout') . ' D&eacute;connexion', '@logout') ?>
            </div>
            <?php endif ?>

            <ul>
                <li class="mainSection">Configuration</li>
                <li><?php echo link_to('A propos de l\'association', '@association_edit?id=' . sfContext::getInstance()->getUser()->getAssociationId()) ?></li>
                <li><?php echo link_to('Pr&eacute;f&eacute;rences Piwam', '@config') ?></li>
                <li><?php echo link_to('Infos membres', '@config_members') ?></li>
                <li><?php echo link_to('Administration', '@admin') ?></li>
            </ul>
            <ul>
                <li class="mainSection">Membres</li>
                <li><?php echo link_to('Gestion des membres', '@members_list') ?></li>
                <li><?php echo link_to('Situation g&eacute;ographique', '@members_map') ?></li>
                <li><?php echo link_to('Trombinoscope', '@faces') ?></li>
                <li><?php echo link_to('G&eacute;rer les statuts', '@status_list') ?></li>
            </ul>
            <ul>
                <li class="mainSection">Cotisations</li>
                <li><?php echo link_to('G&eacute;rer les cotisations', '@dues_list') ?></li>
                <li><?php echo link_to('Types de cotisation', '@duetypes_list') ?></li>
            </ul>
            <ul>
                <li class="mainSection">Comptabilit&eacute;</li>
                <li><?php echo link_to('Gestion des activit&eacute;s', '@activities_list') ?></li>
                <li><?php echo link_to('Gestion des comptes', '@accounts_list') ?></li>
                <li><?php echo link_to('Gestion des d&eacute;penses', '@expenses_list') ?></li>
                <li><?php echo link_to('Gestion des recettes', '@incomes_list') ?></li>
                <li><?php echo link_to('Voir les bilans', '@balance') ?></li>
            </ul>
            <ul>
                <li class="mainSection">Fonctionnalit&eacute;s</li>
                <li><?php echo link_to('Exporter les donn&eacute;es', '@export') ?></li>
                <li><?php echo link_to('Mailing', '@mailing') ?></li>
                <li><a href="http://code.google.com/p/piwam/issues/entry" target="_blank">Rapporter un bug</a></li>
            </ul>
            <br />
        </div>


        <!-- Main part of the content  -->

        <div id="content">
            <?php echo $sf_content ?>
        </div>
        <hr class="clear" />

    </div> <!-- container -->
</body>
</html>
