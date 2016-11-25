<?php
use Symfony\Component\HttpFoundation\Request;
// Home page
/*
$app->get('/', function () {
 require '../src/model.php';
 $emos = getEmotions();

    ob_start();             // start buffering HTML output
     require '../views/view.php';
    $view = ob_get_clean(); // assign HTML output to $view
    return $view;
});

*/

// Home page

$app->get('/', function () use ($app) {
    $emos = $app['dao.emotions']->findAll();

  /*  ob_start();             // start buffering HTML output
    require '../views/view.php';
    $view = ob_get_clean(); // assign HTML output to $view

    */
    return $app['twig']->render('view.html.twig', array(
      'emos'=>$emos,
      'page'=>0
      ));
})->bind('home');

$app->get('/{page}', function ($page) use ($app) {
    $emos = $app['dao.emotions']->findAll($page);

  /*  ob_start();             // start buffering HTML output
    require '../views/view.php';
    $view = ob_get_clean(); // assign HTML output to $view

    */
    return $app['twig']->render('view.html.twig', array(
      'emos' => $emos, 
      'page'=>$page,
      'pages'=>count($emos)  
      )
    );
})->bind('homePage');




$app->post('/emotions', function (Request $request) use($app){
   $emotion = new Manager\model\Emotion();
   $emo = $request->get('feels');
   $content = $request->get('thinking');
   $emotion->setEmotion($emo);
   $emotion->setContent($content);
   
    $app['dao.emotions']->save($emotion);
   return  $app->redirect($app["url_generator"]->generate("home"));;
})->bind('emotionsPost');


$app->get('/so', function (Request $request) {
   
 
   return "segpa";
})->bind('so');