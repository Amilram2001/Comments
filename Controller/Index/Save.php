<?php

declare(strict_types=1);

namespace Practice\Comments\Controller\Index;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Practice\Comments\Config\ControllerInfo;
use Practice\Comments\Api\Data\CommentInterface;
use Magento\Framework\Controller\ResultInterface;
use Practice\Comments\Api\CommentRepositoryInterface;
use Magento\Framework\Message\Manager as MessageManager;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Save implements HttpPostActionInterface
{
    public function __construct(
        private readonly MessageManager             $messageManager,
        private readonly LoggerInterface            $logger,
        private readonly RedirectFactory            $redirectFactory,
        private readonly RequestInterface           $request,
        private readonly CommentRepositoryInterface $commentRepository
    ) { }

    public function execute(): ResponseInterface|ResultInterface
    {
        $id             = $this->request->getParam('comment_id');
        $name           = $this->request->getParam('author_name');
        $email          = $this->request->getParam('author_email');
        $title          = $this->request->getParam('comment_title');
        $commentContent = $this->request->getParam('comment');

        /** @var CommentInterface $comment */
        $id = (int)$id;
        $comment = $this->commentRepository->getById($id);
        if (!$comment) {
            $this->messageManager->addErrorMessage(__('Comment with id %1 not found.', $id));
            $this->logger->debug(__('Comment with id %1 not found.', $id));
            return $this->redirectFactory->create()->setPath(ControllerInfo::COMMENTS_CONTROLLER_LIST_URI);
        }

        $comment->setAuthorName($name);
        $comment->setAuthorEmail($email);
        $comment->setCommentTitle($title);
        $comment->setComment($commentContent);

        if (!$this->commentRepository->save($comment)) {
            $errorMessage = __('Comment could not be saved. Please, try again.');
            $this->messageManager->addErrorMessage($errorMessage);
            $this->logger->debug($errorMessage);
            return $this->redirectFactory->create()->setRefererUrl();
        }
        $this->messageManager->addSuccessMessage(__('Comment has been saved.'));
        return $this->redirectFactory->create()->setPath(ControllerInfo::COMMENTS_CONTROLLER_LIST_URI);
    }
}
