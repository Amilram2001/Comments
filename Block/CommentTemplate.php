<?php

declare(strict_types=1);

namespace Practice\Comments\Block;

use Magento\Framework\View\Element\Template;
use Practice\Comments\Api\CommentRepositoryInterface;
use Practice\Comments\Api\Data\CommentInterface;

class CommentTemplate extends Template
{
    public function __construct(
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
}
