<?php

declare(strict_types=1);

namespace Practice\Comments\Plugin;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\RequestInterface;
use Practice\Comments\Config\ControllerInfo;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

readonly class CommentSavePlugin
{
    public function __construct(
        private RedirectFactory $redirectFactory,
        private LoggerInterface  $logger,
        private RequestInterface $request,
        private MessageManagerInterface $messageManager
    ) { }

    public function aroundExecute($subject, callable $proceed)
    {
        $id = $this->request->getParam('comment_id');
        $name = $this->request->getParam('author_name');
        $email = $this->request->getParam('author_email');
        $commentContent = $this->request->getParam('comment');
        $title = $this->request->getParam('comment_title');

        if (!$id || !is_numeric($id)) {
            $errorMessage = __('Invalid ID. Expecting an integer. Received %1', $id);
            $this->messageManager->addErrorMessage($errorMessage);
            $this->logger->debug($errorMessage);
            return $this->redirectFactory->create()->setPath(ControllerInfo::COMMENTS_CONTROLLER_LIST_URI);
        }
        if (empty($commentContent) || empty($title) || empty($email) || empty($name)) {
            $errorMessage = __('Invalid comment content, title, email, name or all');
            $this->messageManager->addErrorMessage($errorMessage);
            $this->logger->debug($errorMessage);
            return $this->redirectFactory->create()->setPath(ControllerInfo::COMMENTS_CONTROLLER_LIST_URI);
        }
        return $proceed();
    }
}
