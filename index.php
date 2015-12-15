<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 12/10/15
 * Time: 10:38 PM
 */
?>
<?php
require 'vendor/autoload.php';
require 'config.php';

$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {

    $rer  = \models\Bus::all();
    $response->write(json_encode($rer));
    return $response;
});

$app->get('/buses/index',function($request,$response,$args){
    $rer  = \models\Bus::all();
    $response->write(json_encode($rer));
    return $response;
});



$app->get('/tickets/index',function($request,$response,$args){
    $rer  = \models\Tickets::all();
    $response->write(json_encode($rer));
    return $response;
});

$app->get('/tickets/update[/{id}/{status}]', function($request,$response,$args){
    $ticket  = \models\Tickets::find($args['id']);
    $ticket->status = $args['status'];
    $rer=[];

    if($ticket->update()){
        $rer['data']=$ticket;
        $rer['msg']="success";
    }else{
        $rer['data']=null;
        $rer['msg']="failed";
    }
    $response->write(json_encode($rer));
    return $response;
});

$app->get('/tickets/data[/{id}]',function($request,$response,$args){
    $rer  = \models\Tickets::find($args['id']);
    $response->write(json_encode($rer));
    return $response;
})->setArgument('id', '1');

/*$app->get('/buses/data[/{id}]',function($request,$response,$args){
    $rer  = \models\Bus::find($args['id']);
    $response->write(json_encode($rer));
    return $response;
})->setArgument('id', '1');*/

$app->get('/terminals/index',function($request,$response,$args){
    $rer=\models\Terminal::all();
    $response->write(json_encode($rer));
    return $response;
});

$app->get('/terminals/data[/{id}]',function($request,$response,$args){
    $rer  = \models\Terminal::find($args['id']);
    $response->write(json_encode($rer));
    return $response;
})->setArgument('id', '1');

/*
$app->get('/buses/index[/{id}]', function ($request, $response, $args) {
    $rer  = \models\Bus::find(1);
    $response->write(json_encode($rer));
    return $response;
})->setArgument('id', 1);*/

/**/$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');
/*$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});*/
$app->run();
