<?php

use Slim\Http\Request;
use Slim\Http\Response;
use EmbyPlaylistApp\FileSystem;
use EmbyPlaylistApp\PlaylistFile;

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


$app->get('/library', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/files' route");

    $args['page'] = 'files';

    $args['path'] = is_array($request->getParam('path')) ? $request->getParam('path') : [];
    $currentPath = $this->get('settings')['libraryBase'] . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $args['path']);
    $args['contents'] = FileSystem::getDirectoryContents($currentPath);

    $args['isRoot'] = count($args['path']) === 0;

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


$app->get('/playlists', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/playlists' route");

    $args['page'] = 'playlists';

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


$app->get('/playlists/edit', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/playlists/edit' route");

    $args['page'] = 'playlistEditor';
    $args['playlistName'] = (string)$request->getParam('name');
    $args['message'] = (string)$request->getParam('message');
    $args['error'] = (bool)$request->getParam('error');
    $args['files'] = [];

    if($args['playlistName']) {
        $playlist = new PlaylistFile($this->get('settings')['playlistRoot'], $args['playlistName']);
        
        if(!$playlist->exists()) {
            $args['page'] = 'error';
            $args['error'] = "No such playlist '{$args['playlistName']}'";
        }
        
        $args['files'] = $playlist->getFiles();
    }

    

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});