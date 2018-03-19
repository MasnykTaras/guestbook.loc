<?php

use yii\db\Migration;

/**
 * Class m180319_124341_create_table_order
 */
class m180319_124341_create_table_order extends Migration
{
    public $table = "order";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
             'created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'homepage' => $this->string()->notNull(),
            'text' => $this->text(),             
            'user_ip' => $this->string()->notNull(),
             'user_brouser' => $this->string()->notNull(),
            'file' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable($this->table);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_124341_create_table_order cannot be reverted.\n";

        return false;
    }
    */
}
