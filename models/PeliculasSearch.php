<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Peliculas;

/**
 * PeliculasSearch represents the model behind the search form of `app\models\Peliculas`.
 */
class PeliculasSearch extends Peliculas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_peliculas', 'duracion_min', 'actores_id_actores', 'generos_id_generos'], 'integer'],
            [['titulo', 'sinipsis', 'anio_lanzamiento', 'portada'], 'safe'],
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
        $query = Peliculas::find();

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
            'id_peliculas' => $this->id_peliculas,
            'anio_lanzamiento' => $this->anio_lanzamiento,
            'duracion_min' => $this->duracion_min,
            'actores_id_actores' => $this->actores_id_actores,
            'generos_id_generos' => $this->generos_id_generos,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'sinipsis', $this->sinipsis])
            ->andFilterWhere(['like', 'portada', $this->portada]);

        return $dataProvider;
    }
}
