<?php use_helper('Member','JavascriptBase','jQuery','GMap','Asset') ?>
<?php include_javascripts_for_form($memberForm); include_stylesheets_for_form($memberForm); ?>
<script >
  var gMapCurrentWindow = null;
  function gMapOpenWindow(member_id)
  {
    if(gMapCurrentWindow != null)
    {
      gMapCurrentWindow.close();
    }
    var window = null;
    var marker = null;
    member_id = parseInt(member_id);
    // test if the marker of user exist on map and get window info and marker
    eval("if(typeof map_window_member_"+member_id+" != 'undefined'){ window = map_window_member_"+member_id+"; marker = map_marker_member_"+member_id+";}");
    if( window != null)
    {
      window.open(<?php echo $gmap->getJsName() ?>,marker);
      gMapCurrentWindow = window;
    }
    else{
      alert("Erreur cette personne ne possède pas une adresse correcte pour être affichée sur la carte !");
    }
  }
  function memberSearchClick()
  {
    if(jQuery("#autocomplete_member_id").val() != '')
    {
      gMapOpenWindow(jQuery("#member_id").val());
    }
    else{
      alert("Veuillez saisir un nom ou prénom, puis sélectionner un adhérent dans la liste.");
    }
  }
</script>

<h2>Localisation des membres</h2>
Chercher adhérent :<?php echo $memberForm['member_id'] ?>
<input value="Voir sur la carte" type="button" onclick='memberSearchClick()' class="button blue"/>
<br/><br/>
<?php 
include_map($gmap,array('height'=>'600px','width'=>'95%'));
// must be included at the bottom of page 
include_map_javascript($gmap);
 ?>