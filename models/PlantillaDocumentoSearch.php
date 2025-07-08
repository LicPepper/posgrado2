<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlantillaDocumento;

/**
 * PlantillaDocumentoSearch represents the model behind the search form of `app\models\PlantillaDocumento`.
 */
class PlantillaDocumentoSearch extends PlantillaDocumento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'programa_id', 'activo'], 'integer'],
            [['nombre', 'tipo', 'contenido', 'campos_dinamicos'], 'safe'],
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
        $query = PlantillaDocumento::find();

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
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'contenido', $this->contenido])
            ->andFilterWhere(['like', 'campos_dinamicos', $this->campos_dinamicos]);

        return $dataProvider;
    }
}
