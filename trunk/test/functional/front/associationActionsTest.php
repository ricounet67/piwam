<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser('docbook'));

// Array of data we will put on the forms
$association_ok             = array('nom' => 'Test', 'description' => 'Description association', 'site_web' => 'http://www.association.com');
$association_with_bad_url   = array('nom' => 'Test', 'description' => 'Description association', 'site_web' => 'mywebsite');
$association_empty          = array('nom' => '', 'description' => '', 'site_web' => '');


$browser->

    info("Acces a la page d'edition sans specifier d'id d'association")->
    get('/association/edit')->
    with('response')->begin()->
        isStatusCode(404)->
    end()->



    info("Acces a la page d'edition en specifiant un id d'association")->
    get('/association/edit/id/2')->
    checkResponseElement('form input', true, array('count' => 7))->
    with('response')->begin()->
        isStatusCode(200)->
        checkElement('body', '/Nom de l\'association/')->
        info("Formulaire non rempli")->
        click('Sauvegarder', array('association' => $association_empty))->
    end()->
    with('request')->begin()->
        isParameter('module', 'association')->
        isParameter('action', 'update')->
    end()->
    with('form')->begin()->
        hasErrors(true)->
    end()->



    info("Formulaire avec site web incorrect")->
    with('response')->begin()->
        isStatusCode(200)->
        click('Sauvegarder', array('association' => $association_with_bad_url))->
    end()->
    with('form')->begin()->
        hasErrors(true)->
    end()->



    info("Formulaire avec donnees correctes")->
    with('response')->begin()->
        isStatusCode(200)->
        click('Sauvegarder', array('association' => $association_ok))->
    end()->
    with('form')->begin()->
        hasErrors(false)->
    end();