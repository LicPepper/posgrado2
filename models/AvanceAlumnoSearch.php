<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AvanceAlumno;

/**
 * AvanceAlumnoSearch represents the model behind the search form of `app\models\AvanceAlumno`.
 */
class AvanceAlumnoSearch extends AvanceAlumno
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno_id', 'requisito_id', 'completado', 'validado_por'], 'integer'],
            [['fecha_completado', 'evidencia', 'comentarios'], 'safe'],
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
        $query = AvanceAlumno::find();

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
            'alumno_id' => $this->alumno_id,
            'requisito_id' => $this->requisito_id,
            'completado' => $this->completado,
            'fecha_completado' => $this->fecha_completado,
            'validado_por' => $this->validado_por,
        ]);

        $query->andFilterWhere(['like', 'evidencia', $this->evidencia])
            ->andFilterWhere(['like', 'comentarios', $this->comentarios]);

        return $dataProvider;
    }
}
