<?php

namespace System\Database\MyQuery;

use System\Database\MyPDO;

class Update extends Execute implements ConditionInterface
{
  public function __construct(string $table_name, MyPDO $PDO = null)
  {
    $this->_table = $table_name;
    $this->PDO = $PDO ?? new MyPDO();
  }

  public function __toString()
  {
    return $this->builder();
  }

  public function value(string $bind, string $value)
  {
    $this->_binder[] = array($bind, $value, true);
    return $this;
  }

  public function equal(string $bind, string $value)
  {
    $this->comparation($bind, '=', $value, false);
    return $this;
  }

  public function like(string $bind, string $value)
  {
    $this->comparation($bind, 'LIKE', $value, false);
    return $this;
  }

  public function where(string $where_condition, ?array $binder = null)
  {
    $this->_where = $where_condition;

    if ($binder != null) {
      $this->_binder = array_merge($this->_binder, $binder);
    }

    return $this;
  }

  protected function builder(): string
  {
    $where = $this->getWhere();

    $setArray = array_map(
      fn($e, $c) => $c == true ? "`$e` = :val_$e" : null,
      array_column($this->_binder, 0),
      array_column($this->_binder, 2)
    );
    $setArray   = array_filter($setArray);  // remove empety items
    $setString  = implode(', ', $setArray); // concvert to string

    $this->_query =
      "UPDATE
        `$this->_table`
      SET
        $setString
      $where";

    return $this->_query;
  }
}
