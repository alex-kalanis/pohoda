<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OneDirectionalVariablesTrait;

/**
 * Factory for Pohoda objects.
 *
 * @method Pohoda\AddressBook   createAddressBook(array $data = [])
 * @method Pohoda\Bank          createBank(array $data = [])
 * @method Pohoda\CashSlip      createCashSlip(array $data = [])
 * @method Pohoda\Category      createCategory(array $data = [])
 * @method Pohoda\Contract      createContract(array $data = [])
 * @method Pohoda\IntDoc        createIntDoc(array $data = [])
 * @method Pohoda\IntParam      createIntParam(array $data = [])
 * @method Pohoda\Invoice       createInvoice(array $data = [])
 * @method Pohoda\IssueSlip     createIssueSlip(array $data = [])
 * @method Pohoda\ListRequest   createListRequest(array $data = [])
 * @method Pohoda\ListResponse  createListResponse(array $data = [])
 * @method Pohoda\Offer         createOffer(array $data = [])
 * @method Pohoda\Order         createOrder(array $data = [])
 * @method Pohoda\PrintRequest  createPrintRequest(array $data = [])
 * @method Pohoda\Receipt       createReceipt(array $data = [])
 * @method Pohoda\Stock         createStock(array $data = [])
 * @method Pohoda\StockTransfer createStockTransfer(array $data = [])
 * @method Pohoda\Storage       createStorage(array $data = [])
 * @method Pohoda\Supplier      createSupplier(array $data = [])
 * @method Pohoda\UserList      createUserList(array $data = [])
 * @method Pohoda\Voucher       createVoucher(array $data = [])
 * @method \bool loadAddressBook(string $filename)
 * @method \bool loadBank(string $filename)
 * @method \bool loadCashSlip(string $filename)
 * @method \bool loadCategory(string $filename)
 * @method \bool loadContract(string $filename)
 * @method \bool loadIntDoc(string $filename)
 * @method \bool loadIntParam(string $filename)
 * @method \bool loadInvoice(string $filename)
 * @method \bool loadIssueSlip(string $filename)
 * @method \bool loadListRequest(string $filename)
 * @method \bool loadListResponse(string $filename)
 * @method \bool loadOffer(string $filename)
 * @method \bool loadOrder(string $filename)
 * @method \bool loadPrintRequest(string $filename)
 * @method \bool loadReceipt(string $filename)
 * @method \bool loadStock(string $filename)
 * @method \bool loadStockTransfer(string $filename)
 * @method \bool loadStorage(string $filename)
 * @method \bool loadSupplier(string $filename)
 * @method \bool loadUserList(string $filename)
 * @method \bool loadVoucher(string $filename)
 *
 * @link https://www.stormware.cz/pohoda/xml/seznamschemat/   schemas
 */
class Pohoda
{
    use OneDirectionalVariablesTrait;

    protected string $application = 'Pohoda connector';

    protected bool $isInMemory;

    protected \XMLWriter $xmlWriter;

    protected \XMLReader $xmlReader;

    protected Pohoda\AgendaFactory $agendaFactory;

    protected string $elementName;

    protected bool $importRecursive = false;

    protected readonly Pohoda\Common\CompanyRegistrationNumberInterface $companyRegistrationNumber;

    public function __construct(
        string|Pohoda\Common\CompanyRegistrationNumberInterface $companyRegistrationNumber,
        protected Pohoda\ValueTransformer\SanitizeEncoding $sanitizeEncoding = new Pohoda\ValueTransformer\SanitizeEncoding(new Pohoda\ValueTransformer\Listing()),
        protected readonly Pohoda\Common\NamespacesPaths $namespacesPaths = new Pohoda\Common\NamespacesPaths(),
    ) {
        $this->companyRegistrationNumber = is_object($companyRegistrationNumber) ? $companyRegistrationNumber : Pohoda\Common\CompanyRegistrationNumber::init($companyRegistrationNumber);
        $this->agendaFactory = new Pohoda\AgendaFactory($this->namespacesPaths, $this->sanitizeEncoding);
    }

    /**
     * Set the name of the application.
     *
     * @param string $name
     *
     * @return void
     */
    public function setApplicationName(string $name): void
    {
        $this->application = $name;
    }

    /**
     * Get class listing transformers for content serialization
     *
     * @return Pohoda\ValueTransformer\Listing
     */
    public function getTransformerListing(): Pohoda\ValueTransformer\Listing
    {
        return $this->sanitizeEncoding->getListing();
    }

    /**
     * Create and return instance of requested agenda.
     *
     * @param string              $name
     * @param array<string,mixed> $data
     *
     * @return AbstractAgenda
     */
    public function create(string $name, array $data = []): AbstractAgenda
    {
        return $this->agendaFactory->getAgenda($name)->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions(true)->setData($data);
    }

