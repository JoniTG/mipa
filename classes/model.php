<?php
abstract class Model
{
  protected $dbh, $stmt;

  public function __construct()
  {
    $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // $this->dbh->exec("SET NAMES utf8");
    // $this->dbh->exec("SET CHARACTER SET utf8");
  }

  public function query($query)
  {
    $this->stmt = $this->dbh->prepare($query);
  }

  public function bind($param, $value, $type = null)
  {
    if(is_null($type))
    {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
          break;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  public function execute()
  {
    return $this->stmt->execute();
  }

  public function resultset()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function numRows()
  {
    $this->execute();
    return $this->stmt->rowCount();
  }
}
