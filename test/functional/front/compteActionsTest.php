<?php
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser('docbook'));


// Inputs
$empty       = array();
$only_label  = array('libelle'   => 'Compte de test');
$only_ref    = array('reference' => 'CDT');
$full        = array('libelle'   => 'Compte de test', 'reference' => 'CDT');


$browser->
info('Access to the account list')->
get('/compte/index')->
with('response')->begin()->
    isStatusCode(200)->
    checkElement('h2', 'Liste des comptes')->
end()->



info('Try to add an empty account')->
get('/compte/new')->
with('response')->begin()->
    click('Sauvegarder', array('compte' => $empty))->
end()->
with('request')->begin()->
    isParameter('module', 'compte')->
    isParameter('action', 'create')->
end()->
with('form')->begin()->
    hasErrors(true)->
end()->
with('response')->begin()->
    checkElement('body', '/Requis/')->
end()->




info('Try to add account with only a label')->
get('/compte/new')->
with('response')->begin()->
    click('Sauvegarder', array('compte' => $only_label))->
end()->
with('request')->begin()->
    isParameter('module', 'compte')->
    isParameter('action', 'create')->
end()->
with('form')->begin()->
    hasErrors(true)->
end()->
with('response')->begin()->
    checkElement('body', '/Requis/')->
end()->




info('Try to add account with only a reference')->
get('/compte/new')->
with('response')->begin()->
    click('Sauvegarder', array('compte' => $only_ref))->
end()->
with('request')->begin()->
    isParameter('module', 'compte')->
    isParameter('action', 'create')->
end()->
with('form')->begin()->
    hasErrors(true)->
end()->
with('response')->begin()->
    checkElement('body', '/Requis/')->
end()->


info('Try to add account with correct values')->
get('/compte/new')->
with('response')->begin()->
    click('Sauvegarder', array('compte' => $full))->
end()->
with('form')->begin()->
    hasErrors(false)->
end()->
followRedirect()->
with('request')->begin()->
    isParameter('module', 'compte')->
    isParameter('action', 'index')->
end()->




info('Try to add account with existing reference')->
get('/compte/new')->
with('response')->begin()->
    click('Sauvegarder', array('compte' => $full))->
end()->
with('form')->begin()->
    hasErrors(true)->
end()->
with('request')->begin()->
    isParameter('module', 'compte')->
    isParameter('action', 'create')->
end()->
with('response')->begin()->
    checkElement('body', '/Un enregistrement similaire existe déjà./')->
end()
;


/*
 * Creation of an account which belongs to another
 * association
 */
$foreignAccount = new Compte();
$foreignAccount->setAssociationId($browser->foreignAssociation);
$foreignAccount->setLibelle('Foreign account');
$foreignAccount->setReference('FA');
$foreignAccount->setActif(1);
$foreignAccount->save();
$foreignId = $foreignAccount->getId();




$browser->
info('Try to access to foreign account')->
get('/compte/show/id/' . $foreignId)->
with('response')->begin()->
    isStatusCode(200)->
    checkElement('h2', '!/Détails/')->
    checkElement('h2', '/Problème de droits/')->
end();