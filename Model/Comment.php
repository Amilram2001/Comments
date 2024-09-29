<?php

declare(strict_types=1);

namespace Practice\Comments\Model;

use DateTimeImmutable;
use Magento\Framework\Registry;
use DateMalformedStringException;
use Magento\Framework\Model\Context;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Model\AbstractModel;
use Practice\Comments\Api\Data\CommentInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\AbstractResource;

class Comment extends AbstractModel implements CommentInterface
{
    public function __construct(
        Context                   $context,
        Registry                  $registry,
        private readonly DateTime $datetime,
        AbstractResource          $resource = null,
        AbstractDb                $resourceCollection = null,
        array                     $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct(): void
    {
        $this->_init(ResourceModel\Comment::class);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function beforeSave(): Comment|static
    {
        parent::beforeSave();
        if ($this->isObjectNew() && !$this->getCreatedAt()) {
            $this->setData(self::CREATED_AT , $this->datetime->formatDate(true));
        }
        $this->setData(self::UPDATED_AT, $this->datetime->formatDate(true));
        return $this;
    }

    public function getAuthorName(): string
    {
        return $this->getData(self::AUTHOR_NAME);
    }

    public function setAuthorName(string $name): void
    {
        $this->setData(self::AUTHOR_NAME, $name);
    }

    public function getAuthorEmail(): string
    {
        return $this->getData(self::AUTHOR_EMAIL);
    }

    public function setAuthorEmail(string $email): void
    {
        $this->setData(self::AUTHOR_EMAIL, $email);
    }

    public function getComment(): string
    {
        return $this->getData(self::COMMENT);
    }

    public function setComment(string $comment): void
    {
        $this->setData(self::COMMENT, $comment);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        $dateTime = $this->getData(self::CREATED_AT);
        return $dateTime instanceof DateTimeImmutable ? $dateTime : new DateTimeImmutable($dateTime);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        $dateTime = $this->getData(self::UPDATED_AT);
        return $dateTime instanceof DateTimeImmutable ? $dateTime : new DateTimeImmutable($dateTime);
    }

    public function getCommentId(): int
    {
        return (int)$this->getData(self::COMMENT_ID);
    }

    public function setCommentId(int $id): void
    {
        $this->setData(self::COMMENT_ID, $id);
    }

    public function getCommentTitle(): string
    {
        return $this->getData(self::COMMENT_TITLE);
    }

    public function setCommentTitle(string $title): void
    {
        $this->setData(self::COMMENT_TITLE, $title);
    }
}
