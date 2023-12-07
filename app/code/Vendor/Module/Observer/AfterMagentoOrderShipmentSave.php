<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoOrderShipmentSave
 * @package ONDC\Listener
 */
class AfterMagentoOrderShipmentSave extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() ?? "sales_order_shipment_save_after";
        parent::executeApiCall($observer, $observerName);
    }
}
