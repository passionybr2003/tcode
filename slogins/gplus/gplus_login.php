<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require_once 'src/apiClient.php';
require_once 'src/contrib/apiPlusService.php';

//session_start();

$client = new apiClient();
$client->setApplicationName("Takescript");
$client->setScopes(array('https://www.googleapis.com/auth/plus.me',
'https://www.googleapis.com/auth/userinfo.email',
'https://www.googleapis.com/auth/userinfo.profile'));
$plus = new apiPlusService($client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}

if ($client->getAccessToken()) {
  $me = $plus->people->get('me');

  $optParams = array('maxResults' => 100);
  $activities = $plus->activities->listActivities('me', 'public',$optParams);

  // The access token may have been updated lazily.
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
?>
 <?php if(isset($me))
 { 
 
 $_SESSION['gplusdata']=$me;
  header("location: http://localhost/takecode/php_script.php");
 
 } ?>

<?php
  if(isset($authUrl)) {
    print "<a href='$authUrl'> <div style='float:left;margin:5px;width:150px;height:50px;background:url(img/SocialLogin.png)-167px -3px'> </div> </a>";
  } else {
   print "<a class='logout' href='index.php?logout'>Logout</a>";
  }
?> 
















