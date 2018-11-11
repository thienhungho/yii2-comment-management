<?php

namespace thienhungho\CommentManagement\modules\CommentBase;

use \thienhungho\CommentManagement\modules\CommentBase\base\Comment as BaseComment;

/**
 * This is the model class for table "comment".
 */
class Comment extends BaseComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['content', 'author_name', 'author_email'], 'required'],
            [['content'], 'string'],
            [['obj_id', 'parent', 'author', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['author_name', 'author_email', 'author_url', 'author_ip', 'obj_type'], 'string', 'max' => 255],
            [['status', 'type'], 'string', 'max' => 25],
            [['status'], 'default', 'value' => STATUS_PENDING],
            [['author_ip'], 'default', 'value' => get_current_user_ip()],
            [['author'], 'default', 'value' => get_current_user_id()],
        ]);
    }
	
}
