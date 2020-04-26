<?php
/**
 * Spotify content plugin for Craft CMS 3.x
 *
 * Embed Spotify songs, playlists, or artists.
 *
 * @link      anzola.nl
 * @copyright Copyright (c) 2020 Jorge Anzola
 */

namespace jorgeanzola\spotifycontent\fields;

use Craft;
use yii\db\Schema;
use craft\base\Field;
use craft\helpers\Json;
use craft\base\ElementInterface;
use jorgeanzola\spotifycontent\validators\SpotifyContentFieldValidator;
use jorgeanzola\spotifycontent\assetbundles\spotifycontentfield\SpotifyContentFieldAsset;

/**
 * @author    Jorge Anzola
 * @package   SpotifyContent
 * @since     1.0.0
 */
class SpotifyContentField extends Field
{
    
    public $someAttribute;
    // Static Methods
    // =========================================================================
    
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('spotify-content', 'Spotify content');
    }
    
    
    /**
     * @return array
     */
    public function getElementValidationRules(): array
    {
        return [
            [SpotifyContentFieldValidator::class, 'field' => $this],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }
    
    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = NULL)
    {
        return $value;
    }
    
    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = NULL)
    {
        return parent::serializeValue($value, $element);
    }
    
    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'spotify-content/_components/fields/SpotifyContent_settings',
            [
                'field' => $this,
            ]
        );
    }
    
    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = NULL): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(SpotifyContentFieldAsset::class);
        
        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);
        
        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'label' => $this->name,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
        ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').SpotifyContentSpotifyContent(" . $jsonVars . ");");
        
        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'spotify-content/_components/fields/SpotifyContent_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'label' => $this->name,
                'primarySiteUrl' => Craft::$app->getSites()->getPrimarySite()->getBaseUrl(),
            ]
        );
    }
}
