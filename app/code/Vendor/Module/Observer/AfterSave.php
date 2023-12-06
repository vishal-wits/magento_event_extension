<?php

namespace ONDC\Listener;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;

/**
 * Class AfterSave
 * @package ONDC\Listener
 */
abstract class AfterSave implements ObserverInterface {
    /**
     * @var CurlFactory
     */
    private CurlFactory $curlFactory;

    /**
     * @param Observer $observer
     *
     * @throws Exception
     */
    public function execute(Observer $observer) {
        $item = $observer->getDataObject();
        // Get the class name of the observer
        $observerClassName = get_class($observer);

        // Extract the event name from the observer class name
        $eventName = $this->extractEventName($observerClassName);
        $apiEndpoint = 'https://68fa-115-240-127-98.ngrok-free.app/db/magentoEvents';

        $requestData = [
            'event_name' => $eventName,
            'data' => $item->getData(),
        ];
        $this->sendDataToApi($apiEndpoint, $requestData);
    }

    /**
     * Send data to the API using a POST request
     *
     * @param string $apiEndpoint
     * @param array $requestData
     *
     * @throws Exception
     */
    private function sendDataToApi($apiEndpoint, $requestData) {
        $curl = $this->curlFactory->create();

        // Set cURL options
        $curl->setOption(CURLOPT_URL, $apiEndpoint);
        $curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $curl->setOption(CURLOPT_POST, true);
        $curl->setOption(CURLOPT_POSTFIELDS, json_encode($requestData));
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = $curl->execute();
        if($curl->getErrno()) {
            throw new Exception('Curl error: %s', $curl->getError() ?: null);
        }
        $curl->close();

    }

    /**
    * Extract event name from observer class name
    *
    * @param string $observerClassName
    *
    * @return string
    */
   private function extractEventName($observerClassName)
   {
       $parts = explode('\\', $observerClassName);
       return end($parts);
   }



}
