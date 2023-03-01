<?php

/*
 * Common Authentication Class
 * @author Shahriar
 */

class auth {

    private $_curl = '';
    private $_access_key = '';
    private $_access_secret = '';
    private $_access_token = '';
    private $_auth_mode = '';
    private $_auth_header = [];
    private $_auth_service = '';
    private $_auth_endpoint = '';
    private $_auth_scope = '';
    private $_auth_expire_time = '';
    private $_request_type = '';
    private $_request_body = [];
    private $_response_status = '';
    private $_response_body = '';

    public function __construct($service = '', $mode = 'sandbox', $request_type = 'POST', $config = []) {
        if ($service !== '') {
            $this->_auth_mode = trim($mode);
            $this->_auth_service = trim($service);
            $this->_request_type = trim($request_type);
            $this->loadCredentials($config);
        } else {
            $this->error('999', 'Authentication Service is Required');
        }
    }

    public function makeRequest($header = [], $payload = []) {
        $this->authHeader($header);
        $this->requestBody($payload);
        $this->sendRequest();
        $this->parseResponse();
        return [
            'access_token' => $this->_access_token,
            'expire_time' => $this->_auth_expire_time,
            'scope' => $this->_auth_scope,
        ];
    }

    public function __destruct() {
        $this->_curl = '';
        $this->_access_key = '';
        $this->_access_secret = '';
        $this->_access_token = '';
        $this->_auth_mode = '';
        $this->_auth_header = [];
        $this->_auth_service = '';
        $this->_auth_endpoint = '';
        $this->_auth_scope = '';
        $this->_auth_expire_time = '';
        $this->_request_type = '';
        $this->_request_body = [];
        $this->_response_status = '';
        $this->_response_body = '';
    }

    private function loadCredentials($config) {
        $this->_access_key = $config[$this->_auth_service][$this->_auth_mode]['api_key'];
        $this->_access_secret = $config[$this->_auth_service][$this->_auth_mode]['api_secret'];
        $this->_auth_endpoint = $config[$this->_auth_service][$this->_auth_mode]['auth'];
    }

    private function authHeader($header = []) {
        $this->_auth_header = [
            'Content-Type: application/x-www-form-urlencoded'
        ];
        if (count($header) > 0) {
            foreach ($header as $headerKey => $headerValue) {
                array_push($this->_auth_header, ($headerKey . ': ' . $headerValue));
            }
        }
    }

    private function requestBody($body = []) {
        $this->_request_body = [
            'client_id' => $this->_access_key,
            'client_secret' => $this->_access_secret
        ];
        if (count($body) > 0) {
            foreach ($body as $bodyKey => $bodyValue) {
                $this->_request_body[$bodyKey] = $bodyValue;
            }
        }
    }

    private function sendRequest() {
        if ($this->_request_type === 'GET') {
            $this->_auth_endpoint = $this->_auth_endpoint . '?' . http_build_query($this->_request_body);
        }
        $this->_curl = curl_init();
        curl_setopt($this->_curl, CURLOPT_URL, $this->_auth_endpoint);
        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->_curl, CURLOPT_TIMEOUT, 300);
        curl_setopt($this->_curl, CURLOPT_HTTPHEADER, $this->_auth_header);
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        if ($this->_request_type === 'POST') {
            curl_setopt($this->_curl, CURLOPT_POST, TRUE);
            curl_setopt($this->_curl, CURLOPT_POSTFIELDS, http_build_query($this->_request_body));
        }
        $this->_response_body = json_decode(curl_exec($this->_curl));
        $this->_response_status = curl_getinfo($this->_curl, CURLINFO_HTTP_CODE);
    }

    private function parseResponse() {
        if ($this->_response_status === 200) {
            $this->_access_token = $this->_response_body->access_token;
            $this->_auth_expire_time = $this->_response_body->expires_in;
            $this->_auth_scope = $this->_response_body->scope;
        } else {
            $this->error($this->_response_status, $this->_response_body);
        }
    }

    private function error($error_code = '', $error_msg = '') {
        echo '<div style="background-color: red; color: #fff; padding: 10px; margin: 10px 0px;">';
        echo '<strong>Error Code: ' . $error_code . '</strong>';
        echo '<br/>';
        echo '<strong>Error Messgae: <strong>';
        if ($this->_auth_service === 'fedex' && property_exists($error_msg, 'errors')) {
            echo '<ul>';
            foreach ($error_msg->errors as $message) {
                echo '<li>' . $message->message . '</li>';
            }
            echo '</ul>';
        } elseif ($this->_auth_service === 'ups' && property_exists($error_msg, 'response')) {
            echo '<ul>';
            foreach ($error_msg->response->errors as $message) {
                echo '<li>' . $message->message . '</li>';
            }
            echo '</ul>';
        }
        echo '</div>';
        die;
    }

}
