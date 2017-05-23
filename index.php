
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
            <img src="new.jpg" alt="Photo_Frame">
            <br />
					<?php
						//START SESSION
						if (!session_id()) {
						session_start();
						}
						
						ini_set('display_errors', 1);
						error_reporting(~0);
						
						require_once ('C:/wamp/www/php-graph-sdk-5.5/src/Facebook/autoload.php');
						
						$fb = new Facebook\Facebook([
						  'app_id' => '442605952781188', // Replace {app-id} with your app id
						  'app_secret' => '3c84f42b2478676971d8c0d9f10b30f2',
						  'default_graph_version' => 'v2.2',
						  ]);

						$helper = $fb->getRedirectLoginHelper();

						$permissions = array("email","user_posts","publish_actions","user_posts","user_photos","user_birthday"); // Optional permissions
						$loginUrl = $helper->getLoginUrl('http://localhost/call-back.php', $permissions);

						
						echo '<a href="' . htmlspecialchars($loginUrl) . '" class="button">Login with Facebook</a>';
						
					?>
		</div>
		<div id="bottom"></div>
    </div>
</body>

</html>
