<?php

use yii\db\Migration;

class m250609_193219_add_posgrado_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
{
    $this->addColumn('alumno', 'titulo_tesis', $this->string(255)->after('telefono'));
    $this->addColumn('alumno', 'articulo_ingles', $this->string(255)->after('titulo_tesis'));
    $this->addColumn('alumno', 'fecha_egreso', $this->date()->after('articulo_ingles'));
}

public function safeDown()
{
    $this->dropColumn('alumno', 'titulo_tesis');
    $this->dropColumn('alumno', 'articulo_ingles');
    $this->dropColumn('alumno', 'fecha_egreso');
    return true;
}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250609_193219_add_posgrado_fields cannot be reverted.\n";

        return false;
    }
    */
}
