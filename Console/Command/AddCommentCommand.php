<?php

declare(strict_types=1);

namespace Practice\Comments\Console\Command;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Practice\Comments\Model\CommentFactory as CommentModelFactory;
use Practice\Comments\Model\ResourceModel\CommentFactory as CommentResourceFactory;

class AddCommentCommand extends Command
{
    private const string COMMENT = 'comment';
    private const string COMMENT_TITLE = 'title';
    private const string COMMENT_AUTHOR = 'author';
    private const string COMMENT_AUTHOR_EMAIL = 'email';

    public function __construct(
        private readonly LoggerInterface        $logger,
        private readonly CommentModelFactory    $commentFactory,
        private readonly CommentResourceFactory $resourceFactory,
        ?string                                 $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('comments:add');
        $this->setDescription('Add a new comment');
        $this->addOption(self::COMMENT, null, InputOption::VALUE_REQUIRED, 'Comment');
        $this->addOption(self::COMMENT_TITLE, null, InputOption::VALUE_REQUIRED, 'Comment Title');
        $this->addOption(self::COMMENT_AUTHOR, null, InputOption::VALUE_REQUIRED, 'Comment Author');
        $this->addOption(self::COMMENT_AUTHOR_EMAIL, null, InputOption::VALUE_REQUIRED, 'Author Email');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $comment    = $input->getOption(self::COMMENT) ?? null;
        $title      = $input->getOption(self::COMMENT_TITLE) ?? null;
        $author     = $input->getOption(self::COMMENT_AUTHOR) ?? null;
        $email      = $input->getOption(self::COMMENT_AUTHOR_EMAIL) ?? null;

        if (!$title || !$comment || !$email || !$author) {
            $output->writeln('<error>Missing CLI options. title, email, comment and name is required.</error>');
            return Command::FAILURE;
        }

        $model = $this->commentFactory->create();
        $model->setData([
            'comment_title'     => $title,
            'author_name'       => $author,
            'author_email'      => $email,
            'comment'           => $comment,
        ]);

        try {
            $resource = $this->resourceFactory->create();
            $resource->save($model);
            $output->writeln('<info>Added comment!</info>');
        } catch (AlreadyExistsException|Exception $exception) {
            $output->writeln('<error>Could not save the data. see logs in debug/</error>');
            $this->logger->error($exception->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
