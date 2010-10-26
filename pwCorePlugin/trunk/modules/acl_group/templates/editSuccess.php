<?php use_javascript('/pwCorePlugin/js/domtab/domtab.js') ?>
<?php use_stylesheet('/pwCorePlugin/css/domtab.css') ?>

<div class="domtab">

  <!-- List of tabs -->
  <ul class="domtabs">
    <li><a href="#profil">Informations du groupe</a></li>
    <li><a href="#credentials">Gestion des droits</a></li> 
  </ul>

  <!-- First tab : edit acl group -->
  <div>
    <h2><a name="profil" id="profil">Modification d'un groupe</a></h2>
    <?php include_partial('form', array('form' => $form)) ?>
  </div>

  <!-- Second tab : edit credentials -->
  <div style="visible:false">
    <h2><a name="credentials" id="credentials">Droits du groupe</a></h2>
	<?php include_partial('rightsForm', array('form' => $rightsForm)) ?>
  </div>
  
</div>