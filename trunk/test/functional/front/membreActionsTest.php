<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser('docbook'));

// Array of data we will try to submit
$membre_minimal_ok  = array('nom' => 'Dupont', 'prenom' => 'Jean', 'website' => '', 'email' => '');
$membre_empty       = array();
$membre_invalid_email_and_website = array('email' => 'foo@bar', 'website' => 'foobar');


$browser->

    info("Acces a la liste des membres")->
    get('/membre/index')->
    with('request')->begin()->
        isParameter('module', 'membre')->
        isParameter('action', 'index')->
    end()->
    with('response')->begin()->
        isStatusCode(200)->
        checkElement('body', '/Liste des membres/')->
    end()->


    info("Acces a la page d'ajout d'un membre")->
    get("/membre/new")->
    with('response')->begin()->
        isStatusCode(200)->
        info("Soumission du formulaire vide")->
        click('Sauvegarder', array('membre' => $membre_empty))->
    end()->
    with('request')->begin()->
        isParameter('module', 'membre')->
        isParameter('action', 'create')->
    end()->
    with('response')->begin()->
        checkElement('body', '/Requis/')->
        checkElement('.error_list', 2)->
    end()->
    with('form')->begin()->
        hasErrors(true)->
    end()->


    info("Soumission du formulaire avec email et site web invalides")->
    with('response')->begin()->
        click('Sauvegarder', array('membre' => $membre_invalid_email_and_website))->
    end()->
    with('request')->begin()->
        isParameter('module', 'membre')->
        isParameter('action', 'create')->
    end()->
    with('response')->begin()->
        checkElement('body', '/Requis/')->
        checkElement('body', '/Invalide/')->
        checkElement('.error_list', 4)->
    end()->
    with('form')->begin()->
        hasErrors(true)->
    end()->


    info("Soumission du formulaire minimal valide")->
    with('response')->begin()->
        click('Sauvegarder', array('membre' => $membre_minimal_ok))->
    end()->
    with('form')->begin()->
        hasErrors(false)->
    end()->
    isRedirected()->
    followRedirect()->
    with('request')->begin()->
        isParameter('module', 'membre')->
        isParameter('action', 'index')->
    end()->
    with('response')->begin()->
        checkElement('.error_list', 0)->
    end();