<?php
/**
 * Spotify content plugin for Craft CMS 3.x
 *
 * Embed Spotify songs, playlists, or artists. 
 *
 * @link      anzola.nl
 * @copyright Copyright (c) 2020 Jorge Anzola
 */

namespace jorgeanzola\spotifycontent\assetbundles\spotifycontentfield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Jorge Anzola
 * @package   SpotifyContent
 * @since     1.0.0
 */
class SpotifyContentFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@jorgeanzola/spotifycontent/assetbundles/spotifycontentfield/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/SpotifyContent.js',
        ];

        $this->css = [
            'css/SpotifyContent.css',
        ];

        parent::init();
    }
}
