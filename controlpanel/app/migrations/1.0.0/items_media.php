<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ItemsMediaMigration_100
 */
class ItemsMediaMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('items_media', array(
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
                        'sid',
                        array(
                            'type'     => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'size'     => 10,
                            'after'    => 'id'
                        )
                    ),
                    new Column(
                        'filename',
                        array(
                            'type'    => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size'    => 100,
                            'after'   => 'sid'
                        )
                    ),
                    new Column(
                        'uploaded_at',
                        array(
                            'type'  => Column::TYPE_DATETIME,
                            'size'  => 1,
                            'after' => 'filename'
                        )
                    )
                ),
                'indexes'    => array(
                    new Index('PRIMARY', array('id')),
                    new Index('sid', array('sid')),
                    new Index('filename', array('filename'))
                ),
                'references' => array(
                    new Reference(
                        'items_media_ibfk_1',
                        array(
                            'referencedSchema'  => 'malls_navi',
                            'referencedTable'   => 'items',
                            'columns'           => array('sid'),
                            'referencedColumns' => array('id')
                        )
                    )
                ),
                'options'    => array(
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'AUTO_INCREMENT'  => '140',
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
