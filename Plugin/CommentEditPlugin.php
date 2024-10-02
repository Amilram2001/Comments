<?php

declare(strict_types=1);

namespace Practice\Comments\Plugin;

use Psr\Log\LoggerInterface;
use Magento\Customer\Block\Form\Edit;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

readonly class CommentEditPlugin
{
    public function __construct(
        private LoggerInterface         $logger,
        private RequestInterface        $request,
        private RedirectFactory         $redirectFactory,
        private MessageManagerInterface $messageManager,
    ) { }

    /**
     * Acts as a request validator for controller @see Edit
     */
    public function aroundExecute($subject, callable $proceed)
    {
        $id = $this->request->getParam('id');
        if (!$id || !is_numeric($id)) {
            $this->messageManager->addErrorMessage(__('Invalid request parameters.'));
            $this->logger->critical(__('Invalid request parameters. Id should be an integer; Received %1', $id));
            return $this->redirectFactory->create()->setRefererUrl();
        }
        return $proceed();
    }
}
