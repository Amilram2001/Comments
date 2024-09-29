<?php

declare(strict_types=1);

namespace Practice\Comments\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Practice\Comments\Model\ResourceModel\Comment\CollectionFactory;

class ListCommentsCommand extends Command
{
    private const int PAGE_SIZE_DEFAULT = 10;
    private const string PAGE_SIZE = 'pageSize';

    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        ?string                            $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('comments:list');
        $this->setDescription('Show comments');
        $this->addOption(
          self::PAGE_SIZE,
          null,
          InputOption::VALUE_OPTIONAL,
          'Page size',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commentSize = $input->getOption(self::PAGE_SIZE);
        $commentSize = is_integer($commentSize) ? $commentSize : self::PAGE_SIZE_DEFAULT;
        $collection = $this->collectionFactory->create();
        $items = $collection->setPageSize($commentSize)->getItems();
        var_dump($items);
        return 0;
    }
}
