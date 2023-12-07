<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoOrderDelete
 * @package ONDC\Listener
 */
class AfterMagentoOrderDelete extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() ?? "ondc_order_delete_after";
        parent::executeApiCall($observer, $observerName);
    }
}
