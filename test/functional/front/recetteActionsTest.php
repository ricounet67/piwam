<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser());

// Inputs
$recette_empty			= array();
$recette_wrong_montant	= array('libelle' => "Vente d'eau", 'montant' => '21a');
$recette_ok				= array('libelle' => "Vente d'eau", 'montant' => '43.21');
$creance_ok				= array('libelle' => "Vente d'eau", 'montant' => '43.21', 'percue' => '0');


$browser->

info("Acces a la liste des recettes")->
get('/recette/index')->
with('request')->begin()->
isParameter('module', 'recette')->
isParameter('action', 'index')->
end()->



info("Ajout d'une recette vide")->
get('/recette/new')->
with('request')->begin()->
isParameter('module', 'recette')->
isParameter('action', 'new')->
end()->
with('response')->begin()->
click('Sauvegarder', array('recette' => $recette_empty))->
end()->
with('form')->begin()->
hasErrors(true)->
isError('libelle', 'required')->
isError('montant', 'required')->
end()->
with('request')->begin()->
isParameter('module', 'recette')->
isParameter('action', 'create')->
end()->



info("Ajout d'une recette avec montant invlaide")->
with('response')->begin()->
click('Sauvegarder', array('recette' => $recette_wrong_montant))->
end()->
with('form')->begin()->
hasErrors(true)->
isError('libelle', false)->
isError('montant', 'invalid')->
end()->




info("Ajout d'une recette correcte")->
with('response')->begin()->
click('Sauvegarder', array('recette' => $recette_ok))->
end()->
followRedirect()->
with('request')->begin()->
isParameter('module', 'recette')->
isParameter('action', 'index')->
end()->
with('response')->begin()->
contains("Vente d&#039;eau")->
contains("43,21")->
contains("CAISSE_MONNAIE")->
end()->



info("Acces aux details de la recette")->
with('response')->begin()->
click('[détails]')->
end()->
with('response')->begin()->
click('Retour')->
end()->



info("Acces a l'edition de la recette")->
with('response')->begin()->
click('[éditer]')->
end()
;
