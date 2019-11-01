<?php
/**
 * Ejemplo de creación de una orden de cobro vái cobro por email
 * Utiliza el método payment/createEmail
 * PHP Version 5.2
 *
 * @category  View
 * @package   createEmail
 * @author    flow.cl
 * @copyright 2019 (c) copyright
 * @license   Default copyright laws apply
 * @version   GIT: <git_id>
 * @link      https://www.flow.cl
 * @date      29/10/2019 22:54
 */


require(__DIR__ . "/../../lib/FlowApi.class.php");



try {

    //Prepara los parámetros
    $params = array(
        "commerceOrder" => random_int(1100, 2000),
        "subject" => "pago prueba cobro Email",
        "currency" => "CLP",
        "amount" => 2000,
        "email" => "cliente@gmail.com",
        "paymentMethod" => 9,
        "urlConfirmation" => Config::get("BASEURL") . "/examples/payments/confirm.php",
        "urlReturn" => Config::get("BASEURL") . "/examples/payments/result.php",
        "forward_days_after" => 1,
        "forward_times" => 2
    );

    $serviceName = "payment/createEmail";

    $flowApi = new FlowApi;
    $response = $flowApi->send($serviceName, $params, "POST");

    print_r($response);


} catch (Exception $e) {
    echo 'Error: ' , $e->getCode() , ' - ' , $e->getMessage();
}

