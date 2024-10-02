<?php

declare(strict_types=1);

namespace Practice\Comments\Controller\Index;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Practice\Comments\Config\ControllerInfo;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

class Edit implements HttpPostActionInterface
{
    public function __construct(
        private readonly PageFactory            $pageFactory,
        private readonly RequestInterface       $request,
        private readonly DataPersistorInterface $dataPersistor,
    ) { }

    public function execute(): ResultInterface|ResponseInterface
    {
        $id = $this->request->getParam('id');
        $this->dataPersistor->set(ControllerInfo::CURRENT_COMMENT_ID, $id);
        return $this->pageFactory->create();
    }
}
