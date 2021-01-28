<?php

namespace System\Database;

use PhpParser\Node\Expr\Cast\Array_;

/**
 * Query Builder untuk mempermudah pembuatan/penyusunan query,
 * penyusunan query menggunkan chain-function,
 * sehingga query lebih mudah dibaca/di-maintance
 *
 * TODO: join table support
 *
 * @return String String query yang disusun seblumnya
 */
class MyQuery
{
  /** @var MyPDO PDO property */
  protected $PDO;
  /** @var string Operator used (SELECT|INSERT|UPDATE) */
  protected $_operator = 'SELECT';
  /** @var string Table Name */
  protected $_table = null;
  /** @var array Columns name */
  protected $_column = array('*');
  /** @var array Binder for PDO bind */
  protected $_binder = array();  // array(['key', 'val'])
  /** @var int Limit start from */
  protected $_limit_start = 0;
  /** @var int Limit end to */
  protected $_limit_end = 0;
  /** @var int Sort result ASC|DESC */
  protected $_sort_order = '';
  const ORDER_ASC = 0;
  const ORDER_DESC = 1;


  // final where statmnet
  protected $_where = null;

  // multy filter with strict mode
  protected $_group_filters = array();
  // single filter and single strict mode
  protected $_filters = array();
  protected $_strict_mode = true;

  // setter
  /**
   * @param MyPDO|null $PDO instant
   */
  public function __construct(MyPDO $PDO = null)
  {
    $this->PDO = $PDO ?? new MyPDO();
  }

  /**
   * Merubah nama data base (optional)
   * @param string $dbs_name Nama data base
   */
  public function __invoke(string $dbs_name)
  {
    $this->PDO = null; // unset all database
    $this->PDO = new MyPDO($dbs_name);
    return $this;
  }

  /**
   * reset all property
   */
  public function reset()
  {
    $this->_operator      = 'select';
    $this->_table         = null;
    $this->_column        = array('*');
    $this->_binder        = array();
    $this->_limit_start   = 0;
    $this->_limit_end     = 0;
    $this->_where         = null;
    $this->_group_filters = array();
    $this->_filters       = array();
    $this->_strict_mode   = true;

    return $this;
  }

  public function distroy()
  {
    $this->_binder = Array();
    return $this;
  }

  /**
   * Set data start for feact all data
   * @param int $val limit start default is 0
   */
  public function limitStart(int $val)
  {
    $this->_limit_start = $val;
    return $this;
  }

  /**
   * Set data end for feact all data
   * zero value meaning no data show
   * @param int $val limit start default
   */
  public function limitEnd(int $val)
  {
    $this->_limit_end = $val;
    return $this;
  }

  /**
   * Set sort column and order
   * column name must register
   */
  public function order(string $column_name, int $order_using = MyQuery::ORDER_ASC)
  {
    $order = $order_using == 0 ? 'ASC' : 'DESC';
    $this->_sort_order = "ORDER BY `$column_name` $order";
    return $this;
  }

  /**
   * Setter strict mode
   *
   * True = operator using AND,
   * False = operator using OR
   * @param bool $value True where statment operation using AND
   */
  public function strictMode(bool $value)
  {
    $this->_strict_mode = $value;
    return $this;
  }

  /**
   * Memilih **Select** untuk metode query yang akan di panggil
   *
   * @param string $teble_name Table name
   */
  public function select(string $teble_name)
  {
    $this->_operator = 'SELECT';
    $this->_table    = $teble_name;
    return $this;
  }

  /**
   * Memilih **Insert** untuk metode query yang akan di panggil
   *
   * @param string $table_name Table name
   */
  public function insert(string $table_name)
  {
    $this->_operator = 'INSERT';
    $this->_table    = $table_name;
    return $this;
  }

  /**
   * Memilih **update** untuk metode query yang akan di panggil
   *
   * @param string $table_name Table name
   */
  public function update(string $table_name)
  {
    $this->_operator = 'UPDATE';
    $this->_table    = $table_name;
    return $this;
  }

  /**
   * Memilih **delete** untuk metode query yang akan di panggil
   *
   * @param string $table_name Table name
   */
  public function delete(string $table_name)
  {
    $this->_operator = "DELETE";
    $this->_table    = $table_name;
    return $this;
  }

  /**
   * Memilih colunm mana saja yang akan dipakai
   *
   * @param array $column Column name list
  */
  public function column(array $column = array('*'))
  {
    $this->_column = $column;
    return $this;
  }

