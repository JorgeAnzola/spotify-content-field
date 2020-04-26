<?php
/**
 * Spotify content plugin for Craft CMS 3.x
 *
 * Embed Spotify songs, playlists, or artists. 
 *
 * @link      anzola.nl
 * @copyright Copyright (c) 2020 Jorge Anzola
 */

namespace jorgeanzola\spotifycontent\twigextensions;

use jorgeanzola\spotifycontent\services\Spotify;
use jorgeanzola\spotifycontent\SpotifyContent;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author    Jorge Anzola
 * @package   SpotifyContent
 * @since     1.0.0
 */
class SpotifyContentTwigExtension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'SpotifyContent';
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('getSpotifyEmbedUrl', [$this, 'getSpotifyEmbedUrl']),
        ];
    }
    
    public function getSpotifyEmbedUrl($spotifyContentString): string
    {
        return (new Spotify())->getEmbedUrl($spotifyContentString);
    }
}
