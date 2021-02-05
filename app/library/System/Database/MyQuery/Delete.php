<?php

namespace System\Database\MyQuery;

use System\Database\MyPDO;

class Delete extends Execute implements ConditionInterface
{
  public function __construct(string $table_name, MyPDO $PDO = null)
  {
    $this->_table = $table_name;
    $this->PDO    = $PDO ?? new MyPDO();
  }

  public function __toString()
  {
    return $this->builder();
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

    $this->_query = "DELETE FROM `$this->_table` $where";

    return $this->_query;
  }

}