    /**
     * Open new XML file for writing.
     *
     * @param string|null $filename path to output file or null for memory
     * @param string      $id
     * @param string      $note
     *
     * @return bool
     */
    public function open(?string $filename, string $id, string $note = ''): bool
    {
        $this->xmlWriter = new \XMLWriter();

        if (is_null($filename)) {
            $this->isInMemory = true;
            $this->xmlWriter->openMemory();
        } else {
            $this->isInMemory = false;

            if (!$this->xmlWriter->openUri($filename)) {
                // @codeCoverageIgnoreStart
                // I cannot test this, because it needs source file somewhere online
                return false;
            }
            // @codeCoverageIgnoreEnd
        }

        $this->xmlWriter->startDocument('1.0', $this->sanitizeEncoding->getEncoding());
        $this->xmlWriter->startElementNs('dat', 'dataPack', null);

        $this->xmlWriter->writeAttribute('id', $id);
        $this->xmlWriter->writeAttribute('ico', $this->companyRegistrationNumber->getCompanyNumber());
        $this->xmlWriter->writeAttribute('application', $this->application);
        $this->xmlWriter->writeAttribute('version', '2.0');
        $this->xmlWriter->writeAttribute('note', $note);

        foreach ($this->namespacesPaths->allNamespaces() as $k => $v) {
            // put all known namespaces into base element attributes
            $this->xmlWriter->writeAttributeNs('xmlns', $k, null, $v);
        }

        return true;
    }

    /**
     * Add item.
     *
     * @param string $id
     * @param AbstractAgenda $agenda
     *
     * @return void
     */
    public function addItem(string $id, AbstractAgenda $agenda): void
    {
        $this->xmlWriter->startElementNs('dat', 'dataPackItem', null);

        $this->xmlWriter->writeAttribute('id', $id);
        $this->xmlWriter->writeAttribute('version', '2.0');
        $this->xmlWriter->writeRaw((string) $agenda->getXML()->asXML());
        $this->xmlWriter->endElement();

        if (!$this->isInMemory) {
            $this->xmlWriter->flush();
        }
    }

    /**
     * End and close XML file.
     *
     * @return int|string written bytes for file or XML string for memory
     */
    public function close(): int|string
    {
        $this->xmlWriter->endElement();

        return $this->xmlWriter->flush();
    }

    /**
     * Load XML file.
     *
     * @param string $name
     * @param string $filename filename or current xml content
     *
     * @return bool
     */
    public function load(string $name, string $filename): bool
    {
        $this->xmlReader = new \XMLReader();

        if ($this->detectXmlFileHeader($filename)) {
            if (!@$this->xmlReader->XML($filename)) {
                // @codeCoverageIgnoreStart
                // cannot create string which will be parsed as XML and crash itself afterward
                return false;
            }
            // @codeCoverageIgnoreEnd
        } else {
            if (!@$this->xmlReader->open($filename)) {
                return false;
            }
        }

        $class = $this->agendaFactory->getAgenda($name);
        $class->setResolveOptions(false);
        $this->elementName = $class->getImportRoot() ?? throw new \DomainException('Not allowed entity: ' . $name);
        $this->importRecursive = $class->canImportRecursive();

        return true;
    }

    /**
     * Detect if passed file is in fact XML and not just path
     * A bit simple, but it is enough for now
     *
     * @param string $string
     *
     * @return bool
     */
    protected function detectXmlFileHeader(string $string): bool
    {
        return str_contains(substr($string, 0, 64), '<?xml');
    }

    /**
     * Get next item in loaded file.
     *
     * @return \SimpleXMLElement|null
     */
    public function next(): ?\SimpleXMLElement
    {
        while (\XMLReader::ELEMENT != $this->xmlReader->nodeType || $this->xmlReader->name !== $this->elementName) {
            if (!$this->xmlReader->read()) {
                return null;
            }
        }

        $xml = new \SimpleXMLElement($this->xmlReader->readOuterXml());
        $this->importRecursive ? $this->xmlReader->next() : $this->xmlReader->read();

        return $xml;
    }

    /**
     * Handle dynamic method calls.
     *
     * @param string  $method
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        // create<Agenda> method
        if (\preg_match('/create([A-Z][a-zA-Z0-9]*)/', $method, $matches)) {
            return \call_user_func([$this, 'create'], $matches[1], $arguments[0] ?? []);
        }

        // load<Agenda> method
        if (\preg_match('/load([A-Z][a-zA-Z0-9]*)/', $method, $matches)) {
            if (!isset($arguments[0])) {
                throw new \DomainException('Filename not set.');
            }

            return \call_user_func([$this, 'load'], $matches[1], $arguments[0]);
        }

        throw new \BadMethodCallException('Unknown method: ' . $method);
    }
}
