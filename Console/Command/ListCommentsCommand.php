<?php

declare(strict_types=1);

namespace Practice\Comments\Console\Command;

use Magento\Framework\Phrase;
use Symfony\Component\Console\Command\Command;
use Practice\Comments\Api\Data\CommentInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Practice\Comments\Api\CommentRepositoryInterface;

class ListCommentsCommand extends Command
{

    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository,
        ?string                                     $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('comments:list');
        $this->setDescription('Show comments');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $comments = $this->commentRepository->getAll();
        foreach ($comments as $comment) {
            $output->writeln('<info>' . $this->getFormattedComments($comment) . '</info>');
        }
        return Command::SUCCESS;
    }

    /**
     * @param CommentInterface $comment
     * @return Phrase
     */
    private function getFormattedComments(CommentInterface $comment): string
    {
        $originalComment = $comment->getComment();
        $name = $comment->getAuthorName();
        $title = $comment->getCommentTitle();
        $createdAt = $comment->getCreatedAt();
        $truncated =  strlen($originalComment) > 15 ? substr($originalComment, 0, 15) . '...' : $originalComment;
        return sprintf("%s: '%s' commented '%s' with title '%s'", $createdAt->format('Y D, d M Y H:i:s'), $name, $truncated, $title);
    }
}
