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
    private $curlFactory;

    /**
     * AfterSave constructor.
     * @param CurlFactory $curlFactory
     */
    public function __construct(CurlFactory $curlFactory) {
        $this->curlFactory = $curlFactory;
    }

    /**
     * @param Observer $observer
     * @throws Exception
     */
    public function execute(Observer $observer) {
        $item = $observer->getDataObject();
        $observerClassName = get_class($observer);
        $eventName = $this->extractEventName($observerClassName);
        $apiEndpoint = 'https://68fa-115-240-127-98.ngrok-free.app/db/magentoEvents';

        $requestData = [
            'event_name' => $eventName,
            'data' => $item->getData(),
        ];
        
        try {
            $this->sendDataToApi($apiEndpoint, $requestData);
        } catch (Exception $e) {
            // Log the error instead of throwing an exception
            // $this->_logger->error($e->getMessage());
        }
    }

    /**
     * @param string $apiEndpoint
     * @param array $requestData
     * @throws Exception
     */
    private function sendDataToApi($apiEndpoint, $requestData) {
        $curl = $this->curlFactory->create();

        $curl->setOption(CURLOPT_URL, $apiEndpoint);
        $curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $curl->setOption(CURLOPT_POST, true);
        $curl->setOption(CURLOPT_POSTFIELDS, json_encode($requestData));
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = $curl->execute();
        if (curl_errno($curl)) {
            throw new Exception(sprintf('cURL error: %s', curl_error($curl)));
        }

        $curl->close();
    }

    /**
     * @param string $observerClassName
     * @return string
     */
    private function extractEventName($observerClassName) {
        $parts = explode('\\', $observerClassName);
        return end($parts);
    }
}
