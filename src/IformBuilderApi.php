<?php
namespace Demo;

use Demo\FormApi;

class IformBuilderAPI implements FormApi
{

    private $clientKey = "bd15f391bb0219ca96f4085d8dcbea19fe0a14da";
    private $secretKey = "3dec15d420a56645462abbc30946580f99249373";
    private $accessToken = null;
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

        $arr = array();
        $arr['alg'] = "HS256";
        $arr['typ'] = "JWT";
        $jwtHeader = $this->base64UrlEncode(json_encode($arr));

        $arr = array();
        $arr['iss'] = $this->clientKey;
        $arr['aud'] = "https://app.iformbuilder.com/exzact/api/oauth/token";
        $arr['exp'] = time() + 600;
        $arr['iat'] = time();
        $jwtClaimSet = $this->base64UrlEncode(json_encode($arr));

        $data = $jwtHeader.".".$jwtClaimSet;
        $sign = $this->base64UrlEncode(hash_hmac('sha256', $data, $this->secretKey,true));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.iformbuilder.com/exzact/api/oauth/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_POST, true);

        $arr = array();
        $arr['grant_type'] = "urn:ietf:params:oauth:grant-type:jwt-bearer";
        $arr['assertion'] = $jwtHeader.".".$jwtClaimSet.".".$sign;

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arr));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $responseArr = json_decode($response,true);

        return $responseArr['access_token'];

    }


    /**
     * Sets a new access token
     */
    public function setAccessToken(){
        
        $accessToken = $this->genAccessToken();
        $this->accessToken = $accessToken;
        
    } 
    

    /**
     * Sends a curl request
     */
    public function sendCurlRequest($url, $fields, $isPost = true)
    {
        
        $this->setAccessToken();

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

    /**
     * Base64 URL Encoding
     */
    public function base64UrlEncode($data)
    {
      return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
    }

}
