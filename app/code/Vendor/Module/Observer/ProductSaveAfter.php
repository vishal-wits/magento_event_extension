<?php
namespace Vendor\Module\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductSaveAfter implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        try {
            $product = $observer->getEvent()->getProduct(); 
            $httpClient = new \Magento\Framework\HTTP\Client();
            $httpClient->setUri('https://b7a9-115-240-127-98.ngrok-free.app/db/magentoEvents');
            $httpClient->setConfig(['timeout' => 30]); // Set a timeout if needed
            $httpClient->request('POST', [$product]); // Add your API parameters

            // Log the API response or handle it as needed
            $response = $httpClient->getBody();
            $this->logger->info('API Response: ' . $response);
        } catch (\Exception $e) {
            $this->logger->error('Error'. $e->getMessage());
        }
    }
}
