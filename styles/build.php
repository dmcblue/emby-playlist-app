<?php
/**
 * Builds SCSS files into one compa
 */
if (php_sapi_name() != "cli") {
	die('Command Line Access Only');
}

require __DIR__ . DIRECTORY_SEPARATOR 
		. '..' . DIRECTORY_SEPARATOR 
		. 'vendor' . DIRECTORY_SEPARATOR 
		. 'autoload.php';

$files = EmbyPlaylistApp\FileSystem::getFilesRecursive(__DIR__, 'scss');

/*
 * format options include:
 * compact, compressed, crunched, expanded, or nested
 */
$path = realpath(__DIR__ . DIRECTORY_SEPARATOR . '../vendor/bin/pscss');

foreach($files as $file) {
	$newPath = EmbyPlaylistApp\Filesystem::replaceExtension($file, 'css');
	$output = [];
	exec("{$path} -f=\"compressed\" {$file} > {$newPath}", $output);
	foreach($output as $line) {
		echo $line . "\n";
	}
}


$cssFiles = EmbyPlaylistApp\Filesystem::getFilesRecursive(__DIR__, 'css');
$outputFile = __DIR__ . DIRECTORY_SEPARATOR 
        . '..' . DIRECTORY_SEPARATOR 
        . 'public' . DIRECTORY_SEPARATOR 
        . 'style' . DIRECTORY_SEPARATOR 
        . "emby-playlist-app.css";

file_put_contents($outputFile, '');

foreach($cssFiles as $file) {
	file_put_contents($outputFile, file_get_contents($file), FILE_APPEND);
	unlink($file);
}

