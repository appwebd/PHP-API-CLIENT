<?php
/**
 * Ejemplo de creación de una orden de cobro vái cobro por email
 * Utiliza el método payment/createEmail
 */
require(__DIR__ . "/../../lib/FlowApi.class.php");

//Prepara los parámetros
$params = array(
	"commerceOrder" => rand(1100,2000),
	"subject" => "pago prueba cobro Email",
	"currency" => "CLP",
	"amount" => 2000,
	"email" => "cliente@gmail.com",
	"paymentMethod" => 9,
	"urlConfirmation" => Config::get("BASEURL") . "/examples/payments/confirm.php",
	"urlReturn" => Config::get("BASEURL") ."/examples/payments/result.php",
	"forward_days_after" => 1,
	"forward_times" => 2
);

$serviceName = "payment/createEmail";

try {
	$flowApi = new FlowApi;

	$response = $flowApi->send($serviceName, $params,"POST");

	print_r($response);


} catch (Exception $e) {
	echo $e->getCode() . " - " . $e->getMessage();
}

