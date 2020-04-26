<?php

namespace jorgeanzola\spotifycontent\controllers;

use Craft;
use craft\web\Controller;
use jorgeanzola\spotifycontent\services\Spotify;
use jorgeanzola\spotifycontent\validators\SpotifyContentFieldValidator;

class ValidatorController extends Controller
{
    protected $allowAnonymous = ['convert-spotify-string', 'validate-spotify-string'];
    
    public function actionConvertSpotifyString()
    {
        $string = Craft::$app->getRequest()->post('string');
        
        $validator = new SpotifyContentFieldValidator();
        
        if (! $validator->validate($string, $error)) {
            return $this->asErrorJson('Invalid value')->setStatusCode(422);
        }
        
        $spotifyContentService = new Spotify();
        
        return $this->asJson($spotifyContentService->stringValidation($string, true));
    }
    
    public function actionValidateSpotifyString()
    {
        $string = Craft::$app->getRequest()->post('string');
        
        $validator = new SpotifyContentFieldValidator();
        
        if (! $validator->validate($string, $error)) {
            return $this->asErrorJson('Invalid value')->setStatusCode(422);
        }
        
        $spotifyContentService = new Spotify();
        
        return $this->asJson($spotifyContentService->stringValidation($string));
    }
}
