<?php
namespace Rql\Def\Query;

class QueryType
{
  const START = 1;
  const R_CONTINUE = 2;
  /**
   * (see [Response]).
   */
  const STOP = 3;
  const NOREPLY_WAIT = 4;
}