  /**
   * Menambahkan/memasukan data kedalam database
   * (binding database)
   *
   * @param string $bind key atau nama column
   * @param string $value value atau nilai dari key atau nama column
   */
  public function value(string $bind, string $value)
  {
    $this->_binder[] = array($bind, $value, true);
    return $this;
  }

  /**
   * Where statment setter,
   * menambahakan syarat pada query builder
   *
   * @param string $key Key atau nama column
   * @param string $comparation tanda hubung yang akan digunakan (AND|OR|>|<|=|LIKE)
   * @param string $value Value atau nilai dari key atau nama column
   */
  public function comparation(string $key, string $comparation, string $val)
  {
    $this->_binder[] = array($key, $val);
    $this->_filters[$key] = array (
      'value' => $val,
      'comparation' => $comparation
    );
    return $this;
  }


  // short hand comparation

  /**
   * Where statmnet untuk membandinkan kesamaan variable (=)
   *
   * @param string $key Key atau nama column
   * @param string $value Value atau nilai dari key atau nama column
   */
  public function equal(string $key, string $val)
  {
    $this->_binder[] = array($key, $val);
    $this->_filters[$key] = array (
      'value' => $val,
      'comparation' => '='
    );
    return $this;
  }

  /**
   * Where statmnet untuk membandinkan kemiripan variable (LIKE)
   *
   * @param string $key Key atau nama column
   * @param string $value Value atau nilai dari key atau nama column
   */
  public function like(string $key, string $val)
  {
    $this->_binder[] = array($key, $val);
    $this->_filters[$key] = array (
      'value' => $val,
      'comparation' => 'LIKE'
    );
    return $this;
  }

  /**
   * Costume where
   * (Warning: binding must include)
   *
   * @param string $where
   */
  public function where(string $where, array $binder = null)
  {
    $this->_where = $where;

    if ($binder != null) {
      $this->_binder = array_merge($this->_binder, $binder);
    }

    return $this;
  }

  /**
   * Mendapatkan query data base,
   * sebelum binding
   */
  public function __toString()
  {
    if ($this->_operator == 'INSERT') {
      return $this->creating();
    } elseif ($this->_operator == 'SELECT') {
      return $this->reading();
    } elseif ($this->_operator == 'UPDATE') {
      return $this->updating();
    } elseif ($this->_operator == 'DELETE') {
      return $this->deleting();
    }
    return '';
  }

  // shorthand to PDO

  /**
   * Short hand mengambil data tunggal dari query
   */
  public function single(): array
  {
    // excute olny run for SELECT
    if ($this->_operator != 'SELECT') {
      return $this;
    }
    if ($this->_table == null) {
      return array();
    }

    $this->PDO->query($this);
    foreach ($this->_binder as $bind) {
      $bindForValue = $bind[2] ?? false;

      if ($bindForValue == false) {
        $this->PDO->bind($bind[0], $bind[1]);
      }
    }
    $result = $this->PDO->single();
    return $result == false ? array() : $result;
  }

  /**
   * Short hand mengambil beberapa data dari query
   */
  public function all(): array
  {
    // excute olny run for SELECT
    if ($this->_operator != 'SELECT') {
      return $this;
    }

    if ($this->_table == null) {
      return array();
    }

    $this->PDO->query($this);
    foreach ($this->_binder as $bind) {
      $bindForValue = $bind[2] ?? false;

      if ($bindForValue == false) {
        $this->PDO->bind($bind[0], $bind[1]);
      }
    }
    return $this->PDO->resultset();
  }

  /**
   * Short hand to excute query
   * work only in SELECT|DELETE
   */
  public function execute()
  {
    // excute olny run for INSERT|UPDATE|DELETE
    if ($this->_operator == 'SELECT') {
      return $this;
    }

    // excute only run if VALUE for UPDATE|INSERT not empety
    if (($this->_operator == 'INSERT'
    || $this->_operator == 'UPDATE')
    && empty(array_column($this->_binder, 2))) {
      return $this;
    }

    $this->PDO->query($this);

    foreach ($this->_binder as $bind) {
      $bindForUpdate = $bind[2] ?? false;

      if ($bindForUpdate != false && $this->_operator == 'INSERT') {
        $bindForUpdate = $bindForUpdate == true ? "val_$bind[0]" : $bind[0];
        $this->PDO->bind($bindForUpdate, $bind[1]);
      } elseif ($this->_operator == 'UPDATE' || $this->_operator == 'DELETE') {
        $bindForUpdate = $bindForUpdate == true ? "val_$bind[0]" : $bind[0];
        $this->PDO->bind($bindForUpdate, $bind[1]);
      }
    }
    $this->PDO->execute();
    return $this;
  }

