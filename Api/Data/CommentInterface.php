<?php

declare(strict_types=1);

namespace Practice\Comments\Api\Data;

use DateTimeImmutable;

interface CommentInterface
{
    public const string COMMENT_ID = 'comment_id';
    public const string AUTHOR_NAME = 'author_name';
    public const string AUTHOR_EMAIL = 'author_email';
    public const string COMMENT = 'comment';
    public const string COMMENT_TITLE = 'comment_title';
    public const string CREATED_AT = 'created_at';
    public const string UPDATED_AT = 'updated_at';

    public function getCommentId(): int;

    public function setCommentId(int $id): void;

    public function getAuthorName(): string;

    public function setAuthorName(string $name): void;

    public function getAuthorEmail(): string;

    public function setAuthorEmail(string $email): void;

    public function getComment(): string;

    public function setComment(string $comment): void;

    public function getCommentTitle(): string;

    public function setCommentTitle(string $title): void;

    public function getCreatedAt(): DateTimeImmutable;

    public function getUpdatedAt(): DateTimeImmutable;
}
