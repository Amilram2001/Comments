<?php

declare(strict_types=1);

namespace Practice\Comments\Config;

enum ControllerInfo: string
{
    const string CURRENT_COMMENT_ID = 'current_comment_id';
    const string COMMENTS_CONTROLLER_LIST_URI = 'comments/index/index';
    const string EVENT_CREATE_COMMENT = 'practice_comments_after_create_comment';
    const string EVENT_UPDATE_COMMENT = 'practice_comments_after_update_comment';
}
