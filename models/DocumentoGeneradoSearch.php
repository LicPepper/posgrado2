<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocumentoGenerado;

/**
 * DocumentoGeneradoSearch represents the model behind the search form of `app\models\DocumentoGenerado`.
 */
class DocumentoGeneradoSearch extends DocumentoGenerado
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno_id', 'plantilla_id', 'generado_por', 'version'], 'integer'],
            [['ruta_archivo', 'hash_verificacion', 'fecha_generacion', 'estado', 'comentarios'], 'safe'],
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
    public function search($params)
{
    $query = DocumentoGenerado::find()->with(['alumno', 'plantilla']);

    $this->load($params);

    if (!$this->validate()) {
        return $dataProvider;
    }

    // Filtros
    $query->andFilterWhere([
        'id' => $this->id,
        'alumno_id' => $this->alumno_id,
        'plantilla_id' => $this->plantilla_id,
        'estado' => $this->estado,
    ]);

    if ($this->fecha_generacion) {
        $query->andFilterWhere(['DATE(fecha_generacion)' => $this->fecha_generacion]);
    }

    return new ActiveDataProvider([
        'query' => $query,
        'sort' => [
            'defaultOrder' => ['fecha_generacion' => SORT_DESC]
        ]
    ]);
}
}
