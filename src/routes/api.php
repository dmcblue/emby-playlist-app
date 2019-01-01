<?php

use Slim\Http\Request;
use Slim\Http\Response;
use EmbyPlaylistApp\FileSystem;
use EmbyPlaylistApp\PlaylistFile;

const API_ROOT = '/api';

$app->post(API_ROOT . '/playlists', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/api/playlists' route");

    $root = $this->get('settings')['playlistRoot'];

    $parsedBody = $request->getParsedBody();
    $playlist = new PlaylistFile($root, $parsedBody['name']);
    if($parsedBody['original_name'] != $parsedBody['name']) {
        if($newList->exits()) {
            //throw name already in use error
            return $response->withRedirect(getenv('APPLICATION_ROOT_URL') . "/playlists/edit?name={$parsedBody['name']}&message=Error+Name+In+Use&error=1");
        }

        if($parsedBody['original_name'] != '') {
            //update name and rename file
            $playlist = new PlaylistFile($root, $parsedBody['original_name']);

            $playlist->rename($parsedBody['name']);
        }
    }
    
    $playlist->setFiles($parsedBody['files']);
    $playlist->save($this->get('settings')['userId']);

    return $response->withRedirect(getenv('APPLICATION_ROOT_URL') . "/playlists/edit?name={$parsedBody['name']}&message=Save+successful");
});


$app->post(API_ROOT . '/add', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/api/playlists' route");

    $parsedBody = $request->getParsedBody();
    $playlistName = $parsedBody['playlistName'];
    $filePath = $parsedBody['file'];
    
    $status = [
        'status' => true,
        'message' => 'Addition successful.'
    ];

    if($playlistName && $filePath) {
        $playlist = new PlaylistFile($this->get('settings')['playlistRoot'], $playlistName);
        
        if(!$playlist->exists()) {
            $status['status'] = false;
            $status['message'] = "No such playlist '{$playlistName}'";
        } else {
            $fullFilePath = $this->get('settings')['libraryBase'] . DIRECTORY_SEPARATOR . $filePath;

            if($playlist->addFile($fullFilePath)) {
                $playlist->save($this->get('settings')['userId']);
            }
        }
    } else {
        $status['status'] = false;
        $status['message'] = "Invalid data";
    }

    return $response->withJson($status);
});


$app->post(API_ROOT . '/remove', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/api/playlists' route");


    $parsedBody = $request->getParsedBody();
    $playlistName = $parsedBody['playlistName'];
    $filePath = $parsedBody['file'];
    
    $files = [];
    $status = [
        'status' => true,
        'message' => 'Addition successful.'
    ];

    if($playlistName && $filePath) {
        $playlist = new PlaylistFile($this->get('settings')['playlistRoot'], $playlistName);
        
        if(!$playlist->exists()) {
            $status['status'] = false;
            $status['message'] = "No such playlist '{$playlistName}'";
        } else {
            $fullFilePath = $this->get('settings')['libraryBase'] . DIRECTORY_SEPARATOR . $filePath;

            if($playlist->removeFile($fullFilePath)) {
                $playlist->save($this->get('settings')['userId']);
            }
        }
    } else {
        $status['status'] = false;
        $status['message'] = "Invalid data";
    }

    return $response->withJson($status);
});

$app->get(API_ROOT . '/files', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/api/files' route");

    $file = urldecode($request->getParam('file'));
    $status = [
        'status' => true,
        'message' => ''
    ];

    if(!$file) {
        $status['status'] = false;
        $status['message'] = "Invalid data";
    } else {
        $file = $this->get('settings')['libraryBase'] . DIRECTORY_SEPARATOR . $file;

        $playlistRoot = $this->get('settings')['playlistRoot'];
        $listNames = PlaylistFile::getPlaylistNames($playlistRoot);

        $results = [];
        foreach($listNames as $listName) {
            $playlist = new PlaylistFile($playlistRoot, $listName);
            $results[$listName] = $playlist->hasFile($file);
        }
    }

    return $response->withJson(isset($results) ? $results : $status);
});
