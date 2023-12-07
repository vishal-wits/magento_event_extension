<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoProductDelete
 * @package ONDC\Listener
 */
class AfterMagentoProductDelete extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() ?? "ondc_product_delete_after";
        parent::executeApiCall($observer, $observerName);
    }
}
