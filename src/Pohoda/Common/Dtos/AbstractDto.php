<?php

namespace kalanis\Pohoda\Common\Dtos;

/**
 * Basic DTO for setting data type-aware way passed to this package
 *
 * I need to set type-aware data in classes which want to use this package to make data sequence
 * Static analysis to catch some bugs is otherwise PITA
 */
abstract class AbstractDto {}
