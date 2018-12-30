<?php

use Slim\Http\Request;
use Slim\Http\Response;
use EmbyPlaylistApp\FileSystem;
use EmbyPlaylistApp\PlaylistFile;
use EmbyPlaylistApp\Models\Playlist;
use EmbyPlaylistApp\Models\PlaylistQuery;

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    $args['location'] = $this->get('settings')['libraryBase'];

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/library', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/files' route");

    $args['location'] = $this->get('settings')['libraryBase'];
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

    $args['location'] = $this->get('settings')['libraryBase'];
    $args['page'] = 'playlists';

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
$app->get('/playlists/edit', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/playlists/edit' route");

    $args['location'] = $this->get('settings')['libraryBase'];
    $args['page'] = 'playlistEditor';
    $args['playlistName'] = (string)$request->getParam('name');
    $args['message'] = (string)$request->getParam('message');
    $args['files'] = [];

    if($args['playlistName']) {
        $filepath = PlaylistFile::createFileName($this->get('settings')['playlistRoot'], $args['playlistName']);
        if(!file_exists($filepath)) {
            $args['page'] = 'error';
            $args['error'] = "No such playlist '{$args['playlistName']}'";
        }
        
        $args['files'] = PlaylistFile::getFiles(file_get_contents($filepath));
    }

    

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});