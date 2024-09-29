<?php

declare(strict_types=1);

namespace Practice\Comments\Controller\Index;

use Magento\Framework\App\Request\DataPersistorInterface;
use Practice\Comments\Config\ControllerInfo;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\Manager as MessageManager;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Edit implements HttpPostActionInterface
{
    public function __construct(
        private readonly PageFactory            $pageFactory,
        private readonly MessageManager         $manager,
        private readonly LoggerInterface        $logger,
        private readonly RedirectFactory        $redirectFactory,
        private readonly RequestInterface       $request,
        private readonly DataPersistorInterface $dataPersistor,
    ) { }

    public function execute(): ResultInterface|ResponseInterface
    {
        $id = $this->request->getParam('id') ?? '';
        if (!$id || !is_numeric($id)) {
            $this->manager->addErrorMessage(__('Invalid request parameters.'));
            $this->logger->critical(__('Invalid request parameters. Id should be an integer; Received %1', $id));
            return $this->redirectFactory->create()->setRefererUrl();
        }
        $this->dataPersistor->set(ControllerInfo::CURRENT_COMMENT_ID, $id);
        return $this->pageFactory->create();
    }
}
