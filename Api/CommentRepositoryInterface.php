<?php

declare(strict_types=1);

namespace Practice\Comments\Api;

use Magento\Framework\DataObject;
use Practice\Comments\Api\Data\CommentInterface;

interface CommentRepositoryInterface
{
    /**
     * @return CommentInterface[]
     */
    public function getAll(): array;
    public function deleteById(int $id): bool;
    public function getById(int $id): ?DataObject;
    public function update(CommentInterface $comment): bool;
    public function getAllBy(array $criteria = []): array;
    public function save(CommentInterface $comment): bool;
}
