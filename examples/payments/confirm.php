<?php
/**
 * Pagina del comercio para recibir la confirmación del pago
 * Flow notifica al comercio del pago efectuado
 * PHP Version 5.2
 *
 * @category  View
 * @package   confirm
 * @author    flow.cl
 * @copyright 2019 (c) copyright
 * @license   Default copyright laws apply
 * @version   GIT: <git_id>
 * @link      https://www.flow.cl
 * @date      29/10/2019 22:56
 */
require(__DIR__ . "/../../lib/FlowApi.class.php");

try {
    if (!isset($_POST["token"])) {
        throw new Exception("Token expected from flow.cl platform", 1);
    }
    $token = filter_input(INPUT_POST, 'token');
    $params = array(
        "token" => $token
    );
    $serviceName = "payment/getStatus";
    $flowApi = new FlowApi();
    $response = $flowApi->send($serviceName, $params, "GET");

    //Actualiza los datos en su sistema

    print_r($response);


} catch (Exception $e) {
    echo "Error: " . $e->getCode() . " - " . $e->getMessage();
}
