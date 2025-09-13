<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requisito}}`.
 */
class m250901_000000_add_tipo_documento_to_requisito_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requisito}}', 'tipo_documento', $this->string(50)->after('programa_id'));
        
        // Insertar requisitos por defecto para cada tipo de documento
        $this->batchInsert('{{%requisito}}', 
            ['programa_id', 'tipo_documento', 'nombre', 'descripcion', 'obligatorio', 'orden'], 
            [
                [1, 'LiberacionIngles', 'Artículo en inglés aprobado', 'Artículo de investigación publicado en revista indexada en inglés', 1, 1],
                [1, 'LiberacionTesis', 'Tesis completada', 'Documento de tesis finalizado y revisado', 1, 1],
                [1, 'LiberacionTesis', 'Revisores asignados', '4 revisores asignados para evaluación', 1, 2],
                [1, 'Estancia', 'Proyecto de estancia', 'Proyecto de estancia aprobado por el comité', 1, 1],
                [1, 'AutorizacionImpresion', 'Dictamen de revisores', 'Aprobación de todos los revisores', 1, 1],
                [1, 'AutorizacionImpresion', 'Correcciones realizadas', 'Todas las correcciones solicitadas implementadas', 1, 2],
                [1, 'AutorizacionActoEscolares', 'Todos los requisitos cubiertos', 'Todos los requisitos académicos completados', 1, 1],
                [1, 'AutorizacionActoDocentes', 'Revisores asignados', '4 revisores asignados para el acto de grado', 1, 1],
                [1, 'ConstanciaDictamen', 'Aprobación de sinodales', 'Aprobación unánime de los sinodales', 1, 1],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%requisito}}', 'tipo_documento');
    }
}