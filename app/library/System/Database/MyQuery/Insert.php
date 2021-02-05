<?php

namespace System\Database\MyQuery;

use System\Database\MyPDO;

class Insert extends Execute
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

  protected function builder(): string
  {
    $arraycolumns = array_column($this->_binder, 0);
    $arrayBinds   = array_map(
      fn($e) => ":val_$e",
      array_column($this->_binder, 0)
    );
    $arraycolumns = array_filter($arraycolumns);
    $arrayBinds   = array_filter($arrayBinds);

    $stringColumn = implode(", ", $arraycolumns);
    $stringBinds = implode(", ", $arrayBinds);

    $this->_query = "INSERT INTO `$this->_table` ($stringColumn) VALUES ($stringBinds)";
    return $this->_query;
  }

}
