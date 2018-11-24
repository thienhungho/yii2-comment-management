<?php
/**
 * @param $obj_type
 *
 * @return string
 */
function get_comment_type_from_obj_type($obj_type)
{
    return $obj_type . '-comment';
}

/**
 * @param $type
 * @param $obj_type
 * @param $obj_id
 * @param string $status
 *
 * @return int|string
 */
function count_all_comment_of_obj($type, $obj_type, $obj_id, $status = 'public')
{
    return \thienhungho\CommentManagement\modules\CommentBase\Comment::find()
        ->where(['status' => $status])
        ->andWhere(['type' => $type])
        ->andWhere(['obj_type' => $obj_type])
        ->andWhere(['obj_id' => $obj_id])
        ->count();
}

/**
 * @param $type
 * @param $obj_type
 * @param $obj_id
 * @param string $status
 * @param int $limit
 * @param string $data_type
 *
 * @return array|\thienhungho\CommentManagement\models\Comment[]|\cmsbase\modules\PostBase\query\Comment[]
 */
function get_all_comment_of_obj($type, $obj_type, $obj_id, $status = STATUS_PUBLIC, $limit = -1, $data_type = DATA_TYPE_ARRAY)
{
    return \thienhungho\CommentManagement\modules\CommentBase\Comment::find()
        ->where(['status' => $status])
        ->andWhere(['type' => $type])
        ->andWhere(['obj_type' => $obj_type])
        ->andWhere(['obj_id' => $obj_id])
        ->andWhere(['parent' => 0])
        ->limit($limit)
        ->dataType($data_type)
        ->all();
}

/**
 * @param $type
 * @param $obj_type
 * @param $obj_id
 * @param string $status
 *
 * @return \thienhungho\CommentManagement\models\CommentQuery
 */
function query_all_comment($type, $obj_type, $obj_id, $status = STATUS_PUBLIC)
{
    return \thienhungho\CommentManagement\modules\CommentBase\Comment::find()
        ->where(['obj_type' => $obj_type])
        ->andWhere(['type' => $type])
        ->andWhere(['obj_id' => $obj_id])
        ->andWhere(['type' => $obj_type . '-comment'])
        ->andWhere(['status' => $status])
        ->andWhere(['parent' => 0]);
}