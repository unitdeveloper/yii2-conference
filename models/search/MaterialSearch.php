<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Material;

/**
 * MaterialSearch represents the model behind the search form of `app\models\Material`.
 */
class MaterialSearch extends Material
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
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
//             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'conference_id' => $this->conference_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'publisher_at' => $this->publisher_at,
            'status_publisher' => $this->status_publisher,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author])
//            ->andFilterWhere(['like', 'university', $this->university])
//            ->andFilterWhere(['like', 'udk', $this->udk])
//            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'material_name', $this->material_name]);
//            ->andFilterWhere(['like', 'ru_annotation', $this->ru_annotation])
//            ->andFilterWhere(['like', 'ua_annotation', $this->ua_annotation])
//            ->andFilterWhere(['like', 'us_annotation', $this->us_annotation])
//            ->andFilterWhere(['like', 'ru_tag', $this->ru_tag])
//            ->andFilterWhere(['like', 'ua_tag', $this->ua_tag])
//            ->andFilterWhere(['like', 'us_tag', $this->us_tag])
//            ->andFilterWhere(['like', 'word_file', $this->word_file])
//            ->andFilterWhere(['like', 'pdf_file', $this->pdf_file])
//            ->andFilterWhere(['like', 'html_file', $this->html_file]);

        return $dataProvider;
    }
}
