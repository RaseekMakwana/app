<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserRoles;

/**
 * UserRolesSearch represents the model behind the search form about `app\models\UserRoles`.
 */
class UserRolesSearch extends UserRoles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['user_role', 'created_date', 'updated_date', 'status'], 'safe'],
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
        $req_get_sort = Yii::$app->request->get('sort');
        if(empty($req_get_sort)) {
            $query = UserRoles::find()->orderBy(['id' => SORT_ASC]);
        } else {
            $query = UserRoles::find();
        }
        //#$query = UserRoles::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => ADMIN_PAGE_LIMIT),
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
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'user_role', $this->user_role])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
