<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoProductSave
 * @package ONDC\Listener
 */
class AfterMagentoProductSave extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() || "ondc_product_save_after";
        parent::executeApiCall($observer, $observerName);
    }
}
