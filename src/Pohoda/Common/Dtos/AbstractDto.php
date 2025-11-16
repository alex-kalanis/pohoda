<?php

namespace Riesenia\Pohoda\Common\Dtos;

/**
 * Basic DTO for setting data type-aware way passed to this package
 *
 * I need to set type-aware data in classes which want to use this package to make data sequence
 * Static analysis to catch some bugs is otherwise PITA
 *
 * todo: typova kontrola prvku (int, varcharX, enum, date, ...)
 * todo: budou tu abstract DTOs podle obsahu - basic, header, body, summary, ... - a pak na ne navazane realne instance per agenda
 */
abstract class AbstractDto {}
