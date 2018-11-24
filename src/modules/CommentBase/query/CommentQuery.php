<?php

namespace thienhungho\CommentManagement\modules\CommentBase\query;

/**
 * This is the ActiveQuery class for [[Comment]].
 *
 * @see Comment
 */
class CommentQuery extends \thienhungho\ActiveQuery\models\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @param $status
     *
     * @return $this
     */
    public function status($status)
    {
        if ($status != PARAMS_VALUE_ALL) {
            $this->andWhere(['status' => $status]);
        }

        return $this;
    }

    /**
     * @param $type
     *
     * @return $this
     */
    public function type($type)
    {
        if ($type != PARAMS_VALUE_ALL) {
            $this->andWhere(['type' => $type]);
        }

        return $this;
    }

    /**
     * @param $data_type
     *
     * @return $this
     */
    public function dataType($data_type)
    {
        if ($data_type === DATA_TYPE_ARRAY) {
            $this->asArray();
        }

        return $this;
    }

    /**
     * @inheritdoc
     * @return Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
