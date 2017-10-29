<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "",
    'oauth_access_token_secret' => "",
    'consumer_key' => "",
    'consumer_secret' => ""
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/blocks/create.json';
$requestMethod = 'POST';

/** POST fields required by the URL above. See relevant docs as above **/
$postfields = array(
    'screen_name' => 'usernameToBlock', 
    'skip_status' => '1'
);

/** Perform a POST request and echo the response **/
$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/followers/ids.json';
$getfield = '?screen_name=J7mbo';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

// /** Perform a POST request with content type "application/json" and echo the response **/
// /** Note: `DO NOT` Set the POST field. Use curl options in performRequest instead **/
$url = 'https://api.twitter.com/1.1/direct_messages/events/new.json';
$postJson = [
    "event" => [
        "type" => "message_create",
        "message_create" => [
          "target" => [
            "recipient_id" => "" // Twitter ID
          ],
          "message_data" => [
            "text" => "Hello World!",
          ]
        ]
    ]
];
$requestMethod = 'POST';
$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->performRequest(true,[
                CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
                CURLOPT_POSTFIELDS => json_encode($postJson)
             ]);
