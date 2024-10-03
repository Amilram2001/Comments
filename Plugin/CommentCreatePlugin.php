<?php

declare(strict_types=1);

namespace Practice\Comments\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

readonly class CommentCreatePlugin
{
    public function __construct(
        private RedirectFactory         $redirectFactory,
        private RequestInterface        $request,
        private MessageManagerInterface $messageManager
    ) { }

    public function aroundExecute($subject, callable $proceed)
    {
        if (!$this->request->isPost()) {
            return $proceed();
        }
        $name = $this->request->getParam('author_name');
        $email = $this->request->getParam('author_email');
        $commentContent = $this->request->getParam('comment');
        $title = $this->request->getParam('comment_title');

        if (empty($name) || empty($email) || empty($commentContent) || empty($title)) {
            $this->messageManager->addErrorMessage('Missing parameters');
            return $this->redirectFactory->create()->setRefererUrl();
        }
        return $proceed();
    }
}
