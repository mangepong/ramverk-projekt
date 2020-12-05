<?php

namespace mange\Question;

use mange\BonusModel\BonusActiveRecordModel;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class Question extends BonusActiveRecordModel
{
    /**
    * @var string $tableName name of the database table.
    */
    protected $tableName = "Question";

    /**
    * Columns in the table.
    *
    * @var integer $id primary key auto incremented.
    */
    public $id;
    public $userId;
    public $title;
    public $text;
    public $created;
}
