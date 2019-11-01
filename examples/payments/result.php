<?php
/**
 * Pagina del comercio para redireccion del pagador
 * A esta página Flow redirecciona al pagador pasando vía POST
 * el token de la transacción. En esta página el comercio puede
 * mostrar su propio comprobante de pago
 * PHP Version 5.2
 *
 * @category  View
 * @package   Result
 * @author    flow.cl
 * @copyright 2019 (c) copyright
 * @license   Default copyright laws apply
 * @version   GIT: <git_id>
 * @link      https://www.flow.cl
 * @date      29/10/2019 22:27
 */
require(__DIR__ . "/../../lib/FlowApi.class.php");

try {
    //Recibe el token enviado por Flow
    if (!isset($_POST["token"])) {
        throw new Exception('Token expected from flow.cl platform', 1);
    }
    $token = filter_input(INPUT_POST, 'token');
    $params = array(
        "token" => $token
    );
    //Indica el servicio a utilizar
    $serviceName = "payment/getStatus";
    $flowApi = new FlowApi();
    $response = $flowApi->send($serviceName, $params, "GET");

    print_r($response);

} catch (Exception $e) {
    echo 'Error: ' , $e->getCode() , ' - ' , $e->getMessage();
}

