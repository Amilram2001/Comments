<?php

declare(strict_types=1);

namespace Practice\Comments\Model\ResourceModel\Comment;

use Practice\Comments\Model\Comment as CommentModel;
use Practice\Comments\Model\ResourceModel\Comment as CommentResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(CommentModel::class, CommentResourceModel::class);
    }
}
