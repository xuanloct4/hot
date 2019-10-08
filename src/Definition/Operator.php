<?php

namespace Src\Definition;


class Operator extends Enum
{
    const equal = "=";
    const not_equal = "<>";
    const greater_than = ">";
    const smaller_than = "<";
    const greater_than_or_equal = ">=";
    const smaller_than_or_equal = "<=";
    const and_ = "AND";
    const or_ = "AND";
    const in = "IN";
    const not_in = "NOT IN";
    const between = "BETWEEN";
    const is_null = "IS NULL";
    const like = "LIKE";
    const tuple = "(%)";
    const all = "*";
}