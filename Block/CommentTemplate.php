<?php

declare(strict_types=1);

namespace Practice\Comments\Block;

use Magento\Framework\DataObject;
use Practice\Comments\Config\ControllerInfo;
use Magento\Framework\View\Element\Template;
use Practice\Comments\Api\Data\CommentInterface;
use Practice\Comments\Api\CommentRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

class CommentTemplate extends Template
{
    public function __construct(
        private readonly DataPersistorInterface     $dataPersistor,
        private readonly CommentRepositoryInterface $commentRepository,
        Template\Context                            $context,
        array                                       $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return CommentInterface[]
     */
    public function getComments(): array
    {
        return $this->commentRepository->getAll();
    }

    public function getCurrentComment(): ?DataObject
    {
        $commentId = (int)$this->dataPersistor->get(ControllerInfo::CURRENT_COMMENT_ID);
        return $this->commentRepository->getById($commentId);
    }
}
