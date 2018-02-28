<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Material]].
 *
 * @see \app\models\Material
 */
class MaterialQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status_publisher' => 1]);
    }

    public function forCategory($id)
    {
        return $this->andWhere(['category_id' => $id]);
    }

    public function forConference($id)
    {
        return $this->andWhere(['conference_id' => $id]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Material[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Material|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
