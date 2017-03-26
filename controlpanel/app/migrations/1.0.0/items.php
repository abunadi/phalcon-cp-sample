<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ItemsMigration_100
 */
class ItemsMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('items', array(
                'columns'    => array(
                    new Column(
                        'id',
                        array(
                            'type'          => Column::TYPE_INTEGER,
                            'unsigned'      => true,
                            'notNull'       => true,
                            'autoIncrement' => true,
                            'size'          => 10,
                            'first'         => true
                        )
                    ),
                    new Column(
                        'mid',
                        array(
                            'type'     => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull'  => true,
                            'size'     => 10,
                            'after'    => 'id'
                        )
                    ),
                    new Column(
                        'fid',
                        array(
                            'type'     => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull'  => true,
                            'size'     => 10,
                            'after'    => 'mid'
                        )
                    ),
                    new Column(
                        'zid',
                        array(
                            'type'     => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull'  => true,
                            'size'     => 10,
                            'after'    => 'fid'
                        )
                    ),
                    new Column(
                        'code',
                        array(
                            'type'    => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size'    => 30,
                            'after'   => 'zid'
                        )
                    ),
                    new Column(
                        'name',
                        array(
                            'type'    => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size'    => 250,
                            'after'   => 'code'
                        )
                    ),
                    new Column(
                        'description',
                        array(
                            'type'    => Column::TYPE_TEXT,
                            'notNull' => true,
                            'size'    => 1,
                            'after'   => 'name'
                        )
                    ),
                    new Column(
                        'operating_hours',
                        array(
                            'type'  => Column::TYPE_TEXT,
                            'size'  => 1,
                            'after' => 'description'
                        )
                    ),
                    new Column(
                        'telephone',
                        array(
                            'type'  => Column::TYPE_VARCHAR,
                            'size'  => 20,
                            'after' => 'operating_hours'
                        )
                    ),
                    new Column(
                        'map_res_x_y',
                        array(
                            'type'  => Column::TYPE_VARCHAR,
                            'size'  => 100,
                            'after' => 'telephone'
                        )
                    ),
                    new Column(
                        'last_update',
                        array(
                            'type'  => Column::TYPE_DATETIME,
                            'size'  => 1,
                            'after' => 'map_res_x_y'
                        )
                    )
                ),
                'indexes'    => array(
                    new Index('PRIMARY', array('id')),
                    new Index('mid', array('mid')),
                    new Index('fid', array('fid')),
                    new Index('zid', array('zid'))
                ),
                'references' => array(
                    new Reference(
                        'items_ibfk_1',
                        array(
                            'referencedSchema'  => 'malls_navi',
                            'referencedTable'   => 'malls',
                            'columns'           => array('mid'),
                            'referencedColumns' => array('id')
                        )
                    ),
                    new Reference(
                        'items_ibfk_2',
                        array(
                            'referencedSchema'  => 'malls_navi',
                            'referencedTable'   => 'floors',
                            'columns'           => array('fid'),
                            'referencedColumns' => array('id')
                        )
                    ),
                    new Reference(
                        'items_ibfk_3',
                        array(
                            'referencedSchema'  => 'malls_navi',
                            'referencedTable'   => 'zones',
                            'columns'           => array('zid'),
                            'referencedColumns' => array('id')
                        )
                    )
                ),
                'options'    => array(
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'AUTO_INCREMENT'  => '139',
                    'ENGINE'          => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_unicode_ci'
                ),
            )
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
