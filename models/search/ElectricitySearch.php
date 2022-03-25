<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Electricity;

/**
 * ElectricitySearch represents the model behind the search form of `app\models\Electricity`.
 */
class ElectricitySearch extends Electricity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'connection', 'management', 'applicant', 'status'], 'integer'],
            [['user_last', 'user_first'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
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
        $session = Yii::$app->session;

        if (!isset($params['ElectricitySearch'])) {
            if ($session->has('ElectricitySearch')){
                $params['ElectricitySearch'] = $session['ElectricitySearch'];
            }
        } else {
            $session->set('ElectricitySearch', $params['ElectricitySearch']);
        }

        if (!isset($params['sort'])) {
            if ($session->has('ElectricitySearchSort')){
                $params['sort'] = $session['ElectricitySearchSort'];
            }
        } else {
            $session->set('ElectricitySearchSort', $params['sort']);
        }

        if (isset($params['sort'])) {
            $pos = stripos($params['sort'], '-');
            if ($pos !== false) {
                $typeSort = SORT_DESC;
                $fieldSort = substr($params['sort'], 1);
            } else {
                $typeSort = SORT_ASC;
                $fieldSort = $params['sort'];
            }
        }
        else {
            $typeSort = SORT_ASC;
            $fieldSort = 'status';
        }

        $query = Electricity::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => [$fieldSort => $typeSort]],
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
        ]);

        $query->andFilterWhere(['=', 'connection', $this->connection])
            ->andFilterWhere(['=', 'management', $this->management])
            ->andFilterWhere(['=', 'applicant', $this->applicant])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['like', 'user_first', $this->user_first]);

        return $dataProvider;
    }
}
