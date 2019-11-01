<?php
/**
 * Obtienen el resultado de una transacción en base al commerceId de la transaccion
 * PHP Version 5.2
 *
 * @category  View
 * @package   getStatusByCommerceId
 * @author    flow.cl
 * @copyright 2019 (c) copyright
 * @license   Default copyright laws apply
 * @version   GIT: <git_id>
 * @link      https://www.flow.cl
 * @date      29/10/2019 22:54
 */
require(__DIR__ . "/../../lib/FlowApi.class.php");

try {
    $params = array(
        "commerceId" => "1306"
    );
    $serviceName = "payment/getStatusByCommerceId";
    $flowApi = new FlowApi();
    $response = $flowApi->send($serviceName, $params, "GET");

    print_r($response);


} catch (Exception $e) {
    echo 'Error: ' , $e->getCode() , ' - ' , $e->getMessage();
}

