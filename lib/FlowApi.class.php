<?php

/**
 * Clase cliente del Api2 de Flow
 * PHP Version 5.2
 *
 * @Filename: FlowApi.class.php
 * @version: 2.1
 * @Author: flow.cl
 * @Email: csepulveda@tuxpan.com
 * @Date: 28-04-2017 11:32
 * @Last Modified by: Carlos Sepulveda
 * @Last Modified time: 28-04-2017 11:32
 */

require(__DIR__ . "/Config.class.php");

class FlowApi
{

    protected $apiKey;
    protected $secretKey;


    public function __construct()
    {
        $this->apiKey = Config::get("APIKEY");
        $this->secretKey = Config::get("SECRETKEY");
    }


    /**
     * Funcion que invoca un servicio del Api de Flow
     *
     * @param string $service Nombre del servicio a ser invocado
     * @param array $params datos a ser enviados
     * @param string $method metodo http a utilizar
     *
     * @return string en formato JSON
     * @throws Exception
     */
    public function send($service, $params, $method = "GET")
    {
        $method = strtoupper($method);
        $url = Config::get("APIURL") . "/" . $service;
        $params = array("apiKey" => $this->apiKey) + $params;
        $params["s"] = $this->sign($params);
        if ($method == "GET") {
            $response = $this->httpGet($url, $params);
        } else {
            $response = $this->httpPost($url, $params);
        }

        if (isset($response["info"])) {
            $code = $response["info"]["http_code"];
            if (!in_array($code, array("200", "400", "401"))) {
                throw new Exception("An unexpected HTTP_CODE error occurred: " . $code, $code);
            }
        }
        $body = json_decode($response["output"], true);
        return $body;
    }

    /**
     * Funcion que firma los parametros
     *
     * @param array $params Parametros a firmar
     *
     * @return string de firma
     * @throws Exception
     */
    private function sign($params)
    {
        $keys = array_keys($params);
        sort($keys);
        $toSign = "";
        foreach ($keys as $key) {
            $toSign .= $key . $params[$key];
        }
        if (!function_exists("hash_hmac")) {
            throw new Exception("hash_hmac function does not exist", 1);
        }
        return hash_hmac('sha256', $toSign, $this->secretKey);
    }

    /**
     * Funcion que hace el llamado via http GET
     *
     * @param string $url url a invocar
     * @param $params
     * @return array en formato JSON
     * @throws Exception
     */
    private function httpGet($url, $params)
    {
        $url = $url . "?" . http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($ch);
        if ($output === false) {
            $error = curl_error($ch);
            throw new Exception($error, 1);
        }
        $info = curl_getinfo($ch);
        curl_close($ch);
        return array("output" => $output, "info" => $info);
    }

    /**
     * Funcion que hace el llamado via http POST
     *
     * @param string $url url a invocar
     * @param array $params datos a enviar
     * @return array en formato JSON
     * @throws Exception
     */
    private function httpPost($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $output = curl_exec($ch);
        if ($output === false) {
            $error = curl_error($ch);
            throw new Exception($error, 1);
        }
        $info = curl_getinfo($ch);
        curl_close($ch);
        return array("output" => $output, "info" => $info);
    }

    /**
     * Function to set the apiKey and secretKey and not use those of the
     * configuration. Get your apiKey and secretKey depending on whether it is
     * in production or sandbox. (Both require registering separately).
     * https://www.flow.cl/api
     *
     * @param string $apiKey Api Key
     * @param string $secretKey Secret Key
     */
    public function setKeys($apiKey, $secretKey)
    {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
    }


}
