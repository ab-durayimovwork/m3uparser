<?php

namespace M3uParser\PlaylistContent;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use M3uParser\Exception as M3uParserException;

class RemotePlaylistContent extends PlaylistContent
{
    /**
     * @throws GuzzleException
     * @throws M3uParserException
     */
    public function getContent()
    {
        try {
            return (new Client)
                ->request('GET', $this->getPath())
                ->getBody()
                ->getContents();
        } catch (Exception $e) {
            throw new M3uParserException();
        }
    }
}