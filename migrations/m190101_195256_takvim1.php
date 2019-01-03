<?php

use yii\db\Migration;

/**
 * Class m190101_195256_takvim1
 */
class m190101_195256_takvim1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('takvim1', [
            'tatilgunleri' => $this->date(),
            'PRIMARY KEY(tatilgunleri)',
        ]);
		$this->insert('takvim1',[
    'tatilgunleri' => '2018-12-30',
]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190101_195256_takvim1 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190101_195256_takvim1 cannot be reverted.\n";

        return false;
    }
    */
}
