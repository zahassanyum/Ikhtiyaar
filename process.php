<?php

require 'vendor/autoload.php';
include('lib/mysql.class.php');

$db = new MySQL();

$error = "";

date_default_timezone_set('Asia/Karachi');

$fb = new Facebook\Facebook([
    'app_id' => '249684425365723',
    'app_secret' => '591448e971da528c6d9606bb738d1ed2',
    'default_graph_version' => 'v2.5',
]);

// the facebook token cookie is not set
if(!isset($_COOKIE['fb_token'])) {
    session_unset();
    die("Error: You must login using your Facebook account first to post your complaint.");
}

$fb->setDefaultAccessToken($_COOKIE['fb_token']);

try {
    $response = $fb->get('/me?fields=id,name,email,gender,link');
    $fb_user = $response->getGraphUser();

    $response = $fb->get('/me/picture?fields=url&width=100&height=100');
    $headers = $response->getHeaders();
    $profile_pic = $headers["Location"];
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$user_id = $fb_user["id"];
$user_name = $fb_user["name"];

$sql = "SELECT COUNT(*) FROM user WHERE id = " . $user_id;
$count = (int)$db->QuerySingleValue($sql);
if (!$count) {
    $values = array();
    $values["id"] = MySQL::SQLValue($user_id);
    $values["name"] = MySQL::SQLValue($fb_user["name"]);
    $values["email"] = MySQL::SQLValue($fb_user["email"]);
    $values["gender"] = MySQL::SQLValue($fb_user["gender"]);
    $values["profile_link"] = MySQL::SQLValue($fb_user["link"]);
    $values["profile_pic"] = MySQL::SQLValue($profile_pic);

    $result = $db->InsertRow("user", $values);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $values = array();
    $values["title"] = MySQL::SQLValue($_POST["title"]);
    $values["details"]  = MySQL::SQLValue($_POST["details"]);
    $values["location"]  = MySQL::SQLValue($_POST["formatted_address"]);
    $values["datetime"] = MySQL::SQLValue(date("Y-m-d H:i:s"), MySQL::SQLVALUE_DATETIME);  # e.g. 2001-03-10 17:16:18 (the MySQL DATETIME format)
    $values["category_id"]  = MySQL::SQLValue($_POST["category_id"], MySQL::SQLVALUE_NUMBER);
    $values["user_id"]  = MySQL::SQLValue($user_id);

    $result = $db->InsertRow("complaint", $values);
    if (!$result) $error = $db->error();

    /* Media uploading -------------- */

    if (!$error) {
        $complaint_id = $db->GetLastInsertID();

        # Loop through each file
        for ($i = 0; $i < count($_FILES['media']['name']); $i++) {
            # Get the temp file path
            $tmpFilePath = $_FILES['media']['tmp_name'][$i];

            # Make sure we have a filepath
            if ($tmpFilePath != ""){
                # Setup our new file path
                $newFilePath = "media/" . $_FILES['media']['name'][$i];

                # Upload the file into the temp dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $values = array();
                    $values["path"] = MySQL::SQLValue($newFilePath);
                    $values["complaint_id"] = MySQL::SQLValue($complaint_id, MySQL::SQLVALUE_NUMBER);
                    $result = $db->InsertRow("media", $values);
                    if (!$result) {
                        $error = $db->error();
                        break;
                    }
                }
                else {
                    $error = "There was an error in uploading the media file(s).";
                }
            }
        }
    }

    if (!$error) {
        echo  "Your complaint has been recorded successfully. Thank you for your time, {$user_name}.";
    }
    else {
        echo "Error: " . $error;
    }
}

?>