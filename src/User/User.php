<?php

namespace mange\User;

use mange\BonusModel\BonusActiveRecordModel;

/**
 * A database driven model.
 */
class User extends BonusActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $acronym;
    public $password;
    public $created;
    public $email;

    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the acronym and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $acronym  acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if acronym and password matches, else false.
     */
    public function verifyPassword($acronym, $password)
    {
        $this->find("acronym", $acronym);
        return password_verify($password, $this->password);
    }
}
