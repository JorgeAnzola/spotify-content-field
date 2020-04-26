<?php
/**
 * Spotify content plugin for Craft CMS 3.x
 *
 * Embed Spotify songs, playlists, or artists.
 *
 * @link      anzola.nl
 * @copyright Copyright (c) 2020 Jorge Anzola
 */

namespace jorgeanzola\spotifycontent\services;

use craft\base\Component;

/**
 * @author    Jorge Anzola
 * @package   SpotifyContent
 * @since     1.0.0
 */
class Spotify extends Component
{
    public function stringValidation(string $string, bool $asString = false)
    {
        $regex = $this->getRegex();
        
        preg_match_all($regex, $string, $matches, PREG_SET_ORDER, 0);
        
        return isset($matches[0]) ? $this->normalizeString($matches[0], $asString) : null;
    }
    
    public function getRegex(): string
    {
        return '/(spotify:|https:\/\/open.spotify.com\/)(((embed|embed-podcast)\/)?)(track|episode|album|playlist|artist|show)(:|\/?)([a-zA-Z0-9]{22})/m';
    }
    
    public function getEmbedUrl(string $string)
    {
        $segments = $this->stringValidation($string);
        
        return "https://open.spotify.com/{$segments['embed_type']}/{$segments['content_type']}/{$segments['content_id']}";
    }
    
    public function normalizeString(array $segments, bool $asString = false)
    {
        $embedType = (in_array($segments[5], ['show', 'episode'])) ? 'embed-podcast' : 'embed';
        
        if ($asString) {
            return "spotify_content_{$embedType}_{$segments[5]}_{$segments[7]}";
        }
        
        return [
            'embed_type' => $embedType,
            'content_type' => $segments[5],
            'content_id' => $segments[7],
        ];
        
    }
}
