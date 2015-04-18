<?php
namespace Rql\Def\Term;

class TermType
{
  const DATUM = 1;
  const MAKE_ARRAY = 2;
  /**
   * Evaluate the terms in [optargs] and make an object
   */
  const MAKE_OBJ = 3;
  /**
   * Takes an integer representing a variable and returns the value stored
   * in that variable.  It's the responsibility of the client to translate
   * from their local representation of a variable to a unique _non-negative_
   * integer for that variable.  (We do it this way instead of letting
   * clients provide variable names as strings to discourage
   * variable-capturing client libraries, and because it's more efficient
   * on the wire.)
   */
  const R_VAR = 10;
  /**
   * Takes some javascript code and executes it.
   */
  const JAVASCRIPT = 11;
  /**
   * STRING {timeout: !NUMBER} -> Function(*)
   */
  const UUID = 169;
  /**
   * Takes an HTTP URL and gets it.  If the get succeeds and
   *  returns valid JSON, it is converted into a DATUM
   */
  const HTTP = 153;
  /**
   * Takes a string and throws an error with that message.
   * Inside of a `default` block, you can omit the first
   * argument to rethrow whatever error you catch (this is most
   * useful as an argument to the `default` filter optarg).
   */
  const ERROR = 12;
  /**
   * Takes nothing and returns a reference to the implicit variable.
   */
  const IMPLICIT_VAR = 13;
  /**
   * * Data Operators
   * Returns a reference to a database.
   */
  const DB = 14;
  /**
   * Returns a reference to a table.
   */
  const TABLE = 15;
  /**
   * STRING, {use_outdated:BOOL, identifier_format:STRING} -> Table
   * Gets a single element from a table by its primary or a secondary key.
   */
  const GET = 16;
  /**
   * Table, STRING -> NULL            | Table, NUMBER -> NULL |
   */
  const GET_ALL = 78;
  /**
   * Simple DATUM Ops
   */
  const EQ = 17;
  const NE = 18;
  const LT = 19;
  const LE = 20;
  const GT = 21;
  const GE = 22;
  const NOT = 23;
  /**
   * ADD can either add two numbers or concatenate two arrays.
   */
  const ADD = 24;
  const SUB = 25;
  const MUL = 26;
  const DIV = 27;
  const MOD = 28;
  const FLOOR = 183;
  const CEIL = 184;
  const ROUND = 185;
  /**
   * DATUM Array Ops
   * Append a single element to the end of an array (like `snoc`).
   */
  const APPEND = 29;
  /**
   * Prepend a single element to the end of an array (like `cons`).
   */
  const PREPEND = 80;
  /**
   * Remove the elements of one array from another array.
   */
  const DIFFERENCE = 95;
  /**
   * DATUM Set Ops
   * Set ops work on arrays. They don't use actual sets and thus have
   * performance characteristics you would expect from arrays rather than
   * from sets. All set operations have the post condition that they
   * array they return contains no duplicate values.
   */
  const SET_INSERT = 88;
  const SET_INTERSECTION = 89;
  const SET_UNION = 90;
  const SET_DIFFERENCE = 91;
  const SLICE = 30;
  const SKIP = 70;
  const LIMIT = 71;
  const OFFSETS_OF = 87;
  const CONTAINS = 93;
  /**
   * Stream/Object Ops
   * Get a particular field from an object, or map that over a
   * sequence.
   */
  const GET_FIELD = 31;
  /**
   * | Sequence, STRING -> Sequence
   * Return an array containing the keys of the object.
   */
  const KEYS = 94;
  /**
   * Creates an object
   */
  const OBJECT = 143;
  /**
   * Check whether an object contains all the specified fields,
   * or filters a sequence so that all objects inside of it
   * contain all the specified fields.
   */
  const HAS_FIELDS = 32;
  /**
   * x.with_fields(...) <=> x.has_fields(...).pluck(...)
   */
  const WITH_FIELDS = 96;
  /**
   * Get a subset of an object by selecting some attributes to preserve,
   * or map that over a sequence.  (Both pick and pluck, polymorphic.)
   */
  const PLUCK = 33;
  /**
   * Get a subset of an object by selecting some attributes to discard, or
   * map that over a sequence.  (Both unpick and without, polymorphic.)
   */
  const WITHOUT = 34;
  /**
   * Merge objects (right-preferential)
   */
  const MERGE = 35;
  /**
   * Sequence Ops
   * Get all elements of a sequence between two values.
   * Half-open by default, but the openness of either side can be
   * changed by passing 'closed' or 'open for `right_bound` or
   * `left_bound`.
   */
  const BETWEEN_DEPRECATED = 36;
  /**
   * With the newer version, clients should use `r.minval` and `r.maxval` for unboundedness
   */
  const BETWEEN = 182;
  const REDUCE = 37;
  const MAP = 38;
  /**
   * Filter a sequence with either a function or a shortcut
   * object (see API docs for details).  The body of FILTER is
   * wrapped in an implicit `.default(false)`, and you can
   * change the default value by specifying the `default`
   * optarg.  If you make the default `r.error`, all errors
   * caught by `default` will be rethrown as if the `default`
   * did not exist.
   */
  const FILTER = 39;
  /**
   * Sequence, OBJECT, {default:DATUM} -> Sequence
   * Map a function over a sequence and then concatenate the results together.
   */
  const CONCAT_MAP = 40;
  /**
   * Order a sequence based on one or more attributes.
   */
  const ORDER_BY = 41;
  /**
   * Get all distinct elements of a sequence (like `uniq`).
   */
  const DISTINCT = 42;
  /**
   * Count the number of elements in a sequence, or only the elements that match
   * a given filter.
   */
  const COUNT = 43;
  const IS_EMPTY = 86;
  /**
   * Take the union of multiple sequences (preserves duplicate elements! (use distinct)).
   */
  const UNION = 44;
  /**
   * Get the Nth element of a sequence.
   */
  const NTH = 45;
  /**
   * do NTH or GET_FIELD depending on target object
   */
  const BRACKET = 170;
  const INNER_JOIN = 48;
  const OUTER_JOIN = 49;
  /**
   * An inner-join that does an equality comparison on two attributes.
   */
  const EQ_JOIN = 50;
  const ZIP = 72;
  const RANGE = 173;
  /**
   * Array Ops
   * Insert an element in to an array at a given index.
   */
  const INSERT_AT = 82;
  /**
   * Remove an element at a given index from an array.
   */
  const DELETE_AT = 83;
  /**
   * ARRAY, NUMBER, NUMBER -> ARRAY
   * Change the element at a given index of an array.
   */
  const CHANGE_AT = 84;
  /**
   * Splice one array in to another array.
   */
  const SPLICE_AT = 85;
  /**
   * * Type Ops
   * Coerces a datum to a named type (e.g. "bool").
   * If you previously used `stream_to_array`, you should use this instead
   * with the type "array".
   */
  const COERCE_TO = 51;
  /**
   * Returns the named type of a datum (e.g. TYPE_OF(true) = "BOOL")
   */
  const TYPE_OF = 52;
  /**
   * * Write Ops (the OBJECTs contain data about number of errors etc.)
   * Updates all the rows in a selection.  Calls its Function with the row
   * to be updated, and then merges the result of that call.
   */
  const UPDATE = 53;
  /**
   * SingleSelection, Function(1), {non_atomic:BOOL, durability:STRING, return_changes:BOOL} -> OBJECT |
   * StreamSelection, OBJECT,      {non_atomic:BOOL, durability:STRING, return_changes:BOOL} -> OBJECT |
   * SingleSelection, OBJECT,      {non_atomic:BOOL, durability:STRING, return_changes:BOOL} -> OBJECT
   * Deletes all the rows in a selection.
   */
  const DELETE = 54;
  /**
   * Replaces all the rows in a selection.  Calls its Function with the row
   * to be replaced, and then discards it and stores the result of that
   * call.
   */
  const REPLACE = 55;
  /**
   * Inserts into a table.  If `conflict` is replace, overwrites
   * entries with the same primary key.  If `conflict` is
   * update, does an update on the entry.  If `conflict` is
   * error, or is omitted, conflicts will trigger an error.
   */
  const INSERT = 56;
  /**
   * * Administrative OPs
   * Creates a database with a particular name.
   */
  const DB_CREATE = 57;
  /**
   * Drops a database with a particular name.
   */
  const DB_DROP = 58;
  /**
   * Lists all the databases by name.  (Takes no arguments)
   */
  const DB_LIST = 59;
  /**
   * Creates a table with a particular name in a particular
   * database.  (You may omit the first argument to use the
   * default database.)
   */
  const TABLE_CREATE = 60;
  /**
   * Database, STRING, {primary_key:STRING, shards:NUMBER, replicas:OBJECT, primary_replica_tag:STRING} -> OBJECT
   * STRING, {primary_key:STRING, shards:NUMBER, replicas:NUMBER, primary_replica_tag:STRING} -> OBJECT
   * STRING, {primary_key:STRING, shards:NUMBER, replicas:OBJECT, primary_replica_tag:STRING} -> OBJECT
   * Drops a table with a particular name from a particular
   * database.  (You may omit the first argument to use the
   * default database.)
   */
  const TABLE_DROP = 61;
  /**
   * STRING -> OBJECT
   * Lists all the tables in a particular database.  (You may
   * omit the first argument to use the default database.)
   */
  const TABLE_LIST = 62;
  /**
   * -> ARRAY
   * Returns the row in the `rethinkdb.table_config` or `rethinkdb.db_config` table
   * that corresponds to the given database or table.
   */
  const CONFIG = 174;
  /**
   * Table -> SingleSelection
   * Returns the row in the `rethinkdb.table_status` table that corresponds to the
   * given table.
   */
  const STATUS = 175;
  /**
   * Called on a table, waits for that table to be ready for read/write operations.
   * Called on a database, waits for all of the tables in the database to be ready.
   * Returns the corresponding row or rows from the `rethinkdb.table_status` table.
   */
  const WAIT = 177;
  /**
   * Database -> OBJECT
   * Generates a new config for the given table, or all tables in the given database
   * The `shards` and `replicas` arguments are required
   */
  const RECONFIGURE = 176;
  /**
   * Database, {shards:NUMBER, replicas:OBJECT[, primary_replica_tag:STRING, dry_run:BOOLEAN]} -> OBJECT
   * Table, {shards:NUMBER, replicas:NUMBER[, primary_replica_tag:STRING, dry_run:BOOLEAN]} -> OBJECT
   * Table, {shards:NUMBER, replicas:OBJECT[, primary_replica_tag:STRING, dry_run:BOOLEAN]} -> OBJECT
   * Balances the table's shards but leaves everything else the same. Can also be
   * applied to an entire database at once.
   */
  const REBALANCE = 179;
  /**
   * Ensures that previously issued soft-durability writes are complete and
   * written to disk.
   */
  const SYNC = 138;
  /**
   * * Secondary indexes OPs
   * Creates a new secondary index with a particular name and definition.
   */
  const INDEX_CREATE = 75;
  /**
   * Drops a secondary index with a particular name from the specified table.
   */
  const INDEX_DROP = 76;
  /**
   * Lists all secondary indexes on a particular table.
   */
  const INDEX_LIST = 77;
  /**
   * Gets information about whether or not a set of indexes are ready to
   * be accessed. Returns a list of objects that look like this:
   * {index:STRING, ready:BOOL[, blocks_processed:NUMBER, blocks_total:NUMBER]}
   */
  const INDEX_STATUS = 139;
  /**
   * Blocks until a set of indexes are ready to be accessed. Returns the
   * same values INDEX_STATUS.
   */
  const INDEX_WAIT = 140;
  /**
   * Renames the given index to a new name
   */
  const INDEX_RENAME = 156;
  /**
   * * Control Operators
   * Calls a function on data
   */
  const FUNCALL = 64;
  /**
   * Executes its first argument, and returns its second argument if it
   * got [true] or its third argument if it got [false] (like an `if`
   * statement).
   */
  const BRANCH = 65;
  /**
   * Returns true if any of its arguments returns true (short-circuits).
   */
  const R_OR = 66;
  /**
   * Returns true if all of its arguments return true (short-circuits).
   */
  const R_AND = 67;
  /**
   * Calls its Function with each entry in the sequence
   * and executes the array of terms that Function returns.
   */
  const FOR_EACH = 68;
  /**
   * An anonymous function.  Takes an array of numbers representing
   * variables (see [VAR] above), and a [Term] to execute with those in
   * scope.  Returns a function that may be passed an array of arguments,
   * then executes the Term with those bound to the variable names.  The
   * user will never construct this directly.  We use it internally for
   * things like `map` which take a function.  The "arity" of a [Function] is
   * the number of arguments it takes.
   * For example, here's what `_X_.map{|x| x+2}` turns into:
   * Term {
   *   type = MAP;
   *   args = [_X_,
   *           Term {
   *             type = Function;
   *             args = [Term {
   *                       type = DATUM;
   *                       datum = Datum {
   *                         type = R_ARRAY;
   *                         r_array = [Datum { type = R_NUM; r_num = 1; }];
   *                       };
   *                     },
   *                     Term {
   *                       type = ADD;
   *                       args = [Term {
   *                                 type = VAR;
   *                                 args = [Term {
   *                                           type = DATUM;
   *                                           datum = Datum { type = R_NUM;
   *                                                           r_num = 1};
   *                                         }];
   *                               },
   *                               Term {
   *                                 type = DATUM;
   *                                 datum = Datum { type = R_NUM; r_num = 2; };
   *                               }];
   *                     }];
   *           }];
   */
  const FUNC = 69;
  /**
   * Indicates to ORDER_BY that this attribute is to be sorted in ascending order.
   */
  const ASC = 73;
  /**
   * Indicates to ORDER_BY that this attribute is to be sorted in descending order.
   */
  const DESC = 74;
  /**
   * Gets info about anything.  INFO is most commonly called on tables.
   */
  const INFO = 79;
  /**
   * `a.match(b)` returns a match object if the string `a`
   * matches the regular expression `b`.
   */
  const MATCH = 97;
  /**
   * Change the case of a string.
   */
  const UPCASE = 141;
  const DOWNCASE = 142;
  /**
   * Select a number of elements from sequence with uniform distribution.
   */
  const SAMPLE = 81;
  /**
   * Evaluates its first argument.  If that argument returns
   * NULL or throws an error related to the absence of an
   * expected value (for instance, accessing a non-existent
   * field or adding NULL to an integer), DEFAULT will either
   * return its second argument or execute it if it's a
   * function.  If the second argument is a function, it will be
   * passed either the text of the error or NULL as its
   * argument.
   */
  const R_DEFAULT = 92;
  /**
   * Parses its first argument as a json string and returns it as a
   * datum.
   */
  const JSON = 98;
  /**
   * Returns the datum as a JSON string.
   * N.B.: we would really prefer this be named TO_JSON and that exists as
   * an alias in Python and JavaScript drivers; however it conflicts with the
   * standard `to_json` method defined by Ruby's standard json library.
   */
  const TO_JSON_STRING = 172;
  /**
   * Parses its first arguments as an ISO 8601 time and returns it as a
   * datum.
   */
  const ISO8601 = 99;
  /**
   * Prints a time as an ISO 8601 time.
   */
  const TO_ISO8601 = 100;
  /**
   * Returns a time given seconds since epoch in UTC.
   */
  const EPOCH_TIME = 101;
  /**
   * Returns seconds since epoch in UTC given a time.
   */
  const TO_EPOCH_TIME = 102;
  /**
   * The time the query was received by the server.
   */
  const NOW = 103;
  /**
   * Puts a time into an ISO 8601 timezone.
   */
  const IN_TIMEZONE = 104;
  /**
   * a.during(b, c) returns whether a is in the range [b, c)
   */
  const DURING = 105;
  /**
   * Retrieves the date portion of a time.
   */
  const DATE = 106;
  /**
   * x.time_of_day == x.date - x
   */
  const TIME_OF_DAY = 126;
  /**
   * Returns the timezone of a time.
   */
  const TIMEZONE = 127;
  /**
   * These access the various components of a time.
   */
  const YEAR = 128;
  const MONTH = 129;
  const DAY = 130;
  const DAY_OF_WEEK = 131;
  const DAY_OF_YEAR = 132;
  const HOURS = 133;
  const MINUTES = 134;
  const SECONDS = 135;
  /**
   * Construct a time from a date and optional timezone or a
   * date+time and optional timezone.
   */
  const TIME = 136;
  /**
   * Constants for ISO 8601 days of the week.
   */
  const MONDAY = 107;
  const TUESDAY = 108;
  const WEDNESDAY = 109;
  const THURSDAY = 110;
  const FRIDAY = 111;
  const SATURDAY = 112;
  const SUNDAY = 113;
  /**
   * Constants for ISO 8601 months.
   */
  const JANUARY = 114;
  const FEBRUARY = 115;
  const MARCH = 116;
  const APRIL = 117;
  const MAY = 118;
  const JUNE = 119;
  const JULY = 120;
  const AUGUST = 121;
  const SEPTEMBER = 122;
  const OCTOBER = 123;
  const NOVEMBER = 124;
  const DECEMBER = 125;
  /**
   * Indicates to MERGE to replace, or remove in case of an empty literal, the
   * other object rather than merge it.
   */
  const LITERAL = 137;
  /**
   * SEQUENCE, STRING -> GROUPED_SEQUENCE | SEQUENCE, FUNCTION -> GROUPED_SEQUENCE
   */
  const GROUP = 144;
  const SUM = 145;
  const AVG = 146;
  const MIN = 147;
  const MAX = 148;
  /**
   * `str.split()` splits on whitespace
   * `str.split(" ")` splits on spaces only
   * `str.split(" ", 5)` splits on spaces with at most 5 results
   * `str.split(nil, 5)` splits on whitespace with at most 5 results
   */
  const SPLIT = 149;
  const UNGROUP = 150;
  /**
   * Takes a range of numbers and returns a random number within the range
   */
  const RANDOM = 151;
  const CHANGES = 152;
  const ARGS = 154;
  /**
   * BINARY is client-only at the moment, it is not supported on the server
   */
  const BINARY = 155;
  const GEOJSON = 157;
  const TO_GEOJSON = 158;
  const POINT = 159;
  const LINE = 160;
  const POLYGON = 161;
  const DISTANCE = 162;
  const INTERSECTS = 163;
  const INCLUDES = 164;
  const CIRCLE = 165;
  const GET_INTERSECTING = 166;
  const FILL = 167;
  const GET_NEAREST = 168;
  const POLYGON_SUB = 171;
  /**
   * Constants for specifying key ranges
   */
  const MINVAL = 180;
  const MAXVAL = 181;
}
