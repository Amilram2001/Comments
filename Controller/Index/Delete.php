<?php

declare(strict_types=1);

namespace Practice\Comments\Controller\Index;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\RequestInterface;
use Practice\Comments\Config\ControllerInfo;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Practice\Comments\Api\CommentRepositoryInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class Delete implements HttpPostActionInterface
{
    public function __construct(
        private readonly LoggerInterface            $logger,
        private readonly RedirectFactory            $redirectFactory,
        private readonly RequestInterface           $request,
        private readonly EventManagerInterface      $eventManager,
        private readonly MessageManagerInterface    $messageManager,
        private readonly CommentRepositoryInterface $commentRepository
    ) { }

    public function execute(): ResultInterface|ResponseInterface
    {
        $id = $this->request->getParam('id');
        $redirect = $this->redirectFactory->create();
        if (!$id || !is_numeric($id)) {
            $this->logger->critical('Missing id during delete action');
            $this->messageManager->addErrorMessage("We can't delete this comment. Please try again later.");
            return $redirect->setRefererUrl();
        }
        if (!$this->commentRepository->deleteById((int)$id)) {
            $this->logger->critical('Comment with id ' . $id . 'not found');
            $this->messageManager->addErrorMessage('There was an error with the request. Please refresh the page and try again.');
            return $redirect->setRefererUrl();
        }
        $this->eventManager->dispatch(ControllerInfo::EVENT_DELETE_COMMENT, ['comment_id' => $id]);
        $this->logger->info('Comment with id ' . $id . ' was successfully deleted');
        $this->messageManager->addSuccessMessage('Successfully deleted the comment!');
        return $redirect->setRefererUrl();
    }
}
