<?php

namespace mange\Question;

use mange\BonusModel\BonusActiveRecordModel;

/**
 * A database driven model.
 */
class Comment extends BonusActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comment";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $userId;
    public $text;
    public $questionid;
    public $answerid;
}
