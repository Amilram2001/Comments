<?php

declare(strict_types=1);

namespace Practice\Comments\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Practice\Comments\Config\ControllerInfo;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Practice\Comments\Api\CommentRepositoryInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Practice\Comments\Model\CommentFactory as CommentModelFactory;
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class Create implements ActionInterface
{
    public function __construct(
        private readonly PageFactory                $pageFactory,
        private readonly RedirectFactory            $redirectFactory,
        private readonly RequestInterface           $request,
        private readonly EventManagerInterface      $eventManager,
        private readonly CommentModelFactory        $commentModelFactory,
        private readonly MessageManagerInterface    $messageManager,
        private readonly CommentRepositoryInterface $commentRepository
    ) { }

    public function execute(): ResultInterface|ResponseInterface
    {
        if (!$this->request->isPost()) {
            return $this->pageFactory->create();
        }
        $name = $this->request->getParam('author_name');
        $email = $this->request->getParam('author_email');
        $commentContent = $this->request->getParam('comment');
        $title = $this->request->getParam('comment_title');
        $model = $this->commentModelFactory->create();
        $model->setData([
            'author_name' => $name,
            'author_email' => $email,
            'comment' => $commentContent,
            'comment_title' => $title,
        ]);
        if ($this->commentRepository->save($model)) {
            $this->eventManager->dispatch(ControllerInfo::EVENT_CREATE_COMMENT, ['comment' => $model]);
            $this->messageManager->addSuccessMessage('Your comment has been added.');
            $redirect = $this->redirectFactory->create();
            return $redirect->setPath(ControllerInfo::COMMENTS_CONTROLLER_LIST_URI);
        }
        $this->messageManager->addErrorMessage('Your comment could not be added.');
        return $this->redirectFactory->create()->setRefererUrl();
    }
}
