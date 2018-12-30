<?php

use Slim\Http\Request;
use Slim\Http\Response;
use EmbyPlaylistApp\FileSystem;
use EmbyPlaylistApp\PlaylistFile;
use EmbyPlaylistApp\Models\Playlist;
use EmbyPlaylistApp\Models\PlaylistQuery;

function listToObject(Playlist $playlist) {
	return [
		'id' => $playlist->getId(),
		'name' => $playlist->getName(),
	];
}

// Routes

require('routes/pages.php');

require('routes/api.php');




/*
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
//*/