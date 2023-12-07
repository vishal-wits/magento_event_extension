<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoOrderSave
 * @package ONDC\Listener
 */
class AfterMagentoOrderSave extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() || "ondc_order_save_after";
        parent::executeApiCall($observer, $observerName);
    }
}
