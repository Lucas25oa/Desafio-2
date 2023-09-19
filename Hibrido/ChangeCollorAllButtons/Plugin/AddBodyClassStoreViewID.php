<?php

namespace Hibrido\ChangeCollorAllButtons\Plugin;


use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\Page;

/**
 * Class AddBodyClassStoreViewID
 */
class AddBodyClassStoreViewID
{
    /**
     * Add Body Class
     *
     * @param ResultPage $subject
     * @param ResponseInterface $response
     *
     * @return array
     */

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    public function beforeRenderResult(
        Page $resultPage,
        ResponseInterface $response
    ): array {

        $storeView = 'store-view-' . $this->storeManager->getStore()->getId();

        $pageConfig = $resultPage->getConfig();

        $pageConfig->addBodyClass($storeView);

        return [$response];
    }
}
