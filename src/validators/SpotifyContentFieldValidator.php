<?php

namespace jorgeanzola\spotifycontent\validators;

use yii\validators\RegularExpressionValidator;
use jorgeanzola\spotifycontent\services\Spotify;

/**
 * Class LinkFieldValidator
 * @package typedlinkfield
 */
class SpotifyContentFieldValidator extends RegularExpressionValidator
{
    public $field;
    
    public function __construct()
    {
        $this->pattern = (new Spotify())->getRegex();
        
        parent::__construct();
    }
}
