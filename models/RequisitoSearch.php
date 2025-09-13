<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Requisito;

/**
 * RequisitoSearch represents the model behind the search form of `app\models\Requisito`.
 */
class RequisitoSearch extends Requisito
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'programa_id', 'obligatorio', 'orden'], 'integer'],
            [['tipo_documento', 'nombre', 'descripcion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Requisito::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'programa_id' => $this->programa_id,
            'obligatorio' => $this->obligatorio,
            'orden' => $this->orden,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'tipo_documento', $this->tipo_documento]);

        return $dataProvider;
    }
}