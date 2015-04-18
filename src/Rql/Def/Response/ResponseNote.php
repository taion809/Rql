<?php
namespace Rql\Def\Response;

class ResponseNote
{
  /**
   * The stream is a changefeed stream (e.g. `r.table('test').changes()`).
   */
  const SEQUENCE_FEED = 1;
  /**
   * The stream is a point changefeed stream
   * (e.g. `r.table('test').get(0).changes()`).
   */
  const ATOM_FEED = 2;
  /**
   * The stream is an order_by_limit changefeed stream
   * (e.g. `r.table('test').order_by(index: 'id').limit(5).changes()`).
   */
  const ORDER_BY_LIMIT_FEED = 3;
  /**
   * The stream is a union of multiple changefeed types that can't be
   * collapsed to a single type
   * (e.g. `r.table('test').changes().union(r.table('test').get(0).changes())`).
   */
  const UNIONED_FEED = 4;
  /**
   * The stream is a changefeed stream and includes notes on what state
   * the changefeed stream is in (e.g. objects of the form `{state:
   * 'initializing'}`).
   */
  const INCLUDES_STATES = 5;
}
