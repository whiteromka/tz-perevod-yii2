<?php

use yii\db\Migration;

/**
 * Миграция создания таблицы переводчиков
 */
class m260326_200138_create_translator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translator}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'last_name' => $this->string(),
            'status' => $this->string()->notNull()->defaultValue('active'),
            'email' => $this->string(),
            'price' => $this->integer()->notNull(),
            'works_mode' => $this->string()->notNull()->defaultValue('weekdays'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%translator}}');
    }
}
