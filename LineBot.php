<?php



// Backup function for hash_equals =========================================================

If (!Function_Exists('hash_equals')) {													// =

    Defined('USE_MB_STRING') OR Define('USE_MB_STRING', Function_Exists('mb_strlen'));	// =

    Function hash_equals($knownString, $userString) {									// =

        $strlen = function ($string) {													// =

            If (USE_MB_STRING) {														// =

                return MB_StrLen($string, '8bit');										// =

            }																			// =

            return StrLen($string);														// =

        };																				// =

        // Compare string lengths														// =

        If (($length = $strlen($knownString)) !== $strlen($userString)) {				// =

            return false;																// =

        }																				// =

        $diff = 0;																		// =

        // Calculate differences														// =

        For ($i = 0; $i < $length; $i++) {												// =

            $diff |= ORD($knownString[$i]) ^ ORD($userString[$i]);						// =

        }																				// =

        return $diff === 0;																// =

    }																					// =

}																						// =

// =========================================================================================



// Class to initialize client

Class LineBot {

	// Constructor function. Pass the Channel Access Token and the Channel Secret ==

	public function __construct($channelToken, $channelSecret) {				// =

		$this->channelAccessToken = $channelToken;								// =

        $this->channelSecret = $channelSecret;									// =

	}																			// =

	// =============================================================================

	

	// Function to retrieve events from Line and parse them ====================================

	Public Function parseEvents() {															// =

		// Prevents all but POST methods.													// =

		If ($_SERVER['REQUEST_METHOD'] !== 'POST') {										// =

            HTTP_Response_Code(405);														// =

            Error_Log("Method not allowed");												// =

            Exit();																			// =

        }																					// =

		// Pull the data from the POST request												// =

		$entityBody = File_Get_Contents('php://input');										// =

		// Check to see if the POST data is empty											// =

		If (StrLen($entityBody) === 0) {													// =

            HTTP_Response_Code(400);														// =

            Error_Log("Missing request body");												// =

            Exit();																			// =

        }																					// =

		// Check and validate Line signature												// =

		If (!hash_equals($this->sign($entityBody), $_SERVER['HTTP_X_LINE_SIGNATURE'])) {	// =

            HTTP_Response_Code(400);														// =

            Error_Log("Invalid signature value");											// =

            Exit();																			// =

        }																					// =

		// Save the data to a JSON array													// =

		$data = JSON_Decode($entityBody, true);												// =

		// Check to see if events exist														// =

		If (!Isset($data['events'])) {														// =

            HTTP_Response_Code(400);														// =

            Error_Log("Invalid request body: missing events property");						// =

            Exit();																			// =

        }																					// =

		return $data['events'];																// =

		//TODO var_dump the $data to view what else is available to use.					// =

	}																						// =

	// =========================================================================================

	

	// Send a message to the channel =======================================================================

	Public Function sendMessage($M) {																	// =

		// Set the headers to send with the request.													// =

		$Header = Array (																				// =

			"Content-Type: application/json",															// =

			'Authorization: Bearer ' . $this->channelAccessToken,										// =

		);																								// =

		$Context = Stream_Context_Create(																// =

			Array (																						// =

				"http" => Array (																		// =

					"method" => "POST",																	// =

					"header" => Implode("\r\n", $Header),												// =

					"content" => JSON_Encode($M),														// =

				),																						// =

			)																							// =

		);																								// =

		// Attempt to send the message and save response												// =

		$Response = File_Get_Contents('https://api.line.me/v2/bot/message/reply', false, $Context);		// =

		// Check to see if the request was successful													// =

		If (StrPos($http_response_header[0], '200') === false) {										// =

			HTTP_Response_Code(500);																	// =

            Error_Log("Request failed: " . $Response);													// =

        }																								// =

	}																									// =

	// =====================================================================================================

	

	// Encrypt the channel secret ==============================================

	Private Function sign($body) {											// =

        $hash = hash_hmac('sha256', $body, $this->channelSecret, true);		// =

        $signature = Base64_Encode($hash);									// =

        return $signature;													// =

    }																		// =

	// =========================================================================

}



function var_error_log( $object=null ){

    ob_start();                    // start buffer capture

    var_dump( $object );           // dump the values

    $contents = ob_get_contents(); // put the buffer into a variable

    ob_end_clean();                // end capture

    error_log( $contents );        // log contents of the result of var_dump( $object )

}