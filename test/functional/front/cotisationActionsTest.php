<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser('docbook'));

// Inputs
$empty = array();

$browser->
info('Access to the index page which displays list')->
get('/cotisation/index')->
with('response')->begin()->
    isStatusCode(200)->
    checkElement('h2', 'Liste des cotisations')->
    checkElement('p', '/Aucun type de cotisation/')->
end()->



info('Add a new empty cotisation, no existing type')->
get('/cotisation/new')->
with('response')->begin()->
    isStatusCode(200)->
    click('Sauvegarder', array('cotisation' => $empty))->
end()->
with('form')->begin()->
    hasErrors(true)->
end()->
with('response')->begin()->
    checkElement('.error_list', 2)->
    checkElement('body', '/Requis/')->
end()->



info('Add a new cotisation type')

;
