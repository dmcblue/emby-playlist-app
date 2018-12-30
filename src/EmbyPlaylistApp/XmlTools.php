<?php

namespace EmbyPlaylistApp;

class XmlTools {


    static public function getTextBetweenTags($content, $tagname) {
        $pattern = "/<$tagname>([\w\W]*?)<\/$tagname>/";
        preg_match_all($pattern, $content, $matches);
        return $matches[1];
    }
}