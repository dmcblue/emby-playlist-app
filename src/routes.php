<?php

use Slim\Http\Request;
use Slim\Http\Response;
use EmbyPlaylistApp\Playlist;
use EmbyPlaylistApp\PlaylistQuery;

function listToObject(Playlist $playlist) {
	return [
		'id' => $playlist->getId(),
		'name' => $playlist->getName(),
	];
}

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    $args['location'] = $this->get('settings')['libraryBase'];

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/test', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/test' route");

    $queryResults = PlaylistQuery::create()->find();
    $playlists = [];
	foreach($queryResults as $result){
		$playlists[] = listToObject($result);
	}
    
    return $response->withJson($playlists);
});
/*
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
//*/