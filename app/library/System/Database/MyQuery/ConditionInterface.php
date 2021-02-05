<?php

namespace System\Database\MyQuery;

interface ConditionInterface
{
  /**
   * Where statment untuk membandinkan kesamaan variable (=)
   *
   * @param string $key Key atau nama column
   * @param string $value Value atau nilai dari key atau nama column
   */
  public function equal(string $bind, string $value);

  /**
   * Where statment untuk membandinkan kemiripan variable (LIKE)
   *
   * @param string $key Key atau nama column
   * @param string $value Value atau nilai dari key atau nama column
   */
  public function like(string $bind, string $value);

  /**
   * Costume where
   * (Warning: binding must include)
   *
   * @param string $where
   */
  public function where(string $where_condition, array $binder = null);
}
