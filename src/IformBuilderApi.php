<?php
namespace Demo;

use Demo\FormApi;

class IformBuilderAPI implements FormApi
{

    private $clientKey = "bd15f391bb0219ca96f4085d8dcbea19fe0a14da";
    private $secretKey = "3dec15d420a56645462abbc30946580f99249373";
    private $accessToken = "6be9af17597aaf492f05642befaab1f84367a3a5";
    private $profileId = "469854";
    private $pageId = "3634080";
    private $userId = "53941731";
    private static $instance = null;

    private function __construct()
    {

    }

    /**
    @return Object Returns the single instance of this class
     */
    public static function getInstance()
    {

        if (!isset($instance)) {
            $instance = new IformBuilderAPI();
        }

        return $instance;

    }

    /**
    @return String Returns the access token string
     */
    public function genAccessToken()
    {

        $jwtHeader = base64_encode('{"ALG":"HS256","TYP":"JWT"}');
        $jwtClaimSet = base64_encode('{
							   "ISS": $clientKey,
							   "AUD": "HTTPS://APP.IFORMBUILDER.COM/EXZACT/API/OAUTH/TOKEN",
							   "EXP": 1384370238,
							   "IAT": 1384370228
							}');
        $jwtSign = base64_encode('$secretKey');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.iformbuilder.com/exzact/api/oauth/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
			  \"ASSERTION\": \"$jwtHeader.$jwtClaimSet.$jwtSign\",
			}");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }

    /**
     * Sends a curl request
     */
    public function sendCurlRequest($url, $fields, $isPost = true)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer {$this->accessToken}",
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }

    /**
     * Save data from registration form
     */
    public function saveData($data)
    {

        $url = "https://app.iformbuilder.com/exzact/api/v60/profiles/$this->profileId/pages/$this->pageId/records";
        $fields['fields'] = array();
        foreach ($data as $k => $v) {
            $temp = array();
            $temp['element_name'] = $k;
            $temp['value'] = $v;
            $fields['fields'][] = $temp;
        }
        $newId = json_decode($this->sendCurlRequest($url, $this->toJSON($fields))); //Save record
        if(!isset($newId->id))
            print_r($newId); 
        $url = "https://app.iformbuilder.com/exzact/api/v60/profiles/$this->profileId/pages/$this->pageId/records/$newId->id/assignments";
        $fields = array();
        $fields['user_id'] = $this->userId;

        return $this->sendCurlRequest($url, $this->toJSON($fields)); //Assign to User

    }

    /**
     * Retrieve data from the server
     */
    public function getData()
    {
        $url = "https://app.iformbuilder.com/exzact/api/profiles/$this->profileId/pages/$this->pageId/feed?FORMAT=JSON";
        return $this->sendCurlRequest($url, "", false); //Assign to User
    }

    /**
     * Convert to JSON string
     */
    public function toJSON($data)
    {

        return json_encode($data);

    }

}
