<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterMagentoCategorySave
 * @package ONDC\Listener
 */
class AfterMagentoCategorySave extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        $observerName = $observer->getName() ?? "ondc_category_save_after";
        parent::executeApiCall($observer, $observerName);
    }
}
