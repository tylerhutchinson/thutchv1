<?php

	Require_Once('public_html/tylerhutchinson/line/linebot.php');

	// Set your channel token and secret.

	$channelAccessToken = 'mTxfgHMaJNjHWZ8wpgF1dVdXUar4SNbZGbbS6wtVGnB+dFPxJc0EGYko645v4FWKxa4dGg91Plz/N4+PT48CLs8IPsYZyUwmkuBWF44ZkMrGN9qFaPSpxZlCKTpGXqzTR34SNC1FHbKdetqHoC+qsQdB04t89/1O/w1cDnyilFU=';

	$channelSecret = '709110c372efb87f9e160d10ae21dc1c';

	

	// Create an instance of the LineBot

	$Client = new LineBot($channelAccessToken, $channelSecret);

	// Loop through each event

	ForEach ($Client->parseEvents() as $E) {

		// Event Handler

		Switch ($E['type']) {

			// Handle "message" events

			Case 'message':

				// Save the message and reply token to variables.

				$Message = $E['message'];

				$ReplyToken = $E['replyToken'];

				// Message type handler.

				Switch ($Message['type']) {

					// Handle text based messages.

					Case 'text':

						$Input = $Message['text'];

						$L = StrToLower($Input);

						$Output = "";

						

						If ($L == "glitchbot help") {

							$Output = "Hello! Below are a list of some of the phrases I respond to.\n\n\n";

							$Output .= "'intro': Displays some basic information about this bot.\n\n";

							$Output .= "'glitch website', 'glitch site': Gives you the link to our website.\n\n";

							$Output .= "'forgot password': Provides you with the link and instructions on how to reset your Glitch password.\n\n";

							$Output .= "'google play link': Provides the link to download Glitch from Google Play.\n\n";

							$Output .= "'glitch team': Displays a list of our current team members and their positions.\n\n";

							$Output .= "'glitch update', 'glitch updates': Provides basic details for the next update.";

						}

						

						ElseIf ($L == "intro") {

							$Output = "Hello, I'm a new in-development Line Messanger Bot for Glitch, Hacking Simulator! I don't do much yet but I am still being developed. I will be built slowly as the game is my developers primary focus! Please contact @FelixCrystal if you have any questions regarding this bot.\n\n";

							$Output .= "Version Number: 1B (Beta)\n";

							$Output .= "Revision Date: 12/04/2017";

						} ElseIf ($L == "glitch website" OR $L == "glitch site") {

							$Output = "The website for Glitch is:\n\n https://www.glitchednet.com";

						} ElseIf ($L == "forgot password") {

							$Output = "Hello! If you forgot your password for Glitch, go to the website below and enter the email address linked to your account. You will then be emailed a password reset link so you can change your password and get back to hacking!\n\nhttps://www.glitchednet.com/ForgotPassword";

						} ElseIf ($L == "google play link") {

							$Output = "Hello! The link to download Glitch, Hacking Simulator on Google Play is listed below!\n\nhttps://play.google.com/store/apps/details?id=com.glitchednet.app";

						} ElseIf ($L == "glitch team") {

							$Output = "Below is a list of our team members.\n\n\n";

							$Output .= "FelixCrystal:			Developer\n\n";

							$Output .= "thutchinson:			Developer\n\n";

							$Output .= "Junglist:				Administrator\n\n";

							$Output .= "warmachine673{deity):	Administrator\n\n";

							$Output .= "_Paradigm:				Moderator\n\n";

							$Output .= "Tusen2KxX:				Moderator\n\n";

							$Output .= "Stayxthirsty:			Moderator\n\n";

							$Output .= "JovaShade:				Moderator";

						} ElseIf ($L == "glitch update" OR $L == "glitch updates") {

							$VN = "1.32";

							$RD = "TO BE ANNOUNCED";

							$Output = "Hello! We are currently working on the next update for you! Please see below for a few details on the upcoming update.\n\n\n";

							$Output .= "Update Version Number: $VN.\n";

							$Output .= "Expected Release Date: $RD\n\n";

							$Output .= "Update Features:\n";

							$Output .= "* Fixing buttons crashing the game in the network screens.\n\n";

							$Output .= "* Analyzing lag and developing strategy to minimize.\n\n";

							$Output .= "* Optimizing network wars for better play and fixing network war keypad so you can remove the first key.\n\n";

							$Output .= "* Adding basic network bank features to pave a path for future updates.\n\n";

							$Output .= "* Other minor bug fixes.\n\n";

							$Output .= "\nIf you have any more suggestions, please submit them on our forums under the Suggestions category at https://www.glitchednet.com/forums !";

						} ElseIf ($L == "glitchbot code updates") {

							$Output = "thutch told you to say that, didn't he? -.-";

						} ElseIf ($L == "glitchbot act natural") {

							$Output = "BEEP. BOOP. BEEP BOOP BOP. I AM A ROBOT. I CAN NOT TALK. BEEP. BOOP.";

						} ElseIf ($L == "glitchbot code a log") {

							$Output = "You're a log.";

						} ElseIf ($L == "banana") {

							$Output = "Ba... Ba... B.....\n\n\n\n\n\n\nBAAAAAAAAA-FUCKING-NAAAAAAAA--FUCKING-NAAAAAAAAAAAAA";

						}

						

						If ($Output != "") {

							$Client->sendMessage(Array(

								'replyToken' => $ReplyToken,

								'messages' => Array(

									Array(

										'type' => 'text',

										'text' => $Output

									)

								)

							));

						}

						Break;

					// Unhandled message types

					Default:

						Error_Log("Unsupporeted message type: " . $Message['type']);

						Break;

				}

				Break;

			// Unhandled events

			Default:

				Error_Log("Unsupporeted event type: " . $E['type']);

				Break;

		}

	}

?>