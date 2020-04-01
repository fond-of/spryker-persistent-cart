<?php

namespace FondOfSpryker\Zed\PersistentCart\Business\Model;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use ReflectionClass;
use ReflectionMethod;
use Spryker\Zed\PersistentCart\Business\Model\QuoteResponseExpanderInterface;
use Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToMessengerFacadeInterface;
use Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToQuoteFacadeInterface;

class QuoteDeleterTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\PersistentCart\Business\Model\QuoteDeleter
     */
    protected $quoteDeleter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToQuoteFacadeInterface
     */
    protected $persistentCartToQuoteFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\PersistentCart\Business\Model\QuoteResponseExpanderInterface
     */
    protected $quoteResponseExpanderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToMessengerFacadeInterface
     */
    protected $persistentCartToMessengerFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var string
     */
    protected $customerReference;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var int
     */
    protected $idCompanyUser;

    /**
     * @var int
     */
    protected $idQuote;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->persistentCartToQuoteFacadeInterfaceMock = $this->getMockBuilder(PersistentCartToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseExpanderInterfaceMock = $this->getMockBuilder(QuoteResponseExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->persistentCartToMessengerFacadeInterfaceMock = $this->getMockBuilder(PersistentCartToMessengerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReference = 'customer-reference';

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompanyUser = 1;

        $this->idQuote = 2;

        $this->quoteDeleter = new QuoteDeleter(
            $this->persistentCartToQuoteFacadeInterfaceMock,
            $this->quoteResponseExpanderInterfaceMock,
            $this->persistentCartToMessengerFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testIsQuoteDeleteAllowed(): void
    {

        $reflectionMethod = self::getMethod('isQuoteDeleteAllowed');

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($this->customerReference);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('other-customer-reference');

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($this->idCompanyUser);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($this->idQuote);

        $this->assertTrue(
            $reflectionMethod->invokeArgs($this->quoteDeleter, [
                $this->quoteTransferMock,
                $this->customerTransferMock,
            ])
        );
    }

    /**
     * @param string $name
     *
     * @return \ReflectionMethod
     */
    protected function getMethod(string $name): ReflectionMethod
    {
        $reflectionClass = new ReflectionClass(QuoteDeleter::class);
        $reflectionMethod = $reflectionClass->getMethod($name);
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod;
    }
}
