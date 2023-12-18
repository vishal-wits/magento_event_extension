<?php

namespace ONDC\Listener\Observer;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\Auth\Session as AdminSession;

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
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var AdminSession
     */
    private $adminSession;

    /**
     * ONDCApiCall constructor.
     * @param CurlFactory $curlFactory
     */
    public function __construct(CurlFactory $curlFactory, StoreManagerInterface $storeManager, AdminSession $adminSession) {
        $this->curlFactory = $curlFactory;
        $this->storeManager = $storeManager;
        $this->adminSession = $adminSession;
    }

    /**
     * @param Observer $observer
     * @param string $observer
     * @throws Exception
     */
    public function executeApiCall(Observer $observer, string $observerName) {
        $item = $observer->getDataObject();
        $apiEndpoint = 'https://products-magento-dev.thewitslab.com/events';

        $requestData = [
            'event_name' => $observerName,
            'base_url' => $this->getBaseUrl(),
            'username' => $this->getLoggedInUsername(),
            'store_id' => $this->getLoggedInUserId(),
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
     * Get the base URL of the store
     *
     * @return string
     */
    private function getBaseUrl() {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    /**
     * Get the logged-in admin username
     *
     * @return string|null
     */
    private function getLoggedInUsername()
    {
        return $this->adminSession->getUser()->getUsername();
    }

    /**
     * Get the logged-in admin user ID
     *
     * @return int|null
     */
    private function getLoggedInUserId()
    {
        return $this->adminSession->getUser()->getId();
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
