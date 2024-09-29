<?php

declare(strict_types=1);

namespace Practice\Comments\Model\ResourceModel;

use Practice\Comments\Config\ModuleInfo;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Comment extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init(ModuleInfo::COMMENT_TABLE, ModuleInfo::COMMENT_TABLE_KEY);
        $this->_isPkAutoIncrement = true;
    }
}
