<?php

declare(strict_types=1);

namespace Practice\Comments\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;

class Index implements ActionInterface
{
    public function __construct(private readonly PageFactory $pageFactory)
    { }

    public function execute(): ResultInterface|ResponseInterface
    {
        return $this->pageFactory->create();
    }
}
