<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\ConvertedTtsInterface;
use ChristianBrown\SmartThings\Model\PlayedTextInterface;
use ChristianBrown\SmartThings\Model\PlayTextRequestInterface;
use ChristianBrown\SmartThings\Model\TtsInfoInterface;
use ChristianBrown\SmartThings\Model\TtsRequestInterface;

interface TextToSpeechApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/services/tts';
    public const string API_URL_INFO = 'https://api.smartthings.com/v1/services/tts/info';
    public const string API_URL_PLAYTEXT = 'https://api.smartthings.com/v1/services/tts/playtext';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * Converts text to speech and returns the URL of the audio.
     */
    public function convert(TtsRequestInterface $request): ConvertedTtsInterface;

    /**
     * Lists the text-to-speech voices SmartThings offers.
     */
    public function getInfo(bool $skipCache = false): TtsInfoInterface;

    /**
     * Converts text to speech and plays it on a device.
     */
    public function playText(PlayTextRequestInterface $request): PlayedTextInterface;
}
