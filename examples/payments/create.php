<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 * PHP Version 5.2
 *
 * @category  View
 * @package   Create
 * @author    flow.cl
 * @copyright 2019 (c) copyright
 * @license   Default copyright laws apply
 * @version   GIT: <git_id>
 * @link      https://www.flow.cl
 * @date      29/10/2019 22:55
 */
require(__DIR__ . "/../../lib/FlowApi.class.php");


try {
    //Para datos opcionales campo "optional" prepara un arreglo JSON
    $optional = array(
        "rut" => "9999999-9",
        "otroDato" => "otroDato"
    );
    $optional = json_encode($optional);

    //Prepara el arreglo de datos
    $params = array(
        "commerceOrder" => random_int(1100, 2000),
        "subject" => "Pago de prueba",
        "currency" => "CLP",
        "amount" => 5000,
        "email" => "cliente@gmail.com",
        "paymentMethod" => 9,
        "urlConfirmation" => Config::get("BASEURL") . "/examples/payments/confirm.php",
        "urlReturn" => Config::get("BASEURL") . "/examples/payments/result.php",
        "optional" => $optional
    );
    //Define el metodo a usar
    $serviceName = "payment/create";


    // Instancia la clase FlowApi
    $flowApi = new FlowApi;
    // Ejecuta el servicio
    $response = $flowApi->send($serviceName, $params, "POST");
    //Prepara url para redireccionar el browser del pagador
    $redirect = $response["url"] . "?token=" . $response["token"];
    header("location:$redirect");
} catch (Exception $e) {
    echo $e->getCode() . " - " . $e->getMessage();
}

