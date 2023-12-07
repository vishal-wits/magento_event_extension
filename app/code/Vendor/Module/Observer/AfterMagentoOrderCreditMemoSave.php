<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoOrderCreditMemoSave
 * @package ONDC\Listener
 */
class AfterMagentoOrderCreditMemoSave extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() ?? "ondc_order_creditmemo_save_after";
        parent::executeApiCall($observer, $observerName);
    }
}
