<?php
/**
 * Spotify content plugin for Craft CMS 3.x
 *
 * Embed Spotify songs, playlists, or artists.
 *
 * @link      anzola.nl
 * @copyright Copyright (c) 2020 Jorge Anzola
 */

namespace jorgeanzola\spotifycontent;

use Craft;
use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;
use yii\base\Event;
use craft\base\Plugin;
use craft\services\Fields;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\RegisterComponentTypesEvent;
use jorgeanzola\spotifycontent\fields\SpotifyContentField;
use jorgeanzola\spotifycontent\services\Spotify as SpotifyService;
use jorgeanzola\spotifycontent\twigextensions\SpotifyContentTwigExtension;

/**
 * Class SpotifyContent
 *
 * @author    Jorge Anzola
 * @package   SpotifyContent
 * @since     1.0.0
 *
 * @property  SpotifyService $spotify
 */
class SpotifyContent extends Plugin
{
    // Static Properties
    // =========================================================================
    
    /**
     * @var SpotifyContent
     */
    public static $plugin;
    
    // Public Properties
    // =========================================================================
    
    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';
    
    /**
     * @var bool
     */
    public $hasCpSettings = false;
    
    /**
     * @var bool
     */
    public $hasCpSection = false;
    
    // Public Methods
    // =========================================================================
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        
        Craft::$app->view->registerTwigExtension(new SpotifyContentTwigExtension());
        
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['spotify-content/validate-string'] = '/spotify-content/validator/validate-spotify-string';
                $event->rules['spotify-content/convert-string'] = '/spotify-content/validator/convert-spotify-string';
            }
        );
        
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SpotifyContentField::class;
            }
        );
        
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );
        
        Craft::info(
            Craft::t(
                'spotify-content',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
    
    // Protected Methods
    // =========================================================================
    
}
