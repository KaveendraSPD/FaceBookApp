
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>TestApp_HomePage</title>

    <style>
        .button {
            background-color: #008CBA; /* Blue */
            border: none;
            color: white;
            padding: 30px 62px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
        }

        html, body, #wrapper {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #wrapper {
            position: relative;
        }

        #top, #middle, #bottom {
            position: absolute;
        }

        #top {
            height: 70px;
            width: 100%;
            background: grey;
			text-align:center;
        }

        #middle {
            top: 50px;
            bottom: 50px;
            width: 100%;
            /*background: black;*/
            text-align: center;
			position: absolute;
			z-index:0;
            
        }
		.inner {
			position:absolute;
			z-index:1;
			bottom:32%;
			right:42%;
		}
		
        #bottom {
            bottom: 0;
            height: 50px;
            width: 100%;
            background: grey;
        }
    </style>

</head>

<body>
	<div id="wrapper">
        <div id="top"><h1>DEATH CAlCULATOR</h1>	</div>
        <div id="middle" style="padding-top:5%">
            <!--<img src="6e9114ff.png" alt="Photo_Frame" >-->
            <div class="inner">
					<!-- START OF PHP SECTION -->
						<?php
								if (!session_id()) {
									session_start();
								}


								ini_set('display_errors', 1);
								error_reporting(~0);

								// Include the autoloader provided in the SDK
								require_once ('C:/wamp/www/php-graph-sdk-5.5/src/Facebook/autoload.php');

								$fb = new Facebook\Facebook([
								  'app_id' => '442605952781188', // Replace {app-id} with your app id
								  'app_secret' => '3c84f42b2478676971d8c0d9f10b30f2',
								  'default_graph_version' => 'v2.4',
								  ]);

								$helper = $fb->getRedirectLoginHelper();
								$_SESSION['FBRLH_state']=$_GET['state'];

								try {
								  $accessToken = $helper->getAccessToken();
								} catch(Facebook\Exceptions\FacebookResponseException $e) {
								  // When Graph returns an error
								  echo 'Graph returned an error: ' . $e->getMessage();
								  exit;
								} catch(Facebook\Exceptions\FacebookSDKException $e) {
								  // When validation fails or other local issues
								  echo 'Facebook SDK returned an error: ' . $e->getMessage();
								  exit;
								}

								if (! isset($accessToken)) {
								  if ($helper->getError()) {
									header('HTTP/1.0 401 Unauthorized');
									echo "Error: " . $helper->getError() . "\n";
									echo "Error Code: " . $helper->getErrorCode() . "\n";
									echo "Error Reason: " . $helper->getErrorReason() . "\n";
									echo "Error Description: " . $helper->getErrorDescription() . "\n";
								  } else {
									header('HTTP/1.0 400 Bad Request');
									echo 'Bad request';
								  }
								  exit;
								}

								$_SESSION['fb_access_token'] = (string) $accessToken;

								//RETRIEVE USER PROFILE
								 try {
								  // Returns a `Facebook\FacebookResponse` object
										//$response = $fb->get('me?fields=picture,name,email', $accessToken->getValue());
										$requestPicture = $fb->get('/me/picture?redirect=false&height=300',$accessToken->getValue()); //getting user picture
										$requestProfile = $fb->get('/me',$accessToken->getValue()); // getting basic info
										$requestBirthday = $fb->get('me?fields=birthday',$accessToken->getValue());
										
										
										
										$profile = $requestProfile->getGraphUser();
										$birthday = $requestBirthday->getGraphUser();
										
								} catch(Facebook\Exceptions\FacebookResponseException $e) {
								  echo 'Graph returned an error: ' . $e->getMessage();
								  exit;
								} catch(Facebook\Exceptions\FacebookSDKException $e) {
								  echo 'Facebook SDK returned an error: ' . $e->getMessage();
								  exit;
								}
								// showing picture on the screen
								//echo "<img src='".$picture['url']."'/>";

						?>
					<!-- END OF PHP SECTION -->
					</div>
					<div style = text-align:center>
					<div>
						<!-- START OF PHP SECTION -->
						<?php
							$birthYear = (int)$birthday["birthday"]->format('Y');
							$currentYear = (int)date("Y");
							$yearDifference = $currentYear - $birthYear;
							
							if (('$yearDifference >= 0') &('$yearDifference < 20')){
								$deathDate = ($currentYear+80);
									
							}else if (('$yearDifference >= 20 ')AND ('$yearDifference < 30')){
								$deathDate = ($currentYear+70);
									
							}else if (('$yearDifference >= 30 ')AND ('$yearDifference < 40')){
								$deathDate = ($currentYear+60);
									
							}else if (('$yearDifference >= 40 ')AND ('$yearDifference < 50')){
								$deathDate = ($currentYear+50);
									
							}else if (('$yearDifference >= 50 ')AND ('$yearDifference < 60')){
								$deathDate = ($currentYear+40);
									
							}else if (('$yearDifference >= 60 ')AND ('$yearDifference < 70')){
								$deathDate = ($currentYear+30);
									
							}else if (('$yearDifference >= 70 ')AND ('$yearDifference < 80')){
								$deathDate = ($currentYear+20);
									
							}else if (('$yearDifference >= 80 ')AND ('$yearDifference < 90')){
								$deathDate = ($currentYear+10);
									
							}else{
								$deathDate = ($currentYear+1);
								
							}
							
							//IMAGE PROCESSING
							$picture = $requestPicture->getGraphNode();
							$object = $requestPicture->getGraphObject();
							$pic = $object->asArray('height');
							
							$gen=uniqid();
							
							copy($pic['url'], '/wamp/www/'.$gen.'.jpg');
							
							$framePic = imagecreatefromjpeg('new.jpg');
							$proPic = imagecreatefromjpeg($gen.'.jpg');
							
							// Allocate A Color For The Text
							$black = imagecolorallocate($framePic, 0, 0, 0);
							
							// Set Path to Font File
							$font_path = 'font.ttf';
							
							// Print Text On Image
							imagettftext($framePic, 18, 0, 210, 520, $black, $font_path, $profile['name']);
							imagettftext($framePic, 18, 0, 230, 540, $black, $font_path, "You will be die in ");
							imagettftext($framePic, 20, 0, 270, 560, $black, $font_path, $deathDate);
							
							// Output and free memory
							ob_start (); 
							// Copy and merge
							imagecopymerge($framePic,$proPic, 100, 100, -50, -50, 400, 400, 100);

							imagejpeg ($framePic);
							$image_data = ob_get_contents (); 

							ob_end_clean (); 

							$image_data_base64 = base64_encode ($image_data);

							// Send Image to Browser
							echo "<img src='data:image/jpeg;base64,$image_data_base64'>";

							file_put_contents($gen.'.jpg',base64_decode($image_data_base64));
							$url__='http://localhost/'.$gen.'.jpg';
										
							
							
							try {
							  // Returns a `Facebook\FacebookResponse` object
							  $response = $fb->post('/me/photos',array( 'message' => 'DEATH CAlCULATOR.','source' => $fb->fileToUpload($url__)), $accessToken->getValue());
							} catch(Facebook\Exceptions\FacebookResponseException $e) {
							  echo 'Graph returned an error: ' . $e->getMessage();
							  exit;
							} catch(Facebook\Exceptions\FacebookSDKException $e) {
							  echo 'Facebook SDK returned an error: ' . $e->getMessage();
							  exit;
							}

							$graphNode = $response->getGraphNode();

							echo 'Photo ID: ' . $graphNode['id'];
							
							
							
							
						?>
					</div>
						<!-- END OF PHP SECTION -->
					</div>
		</div>

		<div id="bottom"></div>
    </div>
</body>

</html>
