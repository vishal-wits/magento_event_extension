<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoCustomerSave
 * @package ONDC\Listener
 */
class AfterMagentoCustomerSave extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() ?? "ondc_customer_save_after";
        parent::executeApiCall($observer, $observerName);
    }
}
