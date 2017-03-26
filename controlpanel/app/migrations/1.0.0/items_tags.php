<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ItemsTagsMigration_100
 */
class ItemsTagsMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('items_tags', array(
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
                            'notNull'  => true,
                            'size'     => 10,
                            'after'    => 'id'
                        )
                    ),
                    new Column(
                        'tid',
                        array(
                            'type'     => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull'  => true,
                            'size'     => 10,
                            'after'    => 'sid'
                        )
                    )
                ),
                'indexes'    => array(
                    new Index('PRIMARY', array('id')),
                    new Index('sid', array('sid')),
                    new Index('tig', array('tid'))
                ),
                'references' => array(
                    new Reference(
                        'items_tags_ibfk_1',
                        array(
                            'referencedSchema'  => 'malls_navi',
                            'referencedTable'   => 'Items',
                            'columns'           => array('sid'),
                            'referencedColumns' => array('id')
                        )
                    ),
                    new Reference(
                        'items_tags_ibfk_2',
                        array(
                            'referencedSchema'  => 'malls_navi',
                            'referencedTable'   => 'tags',
                            'columns'           => array('tid'),
                            'referencedColumns' => array('id')
                        )
                    )
                ),
                'options'    => array(
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'AUTO_INCREMENT'  => '1',
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
