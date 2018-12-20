<?php

/*
  |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
  || Apple Push Notification Configurations
  |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 */


/*
  |--------------------------------------------------------------------------
  | APN Permission file
  |--------------------------------------------------------------------------
  |
  | Contains the certificate and private key, will end with .pem
  | Full server path to this file is required.
  |
 */
//$config['PermissionFileDev'] = '/var/www/html/development.pem';
//$config['PermissionFileDev'] = '/var/www/html/evapp.pem';
$config['PermissionFileProd'] = '/var/www/html/TeamspirePush.pem';



/*
  |--------------------------------------------------------------------------
  | APN Private Key's Passphrase
  |--------------------------------------------------------------------------
 */
$config['PassPhrase'] = '1234';

/*
  |--------------------------------------------------------------------------
  | APN Services
  |--------------------------------------------------------------------------
 */

//$config['Sandbox'] = true; //dev
//$config['Sandbox'] = false; //prod


$headers = getallheaders();

$config['Sandbox'] = false; //prod
if (isset($headers['Env']) && $headers['Env']) {
    if (strtolower($headers['Env']) == 'd') {
        $config['Sandbox'] = true; //dev
    } else {
        $config['Sandbox'] = false; //prod
    }
}
/*
  |--------------------------------------------------------------------------
  | APN Permission file
  |--------------------------------------------------------------------------
  |
  | Contains the certificate and private key, will end with .pem
  | Full server path to this file is required.
  |
 */
$config['PermissionFile'] = $config['PermissionFileProd'];
if ($config['Sandbox']) {
    $config['PermissionFile'] = $config['PermissionFileProd'];
}




$config['PushGatewaySandbox'] = 'ssl://gateway.sandbox.push.apple.com:2195';






$config['PushGateway'] = 'ssl://gateway.push.apple.com:2195';


$config['FeedbackGatewaySandbox'] = 'ssl://feedback.sandbox.push.apple.com:2196';
$config['FeedbackGateway'] = 'ssl://feedback.push.apple.com:2196';


/*
  |--------------------------------------------------------------------------
  | APN Connection Timeout
  |--------------------------------------------------------------------------
 */
$config['Timeout'] = 60;


/*
  |--------------------------------------------------------------------------
  | APN Notification Expiry (seconds)
  |--------------------------------------------------------------------------
  | default: 86400 - one day
 */
$config['Expiry'] = 86400;
