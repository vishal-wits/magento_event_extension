<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoCategoryDelete
 * @package ONDC\Listener
 */
class AfterMagentoCategoryDelete extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() ?? "ondc_category_delete_after";
        parent::executeApiCall($observer, $observerName);
    }
}
