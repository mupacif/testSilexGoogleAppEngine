<?php
/**
continet les options de configuraiton liées au developpement de notre application.
*/
// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;