<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function ajax_response(CI_Output $output, int $status, string $message, ?array $data = null, ?array $mergeData = null){
    $response = array(
        'status'=>$status,
        'message'=>$message,
    );

    if ($data!==null) {
        unset($data['statusCode'], $data['message'], $data['totalData'], $data['totalCount'], $data['currentState']);
        $response['data']=$data;
    }

    if ($mergeData!==null) {
        $response = array_merge($response,$mergeData);
    }

    $output->set_content_type('appication/json')
        ->set_status_header($status)
        ->set_output(json_encode($response))
        ->_display();
        exit;
}


function curl_request(string $path="", string $method="GET", array $body = array() ){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => config_item('API_ENDPOINT').$path,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => json_encode($body)
    ));
    $res = curl_exec($curl);
    $response = json_decode($res);

    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) <= 300) {
        return $response;
    }
    return false;
}