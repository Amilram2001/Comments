<?php

declare(strict_types=1);

namespace Practice\Comments\Repository;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\DataObject;
use Practice\Comments\Api\Data\CommentInterface;
use Practice\Comments\Api\CommentRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\AlreadyExistsException;
use Practice\Comments\Model\ResourceModel\CommentFactory as CommentResourceFactory;
use Practice\Comments\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;

readonly class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(
        private LoggerInterface          $logger,
        private CommentResourceFactory   $commentResourceFactory,
        private CommentCollectionFactory $commentCollectionFactory,
    ) { }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->commentCollectionFactory->create()->getItems();
    }

    public function deleteById(int $id): bool
    {
        /** @var CommentInterface $comment */
        $comment = $this->commentCollectionFactory->create()->getItemById($id);
        if (!$comment) {
            $this->logger->error(__('Comment with id "%1" could not be found.', $id));
            return false;
        }
        try {
            $this->commentResourceFactory->create()->delete($comment);
        } catch (NoSuchEntityException|Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
        return true;
    }

    public function update(CommentInterface $comment): bool
    {
        try {
            $this->commentResourceFactory->create()->save($comment);
        } catch (AlreadyExistsException|Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
        return true;
    }

    public function getById(int $id): ?DataObject
    {
        return $this->commentCollectionFactory->create()->getItemById($id);
    }

    public function getAllBy(array $criteria = []): array
    {
        $collection = $this->commentCollectionFactory->create();
        foreach ($criteria as $field => $value) {
            $collection->addFieldToFilter($field, $value);
        }
        return $collection->getItems();
    }

    public function save(CommentInterface $comment): bool
    {
        try {
            $this->commentResourceFactory->create()->save($comment);
        } catch (AlreadyExistsException|Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
        return true;
    }
}
