<?php

use Slim\Http\Request;
use Slim\Http\Response;
use EmbyPlaylistApp\FileSystem;
use EmbyPlaylistApp\PlaylistFile;
use EmbyPlaylistApp\Models\Playlist;
use EmbyPlaylistApp\Models\PlaylistQuery;

const API_ROOT = '/api';

$app->post(API_ROOT . '/playlists', function (Request $request, Response $response, array $args) {
    //create new (post/put?/patch)

    // Sample log message
    $this->logger->info("Slim-Skeleton '/api/playlists' route");
    $parsedBody = $request->getParsedBody();
    if($parsedBody['original_name'] != '' && $parsedBody['original_name'] != $parsedBody['name']) {
        //update name and rename file
    }

    //1/20/2017 2:27:50 PM from Added tag
    //$date = PlaylistFile::getDate($contents);
    $filepath = PlaylistFile::createFileName($this->get('settings')['playlistRoot'], $parsedBody['name']);
    if(!file_exists($filepath)) {
        $date = new DateTime();
    } else {
        $contents = file_get_contents($filepath);
        $date = PlaylistFile::getDate($contents);
    }

    $contents = PlaylistFile::createFileContents($this->get('settings')['userId'], $date, $parsedBody['name'], $parsedBody['files']);
    
    PlaylistFile::writeFile($this->get('settings')['playlistRoot'], $parsedBody['name'], $contents);

    //$body = $response->getBody();
    //$body->write($contents);
    return $response->withRedirect(getenv('APPLICATION_ROOT_URL') . "/playlists/edit?name={$parsedBody['name']}&message=Save+successful");//->withJson($parsedBody);
});

$app->get(API_ROOT . '/test', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/api/test' route");

    $queryResults = PlaylistQuery::create()->find();
    $playlists = [];
	foreach($queryResults as $result){
		$playlists[] = listToObject($result);
	}
    
    return $response->withJson($playlists);
});