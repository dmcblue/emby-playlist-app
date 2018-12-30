<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use EmbyPlaylistApp\PlaylistFile;

final class PlaylistFileTest extends TestCase
{
    public function testHasFile(): void
    {
        $contents = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>
        <Item>
          <Added>1/20/2017 2:27:50 PM</Added>
          <LockData>false</LockData>
          <LocalTitle>_____</LocalTitle>
          <RunningTime>146</RunningTime>
          <Genres>
          </Genres>
          <Studios>
          </Studios>
          <PlaylistItems>
            <PlaylistItem>
              <Path>F:\Content\Music\Andre Kostelanetz &amp; His Orchestra, Columbia Symphony Orchestra\Puccini Without Words [Clean]\01-01- Gianni Schicchi, opera O mio Babbino caro.mp3</Path>
            </PlaylistItem>
          </PlaylistItems>
          <Shares>
            <Share>
              <UserId>821c7eaf511e4d05afeb833bfb10244c</UserId>
              <CanEdit>true</CanEdit>
            </Share>
          </Shares>
          <PlaylistMediaType>Audio</PlaylistMediaType>
        </Item>';
        
        $file1 = "F:\Content\Music\Andre Kostelanetz & His Orchestra, Columbia Symphony Orchestra\Puccini Without Words [Clean]\\01-01- Gianni Schicchi, opera O mio Babbino caro.mp3";
        $file2 = "F:\Content\Music\Andre Kostelanetz.mp3";

        $this->assertEquals(
            true,
            PlaylistFile::hasFile($contents, $file1)
        );

        $this->assertEquals(
            false,
            PlaylistFile::hasFile($contents, $file2)
        );
    }

    public function testGetDate(): void
    {
        $contents = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>
        <Item>
          <Added>1/20/2017 2:27:50 PM</Added>
          <LockData>false</LockData>
          <LocalTitle>_____</LocalTitle>
          <RunningTime>146</RunningTime>
          <Genres>
          </Genres>
          <Studios>
          </Studios>
          <PlaylistItems>
            <PlaylistItem>
              <Path>F:\Content\Music\Andre Kostelanetz &amp; His Orchestra, Columbia Symphony Orchestra\Puccini Without Words [Clean]\01-01- Gianni Schicchi, opera O mio Babbino caro.mp3</Path>
            </PlaylistItem>
          </PlaylistItems>
          <Shares>
            <Share>
              <UserId>821c7eaf511e4d05afeb833bfb10244c</UserId>
              <CanEdit>true</CanEdit>
            </Share>
          </Shares>
          <PlaylistMediaType>Audio</PlaylistMediaType>
        </Item>';
        
        $file1 = "F:\Content\Music\Andre Kostelanetz & His Orchestra, Columbia Symphony Orchestra\Puccini Without Words [Clean]\\01-01- Gianni Schicchi, opera O mio Babbino caro.mp3";
        $file2 = "F:\Content\Music\Andre Kostelanetz.mp3";

        $date = PlaylistFile::getDate($contents);

        $this->assertEquals(
            '2017-01-20 14:27:50',
            $date->format('Y-m-d H:i:s')
        );
    }
}