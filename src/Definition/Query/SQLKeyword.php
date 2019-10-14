<?php

namespace Src\Definition\Query;


class SQLKeyword extends Enum
{
    const select = "SELECT";
    const from = "FROM";
    const order = "ORDER BY";
    const union = "UNION";
    const count = "COUNT";
    const max = "MAX";
    const min = "MIN";
    const desc = "DESC";
    const asc = "ASC";
}