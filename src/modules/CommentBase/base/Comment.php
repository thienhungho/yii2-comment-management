<?php

namespace thienhungho\CommentManagement\modules\CommentBase\base;

use thienhungho\UserManagement\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property string $content
 * @property string $author_name
 * @property string $author_email
 * @property string $author_url
 * @property string $author_ip
 * @property string $status
 * @property string $type
 * @property string $obj_type
 * @property integer $obj_id
 * @property integer $parent
 * @property integer $author
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \thienhungho\CommentManagement\modules\CommentBase\User $author0
 */
class Comment extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'author0'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'author_name', 'author_email'], 'required'],
            [['content'], 'string'],
            [['obj_id', 'parent', 'author', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['author_name', 'author_email', 'author_url', 'author_ip', 'obj_type'], 'string', 'max' => 255],
            [['status', 'type'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'author_name' => Yii::t('app', 'Author Name'),
            'author_email' => Yii::t('app', 'Author Email'),
            'author_url' => Yii::t('app', 'Author Url'),
            'author_ip' => Yii::t('app', 'Author Ip'),
            'status' => Yii::t('app', 'Status'),
            'type' => Yii::t('app', 'Type'),
            'obj_type' => Yii::t('app', 'Obj Type'),
            'obj_id' => Yii::t('app', 'Obj ID'),
            'parent' => Yii::t('app', 'Parent'),
            'author' => Yii::t('app', 'Author'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }


    /**
     * @inheritdoc
     * @return \thienhungho\CommentManagement\modules\CommentBase\query\CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \thienhungho\CommentManagement\modules\CommentBase\query\CommentQuery(get_called_class());
    }
}
