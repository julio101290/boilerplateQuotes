<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterQuotesDecimalPrecision extends Migration {

    public function up() {
        $fields = [
            'taxes' => [
                'name' => 'taxes',
                'type' => 'DECIMAL',
                'constraint' => '18,2',
                'null' => true,
            ],
            'subTotal' => [
                'name' => 'subTotal',
                'type' => 'DECIMAL',
                'constraint' => '18,2',
                'null' => true,
            ],
            'total' => [
                'name' => 'total',
                'type' => 'DECIMAL',
                'constraint' => '18,2',
                'null' => true,
            ],
            'IVARetenido' => [
                'name' => 'IVARetenido',
                'type' => 'DECIMAL',
                'constraint' => '18,4',
                'null' => false,
            ],
            'ISRRetenido' => [
                'name' => 'ISRRetenido',
                'type' => 'DECIMAL',
                'constraint' => '18,4',
                'null' => false,
            ],
        ];

        $this->forge->modifyColumn('quotes', $fields);
    }

    public function down() {
        // Revertimos los cambios al estado original (DECIMAL 18,0 si era lo esperado originalmente)
        $fields = [
            'taxes' => [
                'name' => 'taxes',
                'type' => 'DECIMAL',
                'constraint' => '18',
                'null' => true,
            ],
            'subTotal' => [
                'name' => 'subTotal',
                'type' => 'DECIMAL',
                'constraint' => '18',
                'null' => true,
            ],
            'total' => [
                'name' => 'total',
                'type' => 'DECIMAL',
                'constraint' => '18',
                'null' => true,
            ],
            'IVARetenido' => [
                'name' => 'IVARetenido',
                'type' => 'DECIMAL',
                'constraint' => '18',
                'null' => false,
            ],
            'ISRRetenido' => [
                'name' => 'ISRRetenido',
                'type' => 'DECIMAL',
                'constraint' => '18',
                'null' => false,
            ],
        ];

        $this->forge->modifyColumn('quotes', $fields);
    }
}
