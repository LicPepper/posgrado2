<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Alumno;

/**
 * AlumnoSearch represents the model behind the search form of `app\models\Alumno`.
 */
class AlumnoSearch extends Alumno
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'programa_id', 'activo'], 'integer'],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'matricula', 'email', 'telefono', 'fecha_creacion'], 'safe'],
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
        $query = Alumno::find();

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
            'fecha_creacion' => $this->fecha_creacion,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido_paterno', $this->apellido_paterno])
            ->andFilterWhere(['like', 'apellido_materno', $this->apellido_materno])
            ->andFilterWhere(['like', 'matricula', $this->matricula])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
