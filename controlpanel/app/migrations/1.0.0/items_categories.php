<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ItemsCategoriesMigration_100
 */
class ItemsCategoriesMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('items_categories', array(
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
                        'cid',
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
                    new Index('cid', array('cid'))
                ),
                'references' => array(
                    new Reference(
                        'items_categories_ibfk_1',
                        array(
                            'referencedSchema'  => 'malls_navi',
                            'referencedTable'   => 'items',
                            'columns'           => array('sid'),
                            'referencedColumns' => array('id')
                        )
                    ),
                    new Reference(
                        'items_categories_ibfk_2',
                        array(
                            'referencedSchema'  => 'malls_navi',
                            'referencedTable'   => 'categories',
                            'columns'           => array('cid'),
                            'referencedColumns' => array('id')
                        )
                    )
                ),
                'options'    => array(
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'AUTO_INCREMENT'  => '684',
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
