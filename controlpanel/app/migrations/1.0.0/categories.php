<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class CategoriesMigration_100
 */
class CategoriesMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('categories', array(
                'columns' => array(
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
                        'parent_id',
                        array(
                            'type'     => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'size'     => 10,
                            'after'    => 'id'
                        )
                    ),
                    new Column(
                        'name',
                        array(
                            'type'    => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size'    => 150,
                            'after'   => 'parent_id'
                        )
                    ),
                    new Column(
                        'description',
                        array(
                            'type'    => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size'    => 250,
                            'after'   => 'name'
                        )
                    )
                ),
                'indexes' => array(
                    new Index('PRIMARY', array('id')),
                    new Index('parent_id', array('parent_id'))
                ),
                'options' => array(
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'AUTO_INCREMENT'  => '114',
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
