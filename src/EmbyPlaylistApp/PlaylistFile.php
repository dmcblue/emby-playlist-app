<?php

namespace EmbyPlaylistApp;

class PlaylistFile {
    const DATE_FORMAT = 'n/j/Y g:i:s A';
    const FILENAME = 'playlist.xml';
    const POSTFIX = ' [playlist]';

    static public function convertFilePathToXml($filepath) {
        //htmlentities -- should be this ??
        return str_replace('&', '&amp;', $filepath);
    }

    static public function convertXmlPathToFilePath($filepath) {
        return str_replace('&amp;', '&', $filepath);
    }

    static public function getPlaylistNames($rootPath) {
        $contents = FileSystem::getDirectoryContents($rootPath);
        $playlistNames = [];

        foreach($contents['directories'] as $directoryName) {
            if(strpos($directoryName, self::POSTFIX) !== FALSE) {
                $playlistNames[] = str_replace(self::POSTFIX, '', $directoryName);
            }
        }

        return $playlistNames;
    }

    static public function getDate($contents) {
        $dateString =  XmlTools::getTextBetweenTags($contents, 'Added')[0];
        //1/20/2017 2:27:50 PM
        return new \DateTime($dateString);
    }

    static public function createFileName($rootPath, $name) {
        return self::createDirectoryName($rootPath, $name) . DIRECTORY_SEPARATOR . self::FILENAME;
    }
    static public function createDirectoryName($rootPath, $name) {
        return $rootPath . DIRECTORY_SEPARATOR . $name . self::POSTFIX;
    }

    /**
     * String of XML contents
     */
    public $contents;

    public $dateTime = null;

    /**
     * 
     */
    protected $dirpath = null;

    /**
     * 
     */
    protected $filepath = null;

    /**
     * Which files belong to this playlist
     */
    protected $files = null;

    /**
     * Name of the playlist
     */
    public $name;

    /**
     * Where the playlist is located
     */
    public $rootPath;

    public function __construct($rootPath, $name) {
        $this->name = $name;
        $this->rootPath = $rootPath;
    }

    public function addFile($file) {
        $files = $this->getFiles();
        $index = array_search($file, $files);
        if($index === FALSE) {
            $files[] = $file;

            $this->setFiles($files);
        }

        return $index === FALSE;
    }

    public function date() {
        if($this->dateTime === null) {
            $contents = $this->getContents();
            
            if($contents !== FALSE) {
                $dateString =  XmlTools::getTextBetweenTags($contents, 'Added')[0];
                //1/20/2017 2:27:50 PM
                $this->dateTime = new \DateTime($dateString);
            } else {
                $this->dateTime = new \DateTime();
            }
        }

        return $this->dateTime;
    }
    
    public function directoryName() {
        if($this->dirpath === null) {
            $this->dirpath = $this->rootPath . DIRECTORY_SEPARATOR . $this->name . self::POSTFIX;
        }

        return $this->dirpath;
    }

    public function exists() {
        return file_exists($this->directoryName()) && file_exists($this->fileName());
    }

    public function fileName() {
        if($this->filepath === null) {
            $this->filepath = $this->directoryName() . DIRECTORY_SEPARATOR . self::FILENAME;
        }

        return $this->filepath;
    }

    protected function getContents() {
        if(!$this->exists()) {
            return FALSE;
        }

        return file_get_contents($this->fileName());
    }

    public function getFiles() {
        if($this->files === null) {
            $contents = $this->getContents();
            if($contents !== FALSE) {
                $this->files = XmlTools::getTextBetweenTags($contents, 'Path');
            } else {
                $this->files = [];
            }
        }
        
        return $this->files;
    }

    public function hasFile($filePath) {
        $files = $this->getFiles();
        $index = array_search($filePath, $files);
        return $index !== FALSE;
    }

    public function removeFile($file) {
        $files = $this->getFiles();
        $index = array_search($file, $files);
        if($index !== FALSE) {
            array_splice($files, $index, 1);

            $this->setFiles($files);
        }

        return $index !== FALSE;
    }

    public function rename($newName) {
        $originalDirectory = $this->directoryName();
        $currentlyExists = $this->exists();

        $this->name = $newName;
        $this->dirpath = null;
        $this->filepath = null;
        if($currentlyExists) {
            rename($originalDirectory, $this->directoryName());
        }
    }

    public function save($userId) {
        $contents = self::createFileContents($userId, $this->date(), $this->name, $this->getFiles());
        self::writeFile($this->rootPath, $this->name, $contents);
    }

    public function setFiles($files) {
        $this->files = $files;
    }

    static public function writeFile($rootPath, $name, $contents) {
        $directoryName = self::createDirectoryName($rootPath, $name);
        if(!file_exists($directoryName)) {
            mkdir($directoryName, 0755);
        }

        $fileName = self::createFileName($rootPath, $name);

        file_put_contents($fileName, $contents);
    }

    static public function createFileContents($userId, $date, $name, $files) {
        ob_start();
        ?><?xml version="1.0" encoding="utf-8" standalone="yes"?>
<Item>
    <Added><?php echo $date->format(self::DATE_FORMAT); ?></Added>
    <LockData>false</LockData>
    <LocalTitle><?php echo $name; ?></LocalTitle>
    <RunningTime>283</RunningTime>
    <Genres></Genres>
    <PlaylistItems>
    <?php foreach($files as $file): ?>
    <PlaylistItem>
        <Path><?php echo self::convertFilePathToXml($file); ?></Path>
    </PlaylistItem>
    <?php endforeach; ?>
    </PlaylistItems>
    <Shares>
    <Share>
        <UserId><?php echo $userId; ?></UserId>
        <CanEdit>true</CanEdit>
    </Share>
    </Shares>
    <PlaylistMediaType>Audio</PlaylistMediaType>
</Item><?php

        return ob_get_clean();
    }
}