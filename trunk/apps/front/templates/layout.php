<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <script
    src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo GMAP_KEY ?>"
    type="text/javascript">
    </script>
    <link rel="shortcut icon" href="/favicon.ico" />
</head>
<body>
    <div id="container">
    
    
        <!-- Header of the application -->
        
        <h1><?php echo sfContext::getInstance()->getUser()->getAttribute('association_name', 'Piwam', 'user') ?></h1>
        
        
        
        <!-- Menu bar -->
        
        <div id="menu">
        	<ul>
        		<li class="mainSection">Association</li>
        		<li><?php echo link_to('Configuration', 'association/edit?id=' . sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user')) ?></li>
        	</ul>
            <ul>
                <li class="mainSection">Membres</li>
                <li><?php echo link_to('Gestion des membres', 'membre/index') ?></li>
                <li><?php echo link_to('Situation g&eacute;ographique', 'membre/map') ?></li>
                <li><?php echo link_to('G&eacute;rer les statuts', 'statut/index') ?></li>
            </ul>
            <ul>
                <li class="mainSection">Cotisations</li>
                <li><?php echo link_to('G&eacute;rer les cotisations', 'cotisation/index') ?></li>
                <li><?php echo link_to('Types de cotisation', 'cotisationtype/index') ?></li>
            </ul>
            <ul>
                <li class="mainSection">Comptabilit&eacute;</li>
                <li><?php echo link_to('Gestion des activit&eacute;s', 'activite/index') ?></li>
                <li><?php echo link_to('Gestion des comptes', 'compte/index') ?></li>
                <li><?php echo link_to('Gestion des d&eacute;penses', 'depense/index') ?></li>
                <li><?php echo link_to('Gestion des recettes', 'recette/index') ?></li>
                <li><?php echo link_to('Voir les bilans', 'association/bilan') ?></li>
            </ul>
            <ul>
                <li class="mainSection">Fonctionnalit&eacute;s</li>
                <li><?php echo link_to('D&eacute;connexion', 'association/logout') ?></li>
                <li><?php echo link_to('Exporter les donn&eacute;es', 'association/export') ?></li>
                <li><?php echo link_to('Mailing', 'association/mailing') ?></li>
            </ul>
        </div>
        
        
        
        <!-- Main part of the content  -->
        
        <div id="content">
            <?php echo $sf_content ?>
        </div>
        
    </div>
</body>
</html>
