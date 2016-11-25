<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;


// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
//defini automatique app['app']
$app->register(new Silex\Provider\DoctrineServiceProvider());
//defini automatique app['twig']
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use($app){
        // implement whatever logic you need to determine the asset path
    	//url $app["request"]->getBaseUrl()
        return $app["request"]->getBasePath()."/".ltrim($asset, '/');
    }));

    return $twig;
}));


// Register services.
$app['dao.emotions'] = $app->share(function ($app) {
   // return new Manager\DAO\EmotionDAO($app['db']);
	return new Manager\DAO\EmotionGAE($app['project-ID']);

});