<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoOrderStatusSave
 * @package ONDC\Listener
 */
class AfterMagentoOrderStatusSave extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() || "ondc_order_status_history_save_after";
        parent::executeApiCall($observer, $observerName);
    }
}
