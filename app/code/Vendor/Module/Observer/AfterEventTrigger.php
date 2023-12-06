<?php
namespace ONDC\Listener;

use Exception;
use Magento\Framework\Event\Observer;

/**
 * Class AfterEventTrigger
 * @package ONDC\Listener
 */
class AfterEventTrigger extends AfterSave
{
    /**
     * @param Observer $observer
     *
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        parent::execute($observer);
    }
}
