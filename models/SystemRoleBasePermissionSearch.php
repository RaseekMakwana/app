<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SystemRoleBasePermission;

/**
 * SystemRoleBasePermissionSearch represents the model behind the search form about `app\models\SystemRoleBasePermission`.
 */
class SystemRoleBasePermissionSearch extends SystemRoleBasePermission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'controller_id', 'action_id'], 'integer'],
            [['allow_all_actions', 'status'], 'safe'],
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
        $query = SystemRoleBasePermission::find();

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
            'role_id' => $this->role_id,
            'controller_id' => $this->controller_id,
            'action_id' => $this->action_id,
        ]);

        $query->andFilterWhere(['like', 'allow_all_actions', $this->allow_all_actions])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
