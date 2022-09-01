<?php
	// Set default timezone
	date_default_timezone_set('America/New_York');

    // Set domain
    $domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // Create DB object
    $connection = new PDO("mysql:host={$db['host']}; dbname={$db['name']}",$db['user'],$db['password']);
	global $connection;
    $db = new mysqli($db['host'], $db['user'], $db['password'], $db['name']);

    $query = "SELECT * FROM siteSettings LIMIT 1";
    $siteInfo = $connection->prepare($query);
    $siteInfo->execute();
    $count = $siteInfo->rowCount();
    $siteInfo = $siteInfo->fetch(PDO::FETCH_ASSOC);
    global $siteInfo;
	// Create unique ID


	function createPasteID() {
        global $db;
		global $connection;
        do {
            $repeat = false;
            $id = generateRandomString(8);
			$sql7 = "SELECT * FROM forms WHERE id = :id";
			$check = $connection->prepare($sql7);
			$check->execute(
				array(
					"id" => $id
				)
			);
			$count1 = $check->rowCount();
            if($count1 != 0) {
                $repeat = true;
            }

            else {
                return $id;
            }
        } while($repeat = true);
    }

	function createSubId() {
        global $db;
		global $connection;
        do {
            $repeat = false;
            $id = generateRandomString(8);
			$sql7 = "SELECT * FROM submissions WHERE id = :id";
			$check = $connection->prepare($sql7);
			$check->execute(
				array(
					"id" => $id
				)
			);
			$count1 = $check->rowCount();
            if($count1 != 0) {
                $repeat = true;
            }

            else {
                return $id;
            }
        } while($repeat = true);
    }
	
	function generateRandomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
    // API function
	function apiRequest($url, $post=FALSE, $headers=array()) {
		$ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($ch);


		if($post)
		    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

		$headers[] = 'Accept: application/json';

		if(session('access_token'))
		  $headers[] = 'Authorization: Bearer ' . session('access_token');

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		return json_decode($response);
  	}

	// Get function
	function get($key, $default=NULL) {
		return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
	}

	// Session function
	function session($key, $default=NULL) {
		return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
	}

	function sendEmbed($title, $url, $fields) {
		global $site;

		$timestamp = date("c", strtotime("now"));

		$json = json_encode([
			"username" => "Paste Now",

			"embeds" => [
				[
					"title" => $title,
					"type" => "rich",
					"url" => $url,
					"timestamp" => $timestamp,
					"footer" => [
						"icon_url" => $site['logo'],
					],
					"fields" => $fields,
				],
			],
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

		$ch = curl_init($site['webhook']);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
?>