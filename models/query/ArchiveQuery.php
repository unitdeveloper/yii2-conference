<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Archive]].
 *
 * @see \app\models\Archive
 */
class ArchiveQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['active' => 1]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Archive[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Archive|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
