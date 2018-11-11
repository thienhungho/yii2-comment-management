<?php

namespace thienhungho\CommentManagement\modules\CommentManage\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use thienhungho\CommentManagement\modules\CommentBase\Comment;

/**
 * thienhungho\CommentManagement\modules\CommentManage\search\CommentSearch represents the model behind the search form about `thienhungho\CommentManagement\modules\CommentBase\Comment`.
 */
 class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'obj_id', 'parent', 'author', 'created_by', 'updated_by'], 'integer'],
            [['content', 'author_name', 'author_email', 'author_url', 'author_ip', 'status', 'type', 'obj_type', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'obj_id' => $this->obj_id,
            'parent' => $this->parent,
            'author' => $this->author,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'author_email', $this->author_email])
            ->andFilterWhere(['like', 'author_url', $this->author_url])
            ->andFilterWhere(['like', 'author_ip', $this->author_ip])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'obj_type', $this->obj_type]);

        return $dataProvider;
    }
}
