<?php

$baseUrl = "https://vending.softjourn.if.ua/api/";
$username = "";
$password = "";
$basicKey = "";

$data = get_access_token($baseUrl, $basicKey, $username, $password);
var_dump($data);
$data = get_refresh_token($baseUrl, $basicKey, $data->refresh_token);
var_dump($data);
$data = get_account($baseUrl, $data->access_token);
var_dump($data);

function get_access_token($baseUrl, $basicKey, $username, $password)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "${baseUrl}auth/oauth/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=${username}&password=${password}&grant_type=password");
    curl_setopt($ch, CURLOPT_USERPWD, base64_decode($basicKey)); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    $response = curl_exec ($ch);

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close ($ch);

    return json_decode($body);
}

function get_refresh_token($baseUrl, $basicKey, $refreshToken)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "${baseUrl}auth/oauth/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "refresh_token=${refreshToken}&grant_type=refresh_token");
    curl_setopt($ch, CURLOPT_USERPWD, base64_decode($basicKey)); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    $response = curl_exec ($ch);

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close ($ch);

    return json_decode($body);
}

function get_account($baseUrl, $accessToken)
{
    $headers = array(
	"Authorization: Bearer ${accessToken}"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "${baseUrl}coins/api/v1/account");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    $response = curl_exec ($ch);

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close ($ch);

    return json_decode($body);
}
