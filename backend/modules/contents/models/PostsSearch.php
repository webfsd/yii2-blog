<?php

namespace backend\modules\contents\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Posts;
use creocoder\taggable\TaggableQueryBehavior;

/**
 * PostsSearch represents the model behind the search form about `common\models\Posts`.
 */
class PostsSearch extends Posts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'views', 'comment_count', 'sort', 'enabled_comment', 'status'], 'integer'],
            [['slug', 'author_id', 'title', 'description', 'content', 'password', 'created_at', 'updated_at'], 'safe'],
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
        $query = Posts::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('author'); // 关联查询

        // grid filtering conditions
        $query->andFilterWhere([
            'posts.id' => $this->id,
            // 'author_id' => $this->author_id,
            'views' => $this->views,
            'comment_count' => $this->comment_count,
            'sort' => $this->sort,
            'enabled_comment' => $this->enabled_comment,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'user.username', $this->author_id]);

        return $dataProvider;
    }
}
