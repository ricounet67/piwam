<h2>Localisation des membres</h2>
<?php
use_javascript("http://maps.google.com/maps?file=api&v=2&key=" . sfConfig::get('sf_googlemap_key'));
$map->showMap();
?>