<?php

namespace kouosl\takvim\models;

use Yii;

/**
 * This is the model class for table "takvim".
 *
 * @property string $tatilgunleri
 */
class Takvim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'takvim1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tatilgunleri'], 'required'],
            [['tatilgunleri'], 'safe'],
            [['tatilgunleri'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tatilgunleri' => 'Tatilgunleri',
        ];
    }
}
