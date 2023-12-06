<?php
namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterEventTrigger
 * @package ONDC\Listener
 */
class AfterEventTrigger extends ONDCApiCall
{
    public function execute(Observer $observer)
    {
        parent::execute($observer);
    }
}
