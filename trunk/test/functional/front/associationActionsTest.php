<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// Array of data we will put on the forms
$association_ok             = array('nom' => 'Test', 'description' => 'Description association', 'site_web' => 'http://www.association.com');
$association_with_bad_url   = array('nom' => 'Test', 'description' => 'Description association', 'site_web' => 'mywebsite');
$association_empty          = array('nom' => '', 'description' => '', 'site_web' => '');
$membre_ok					= array('nom' => 'Foobar', 'prenom' => 'Roger', 'pseudo' => 'foobar_123', 'password' => 'passwrd29');
$membre_empty				= array('nom' => '', 'prenom' => '', 'pseudo' => '', 'password' => '');

$browser = new sfGuardTestFunctional(new sfBrowser('docbook'), false);

$browser->


info("New association with empty data")->
get('/association/new')->
with('response')->begin()->
    click("Étape suivante >", array('association' => $association_empty))->
end()->
with('form')->begin()->
    hasErrors(true)->
end()->



info("New association with correct data")->
with('response')->begin()->
    click("Étape suivante >", array('association' => $association_ok))->
end()->
followRedirect()->
with('request')->begin()->
    isParameter('module', 'membre')->
    isParameter('action', 'newfirst')->
end()->



info("Register the first member with empty data")->
with('response')->begin()->
    click("Étape suivante >", array('membre' => $membre_empty))->
end()->
with('form')->begin()->
hasErrors(true)->
end()->



//	info("Enregistrement du premier membre avec donnes valides")->
//	with('response')->begin()->
//		click("Étape suivante >", array('membre' => $membre_ok))->
//	end()->
//	followRedirect()->
//	with('request')->begin()->
//		isParameter('module', 'membre')->
//		isParameter('action', 'endregistration')->
//	end()->



signin(array('username' => sfGuardTestFunctional::LOGIN_OK, 'password' => sfGuardTestFunctional::PASSWORD_OK))->


info("Try to edit without giving ID as argument : custom error page")->
get('/association/edit')->
with('response')->begin()->
    isStatusCode(404)->
    checkElement('body', '/Page introuvable/')->
end()->



info("Access to the edit page")->
click("A propos de l'association")->
checkResponseElement('form input', true, array('count' => 7))->
with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Nom de l\'association/')->
    info("Submit with empty form")->
    click('Sauvegarder', array('association' => $association_empty))->
end()->
with('request')->begin()->
    isParameter('module', 'association')->
    isParameter('action', 'update')->
end()->
with('form')->begin()->
    hasErrors(true)->
end()->



info("Form filled with wrong website")->
with('response')->begin()->
    isStatusCode(200)->
    click('Sauvegarder', array('association' => $association_with_bad_url))->
end()->
with('form')->begin()->
    hasErrors(true)->
end()->



info("Form with correct data")->
with('response')->begin()->
    isStatusCode(200)->
    click('Sauvegarder', array('association' => $association_ok))->
end()->
with('form')->begin()->
    hasErrors(false)->
end()->



info("Access to the index page")->
get('/association/index');
;