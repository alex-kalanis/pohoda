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

/**
 * Factory for Pohoda objects.
 *
 * @method \Riesenia\Pohoda\Addressbook   createAddressbook(array $data = [])
 * @method \Riesenia\Pohoda\Bank          createBank(array $data = [])
 * @method \Riesenia\Pohoda\CashSlip      createCashSlip(array $data = [])
 * @method \Riesenia\Pohoda\Category      createCategory(array $data = [])
 * @method \Riesenia\Pohoda\Contract      createContract(array $data = [])
 * @method \Riesenia\Pohoda\IntDoc        createIntDoc(array $data = [])
 * @method \Riesenia\Pohoda\IntParam      createIntParam(array $data = [])
 * @method \Riesenia\Pohoda\Invoice       createInvoice(array $data = [])
 * @method \Riesenia\Pohoda\IssueSlip     createIssueSlip(array $data = [])
 * @method \Riesenia\Pohoda\ListRequest   createListRequest(array $data = [])
 * @method \Riesenia\Pohoda\Offer         createOffer(array $data = [])
 * @method \Riesenia\Pohoda\Order         createOrder(array $data = [])
 * @method \Riesenia\Pohoda\PrintRequest  createPrintRequest(array $data = [])
 * @method \Riesenia\Pohoda\Receipt       createReceipt(array $data = [])
 * @method \Riesenia\Pohoda\Stock         createStock(array $data = [])
 * @method \Riesenia\Pohoda\StockTransfer createStockTransfer(array $data = [])
 * @method \Riesenia\Pohoda\Storage       createStorage(array $data = [])
 * @method \Riesenia\Pohoda\Supplier      createSupplier(array $data = [])
 * @method \Riesenia\Pohoda\UserList      createUserList(array $data = [])
 * @method \Riesenia\Pohoda\Voucher       createVoucher(array $data = [])
 * @method \bool loadAddressbook(string $filename)
 * @method \bool loadBank(string $filename)
 * @method \bool loadCashSlip(string $filename)
 * @method \bool loadCategory(string $filename)
 * @method \bool loadContract(string $filename)
 * @method \bool loadIntDoc(string $filename)
 * @method \bool loadIntParam(string $filename)
 * @method \bool loadInvoice(string $filename)
 * @method \bool loadIssueSlip(string $filename)
 * @method \bool loadListRequest(string $filename)
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
    /** @var array<string,string> */
    public static array $namespaces = [
        'adb' => 'http://www.stormware.cz/schema/version_2/addressbook.xsd',
        'bnk' => 'http://www.stormware.cz/schema/version_2/bank.xsd',
        'con' => 'http://www.stormware.cz/schema/version_2/contract.xsd',
        'ctg' => 'http://www.stormware.cz/schema/version_2/category.xsd',
        'dat' => 'http://www.stormware.cz/schema/version_2/data.xsd',
        'ftr' => 'http://www.stormware.cz/schema/version_2/filter.xsd',
        'int' => 'http://www.stormware.cz/schema/version_2/intDoc.xsd',
        'inv' => 'http://www.stormware.cz/schema/version_2/invoice.xsd',
        'ipm' => 'http://www.stormware.cz/schema/version_2/intParam.xsd',
        'lAdb' => 'http://www.stormware.cz/schema/version_2/list_addBook.xsd',
        'lst' => 'http://www.stormware.cz/schema/version_2/list.xsd',
        'lStk' => 'http://www.stormware.cz/schema/version_2/list_stock.xsd',
        'ofr' => 'http://www.stormware.cz/schema/version_2/offer.xsd',
        'ord' => 'http://www.stormware.cz/schema/version_2/order.xsd',
        'pre' => 'http://www.stormware.cz/schema/version_2/prevodka.xsd',
        'pri' => 'http://www.stormware.cz/schema/version_2/prijemka.xsd',
        'prn' => 'http://www.stormware.cz/schema/version_2/print.xsd',
        'pro' => 'http://www.stormware.cz/schema/version_2/prodejka.xsd',
        'str' => 'http://www.stormware.cz/schema/version_2/storage.xsd',
        'stk' => 'http://www.stormware.cz/schema/version_2/stock.xsd',
        'sup' => 'http://www.stormware.cz/schema/version_2/supplier.xsd',
        'typ' => 'http://www.stormware.cz/schema/version_2/type.xsd',
        'vch' => 'http://www.stormware.cz/schema/version_2/voucher.xsd',
        'vyd' => 'http://www.stormware.cz/schema/version_2/vydejka.xsd',

        'rsp' => "http://www.stormware.cz/schema/version_2/response.xsd",
        'rdc' => "http://www.stormware.cz/schema/version_2/documentresponse.xsd",
        'lCen' => "http://www.stormware.cz/schema/version_2/list_centre.xsd",
        'lAcv' => "http://www.stormware.cz/schema/version_2/list_activity.xsd",
        'acu' => "http://www.stormware.cz/schema/version_2/accountingunit.xsd",
        'enq' => "http://www.stormware.cz/schema/version_2/enquiry.xsd",
        'bal' => "http://www.stormware.cz/schema/version_2/balance.xsd",
        'vyr' => "http://www.stormware.cz/schema/version_2/vyroba.xsd",
        'prm' => "http://www.stormware.cz/schema/version_2/parameter.xsd",
        'lCon' => "http://www.stormware.cz/schema/version_2/list_contract.xsd",
        'idp' => "http://www.stormware.cz/schema/version_2/individualPrice.xsd",
        'lck' => "http://www.stormware.cz/schema/version_2/lock.xsd",
        'isd' => "http://www.stormware.cz/schema/version_2/isdoc.xsd",
        'sEET' => "http://www.stormware.cz/schema/version_2/sendEET.xsd",
        'act' => "http://www.stormware.cz/schema/version_2/accountancy.xsd",
        'sto' => "http://www.stormware.cz/schema/version_2/store.xsd",
        'grs' => "http://www.stormware.cz/schema/version_2/groupStocks.xsd",
        'acp' => "http://www.stormware.cz/schema/version_2/actionPrice.xsd",
        'csh' => "http://www.stormware.cz/schema/version_2/cashRegister.xsd",
        'bka' => "http://www.stormware.cz/schema/version_2/bankAccount.xsd",
        'ilt' => "http://www.stormware.cz/schema/version_2/inventoryLists.xsd",
        'nms' => "http://www.stormware.cz/schema/version_2/numericalSeries.xsd",
        'pay' => "http://www.stormware.cz/schema/version_2/payment.xsd",
        'mKasa' => "http://www.stormware.cz/schema/version_2/mKasa.xsd",
        'gdp' => "http://www.stormware.cz/schema/version_2/GDPR.xsd",
        'est' => "http://www.stormware.cz/schema/version_2/establishment.xsd",
        'cen' => "http://www.stormware.cz/schema/version_2/centre.xsd",
        'acv' => "http://www.stormware.cz/schema/version_2/activity.xsd",
        'afp' => "http://www.stormware.cz/schema/version_2/accountingFormOfPayment.xsd",
        'vat' => "http://www.stormware.cz/schema/version_2/classificationVAT.xsd",
        'rgn' => "http://www.stormware.cz/schema/version_2/registrationNumber.xsd",
        'asv' => "http://www.stormware.cz/schema/version_2/accountingSalesVouchers.xsd",
        'arch' => "http://www.stormware.cz/schema/version_2/archive.xsd",
        'req' => "http://www.stormware.cz/schema/version_2/productRequirement.xsd",
        'mov' => "http://www.stormware.cz/schema/version_2/movement.xsd",
        'rec' => "http://www.stormware.cz/schema/version_2/recyclingContrib.xsd",
        'srv' => "http://www.stormware.cz/schema/version_2/service.xsd",
        'rul' => "http://www.stormware.cz/schema/version_2/rulesPairing.xsd",
        'lwl' => "http://www.stormware.cz/schema/version_2/liquidationWithoutLink.xsd",
        'dis' => "http://www.stormware.cz/schema/version_2/discount.xsd",
        'lqd' => "http://www.stormware.cz/schema/version_2/automaticLiquidation.xsd",
        'uag' => "http://www.stormware.cz/schema/version_2/userAgenda.xsd",
        'apf' => "http://www.stormware.cz/schema/version_2/advancePartFulfilment.xsd",
    ];

    public static string $encoding = 'windows-1250';

    public static bool $sanitizeEncoding = false;

    /**
     * A set of transformers that will be used when serializing data.
     *
     * @var \Riesenia\Pohoda\ValueTransformer\ValueTransformer[]
     */
    public static array $transformers = [];

    protected string $application = 'Pohoda connector';

    protected bool $isInMemory;

    protected \XMLWriter $xmlWriter;

    protected \XMLReader $xmlReader;

    protected readonly Pohoda\AgendaFactory $agendaFactory;

    protected string $elementName;

    protected bool $importRecursive = false;

    public function __construct(
        protected readonly string $ico,
    )
    {
        $this->agendaFactory = new Pohoda\AgendaFactory($this->ico);
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
     * Create and return instance of requested agenda.
     *
     * @param string              $name
     * @param array<string,mixed> $data
     *
     * @return AbstractAgenda
     */
    public function create(string $name, array $data = []): AbstractAgenda
    {
        return $this->agendaFactory->getAgenda($name, $data);
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
                return false;
            }
        }

        $this->xmlWriter->startDocument('1.0', self::$encoding);
        $this->xmlWriter->startElementNs('dat', 'dataPack', null);

        $this->xmlWriter->writeAttribute('id', $id);
        $this->xmlWriter->writeAttribute('ico', $this->ico);
        $this->xmlWriter->writeAttribute('application', $this->application);
        $this->xmlWriter->writeAttribute('version', '2.0');
        $this->xmlWriter->writeAttribute('note', $note);

        foreach (self::$namespaces as $k => $v) {
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
     * @param string $filename
     *
     * @return bool
     */
    public function load(string $name, string $filename): bool
    {
        $this->xmlReader = new \XMLReader();

        if (!$this->xmlReader->open($filename)) {
            return false;
        }

        $class = $this->agendaFactory->getAgenda($name, [], false);
        $this->elementName = $class->getImportRoot() ?? throw new \DomainException('Not allowed entity: ' . $name);
        $this->importRecursive = $class->canImportRecursive();

        return true;
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
