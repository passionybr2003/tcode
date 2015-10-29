<?php
include_once 'GmailOath.php';
include_once 'Config.php';
session_start();
$oauth =new GmailOath($consumer_key, $consumer_secret, $argarray, $debug, $callback);
$getcontact_access=new GmailGetContacts();

echo $request_token=$oauth->rfc3986_decode($_GET['oauth_token']);
echo "<br>";
echo $request_token_secret=$oauth->rfc3986_decode($_SESSION['oauth_token_secret']);
echo "<br>";
echo $oauth_verifier= $oauth->rfc3986_decode($_GET['oauth_verifier']);
echo "<br>";
print_r($oauth);
echo "<br>";
$contact_access = $getcontact_access->get_access_token($oauth,$request_token, $request_token_secret,$oauth_verifier, false, true, true);
echo "<br>";
print_r($contact_access);

$access_token=$oauth->rfc3986_decode($contact_access['oauth_token']);
$access_token_secret=$oauth->rfc3986_decode($contact_access['oauth_token_secret']);
$contacts= $getcontact_access->GetContacts($oauth, $access_token, $access_token_secret, false, true,$emails_count);

echo "<br>";
print_r($contacts);


foreach($contacts as $k => $a)
{
	$final = end($contacts[$k]);
	foreach($final as $email)
	{
		echo $email["address"] ."<br />";
	}
}

?>
