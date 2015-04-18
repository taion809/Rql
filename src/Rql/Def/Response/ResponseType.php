<?php
namespace Rql\Def\Response;

class ResponseType
{
  /**
   * These response types indicate success.
   */
  const SUCCESS_ATOM = 1;
  const SUCCESS_SEQUENCE = 2;
  const SUCCESS_PARTIAL = 3;
  /**
   * datatypes.  If you send a [CONTINUE] query with
   * the same token as this response, you will get
   * more of the sequence.  Keep sending [CONTINUE]
   * queries until you get back [SUCCESS_SEQUENCE].
   */
  const WAIT_COMPLETE = 4;
  /**
   * These response types indicate failure.
   */
  const CLIENT_ERROR = 16;
  /**
   * client sends a malformed protobuf, or tries to
   * send [CONTINUE] for an unknown token.
   */
  const COMPILE_ERROR = 17;
  /**
   * checking.  For example, if you pass too many
   * arguments to a function.
   */
  const RUNTIME_ERROR = 18;
}
