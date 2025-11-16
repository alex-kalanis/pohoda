<?php

namespace Riesenia\Pohoda\Document;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document;

/**
 * Basic DTO for documents
 * @property Document\AbstractHeader|Common\Dtos\AbstractHeaderDto|null $header
 * @property array<Document\AbstractItem|Common\Dtos\AbstractItemDto> $details
 * @property Document\AbstractSummary|Common\Dtos\AbstractSummaryDto|null $summary
 */
abstract class AbstractDocumentDto extends Common\Dtos\AbstractDto {}
