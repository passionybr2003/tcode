<?php
include_once 'GmailOath.php';
include_once 'Config.php';
session_start();
$oauth =new GmailOath($consumer_key, $consumer_secret, $argarray, $debug, $callback);
$getcontact=new GmailGetContacts();
$access_token=$getcontact->get_request_token($oauth, false, true, true);
$_SESSION['oauth_token']=$access_token['oauth_token'];
$_SESSION['oauth_token_secret']=$access_token['oauth_token_secret'];
$a = $access_token['oauth_token'];
?>

<a href="https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=<?php echo $oauth->rfc3986_decode($a) ?>"> <img src='Googleconnect.png' alt="Google Oauth Connect" border='0'/> </a>

