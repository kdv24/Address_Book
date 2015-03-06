<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/contact.php";

    session_start();
    if (empty($_SESSION['list_of_contacts'])){
        $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' =>__DIR__.'/../views'));

    $app->get('/', function() use ($app){
        return $app['twig']->render('contacts.twig', array('contacts' => Contact::getAll()));
    });

    $app->post('/create_contact', function() use($app){
        $contact = new Contact($_POST['name'], $_POST['phone'], $_POST['address']);
        $contact->save();
        return $app['twig']->render('create_contact.twig', array('new_contacts'=> $contact));
    });



    $app->post('/delete_contacts', function() use($app){
        return $app['twig']->render('delete_contacts.twig', array('delete_contact'=> Contact::deleteAll()));
    });

    return $app;
?>
