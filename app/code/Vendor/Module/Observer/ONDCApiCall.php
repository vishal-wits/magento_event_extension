<?php

namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;

/**
 * Class ONDCApiCall
 * @package ONDC\Listener
 */
abstract class ONDCApiCall implements ObserverInterface {
    /**
     * @var CurlFactory
     */
    private $curlFactory;

    /**
     * ONDCApiCall constructor.
     * @param CurlFactory $curlFactory
     */
    public function __construct(CurlFactory $curlFactory) {
        $this->curlFactory = $curlFactory;
    }

    /**
     * @param Observer $observer
     * @param string $observer
     * @throws Exception
     */
    public function executeApiCall(Observer $observer, string $observerName) {
        $item = $observer->getDataObject();
        $apiEndpoint = 'https://e733-115-240-127-98.ngrok-free.app/db/magentoEvents';

        $requestData = [
            'event_name' => $observerName,
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
     */
    private function sendDataToApi($apiEndpoint, $requestData) {
        $curl = $this->curlFactory->create();
  
        $curl->setOption(CURLOPT_URL, $apiEndpoint);
        $curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $curl->setOption(CURLOPT_POST, true);
        $curl->setOption(CURLOPT_POSTFIELDS, json_encode($requestData));
        $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = $curl->post($apiEndpoint, $requestData);
    }

}