  // private function

  // crud function

  /**
   * Query builder for INSERT database
   * @return string Query for INSERT
   */
  private function creating(): string
  {
    $arraycolumns = array_map(
      fn($e, $c) => $c == true ? "`$e`" : null,
      array_column($this->_binder, 0),
      array_column($this->_binder, 2)
    );
    $arrayBinds   = array_map(
      fn($e, $c) => $c == true ? ":val_$e" : null,
      array_column($this->_binder, 0),
      array_column($this->_binder, 2)
    );
    $arraycolumns = array_filter($arraycolumns);
    $arrayBinds   = array_filter($arrayBinds);

    $stringColumn = implode(", ", $arraycolumns);
    $stringBinds = implode(", ", $arrayBinds);

    return "INSERT INTO `$this->_table` ($stringColumn) VALUES ($stringBinds)";
  }

  /**
   * Query builder for SELECT database
   * @return string Query for SELECT
   */
  private function reading(): string
  {
    $column = implode(', ', $this->_column);
    $where = $this->getWhere();
    $limit = $this->_limit_start < 0 ? "LIMIT $this->_limit_end" : "LIMIT $this->_limit_start, $this->_limit_end";
    $limit = $this->_limit_end < 1 ? '' : $limit;

    return "SELECT $column FROM `$this->_table` $where $this->_sort_order $limit";
  }

  /**
   * Query builder for UPDATE database
   * @return string Query for UPDATE
   */
  private function updating(): string
  {
    $where = $this->getWhere();

    $setArray = array_map(
      fn($e, $c) => $c == true ? "`$e` = :val_$e" : null,
      array_column($this->_binder, 0),
      array_column($this->_binder, 2)
    );
    $setArray = array_filter($setArray);

    $setString = implode(', ', $setArray);

    return "UPDATE `$this->_table` SET $setString $where";
  }

  /**
   * Query builder for DELETE database
   * @return string Query for DELETE
   */
  public function deleting(): string
  {
    $where = $this->getWhere();

    return "DELETE FROM `$this->_table` $where";
  }

  // query builder
  protected function mergeFilters(): array
  {
    $new_group_filters = $this->_group_filters;
    if (! empty($this->_filters)) {
      $new_group_filters[] = array (
        'filters' => $this->_filters,
        'strict'  => $this->_strict_mode
      );
    }
    return $new_group_filters;
  }

  protected function splitGrupsFilters(array $group_filters): string
  {
    $whereStatment = array();
    foreach ($group_filters as $filters) {
      $single = $this->splitFilters($filters);
      $whereStatment[] = "( $single )";
    }
    return implode(' AND ', $whereStatment);
  }

  protected function splitFilters(array $filters): string
  {
    $query = array();
    foreach ($filters['filters'] as $fieldName => $fieldValue) {
      $value        = $fieldValue['value'];
      $comparation  = $fieldValue['comparation'];
      if ($value != null || $value != '') {
        $query[] = "($fieldName $comparation :$fieldName)";
      }
    }

    $clear_query = array_filter($query);
    return $filters['strict'] ? implode(' AND ',$clear_query) : implode(' OR ', $clear_query);
  }

  // helper

  /**
   * Get table info of table
   * @param string $dbs_name Databe name
   * @param string $table_name Table name
   * @return array table info include column name, type, ect
   */
  public function getColumn(string $dbs_name, string $table_name): array
  {
    $this->PDO->query(
      "SELECT
        *
      FROM
        INFORMATION_SCHEMA.COLUMNS
      WHERE
        TABLE_SCHEMA = :dbs AND TABLE_NAME = :table"
    );
    $this->PDO->bind(':table', $table_name);
    $this->PDO->bind(':dbs', $dbs_name);
    return $this->PDO->resultset() ?? array();
  }

  /**
   * Get where statment baseon binding set before
   * @return string Where statment from binder
   */
  private function getWhere(): string
  {
    $merging = $this->mergeFilters();
    $where = $this->splitGrupsFilters($merging);

    if ($where != '' && $this->_where !='') {
      $costumeWhere = $this->_strict_mode ? " AND $this->_where" : " OR $this->_where";
      return "WHERE $where $costumeWhere";
    } elseif ($where == '' && $this->_where !='') {
      $costumeWhere = $this->_strict_mode ? " $this->_where" : " $this->_where";
      return "WHERE $costumeWhere";
    } elseif ($where != '') {
      return "WHERE $where";
    }
    return $where;
  }
}
