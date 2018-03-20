<?php

/** @var SearchForm $searchModel */

namespace app\models\search;

use app\models\form\SearchForm;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Material;

/**
 * MaterialFrontSearch represents the model behind the search form of `app\models\Material`.
 */
class MaterialFrontSearch extends Material
{

    public $q;
    public $type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q'], 'string', 'min' => 2, 'max' => 255],
            [['type'], 'string', 'min' => 1, 'max' => 10],
            [['created_at', 'updated_at', 'publisher_at',], 'date', 'format' => 'php:Y-m-d'],
            [['id', 'category_id', 'participant_id', 'conference_id', 'status_publisher'], 'integer'],
            [['udk', 'author'], 'string'],
            [['material_html', 'top_tag', 'top_anotation', 'university', 'email', 'material_name', 'ru_annotation', 'ua_annotation', 'us_annotation', 'ru_tag', 'ua_tag', 'us_tag', 'word_file', 'pdf_file', 'html_file'], 'safe'],
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
     * @param null $searchModel
     * @return ActiveDataProvider
     */
    public function search($params, $searchModel = null)
    {
        $this->q = isset($searchModel->q) ? $searchModel->q : '';
        $this->type = isset($searchModel->type) ? $searchModel->type : '';

        $query = Material::find()->joinWith(['category'])->joinWith(['conference']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
                'attributes' => [
                    'id',
                    'material_name',
                    'author',
                    'category_id' => [
                        'asc' => ['{{%category}}.name' => SORT_ASC],
                        'desc' => ['{{%category}}.name' => SORT_DESC],
                    ],
                    'conference_id' => [
                        'asc' => ['{{%conference}}.name' => SORT_ASC],
                        'desc' => ['{{%conference}}.name' => SORT_DESC],
                    ],
                    'created_at',
                    'publisher_at',
                    'status_publisher',
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        if (!$searchModel) {
            // grid filtering conditions
            $query->andFilterWhere([
                'id' => $this->id,
                'category_id' => $this->category_id,
                'conference_id' => $this->conference_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'publisher_at' => $this->publisher_at,
                'status_publisher' => 1,
            ]);

            $query->andFilterWhere(['like', 'author', $this->author])
                ->andFilterWhere(['like', 'material_name', $this->material_name]);

        } else {
            $query->where(['like', 'udk', $searchModel->q])
                ->orWhere(['like', 'author', $searchModel->q])
                ->orWhere(['like', 'university', $searchModel->q])
                ->orWhere(['like', 'email', $searchModel->q])
                ->orWhere(['like', 'material_name', $searchModel->q])
                ->orWhere(['like', 'top_anotation', $searchModel->q])
                ->orWhere(['like', 'second_annotation', $searchModel->q])
                ->orWhere(['like', 'last_annotation', $searchModel->q])
                ->orWhere(['like', 'top_tag', $searchModel->q])
                ->orWhere(['like', 'second_tag', $searchModel->q])
                ->orWhere(['like', 'last_tag', $searchModel->q]);

        }
        return $dataProvider;
    }
}
