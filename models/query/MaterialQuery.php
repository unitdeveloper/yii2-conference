<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Material]].
 *
 * @see \app\models\Material
 */
class MaterialQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status_publisher' => 1]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function forCategory($id)
    {
        return $this->andWhere(['category_id' => $id]);
    }

    /**
     * @param $id
     * @return $this
     */
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
