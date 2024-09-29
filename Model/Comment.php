<?php

declare(strict_types=1);

namespace Practice\Comments\Model;

use Magento\Framework\Model\AbstractModel;

class Comment extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Comment::class);
    }
}
