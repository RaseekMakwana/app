<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;

/**
 * PostSearch represents the model behind the search form about `app\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language_id', 'type', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description', 'caption', 'image', 'html_source', 'css_source', 'js_source', 'created_date', 'updated_date', 'status'], 'safe'],
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
        $query = Post::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'language_id' => $this->language_id,
            'type' => $this->type,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'caption', $this->caption])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'html_source', $this->html_source])
            ->andFilterWhere(['like', 'css_source', $this->css_source])
            ->andFilterWhere(['like', 'js_source', $this->js_source])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
