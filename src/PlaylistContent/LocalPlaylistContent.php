<?php

namespace M3uParser\PlaylistContent;

use Exception;
use M3uParser\Exception as M3uParserException;

class LocalPlaylistContent extends PlaylistContent
{
    /**
     * @throws M3uParserException
     */
    public function getContent()
    {
        try {
            return file_get_contents($this->getPath());
        } catch (Exception $e) {
            throw new M3uParserException($e);
        }
    }
}