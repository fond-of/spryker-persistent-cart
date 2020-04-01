<?php

namespace FondOfSpryker\Zed\PersistentCart\Business;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\PersistentCart\Business\Model\QuoteDeleterInterface;
use Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToMessengerFacadeInterface;
use Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToQuoteFacadeInterface;
use Spryker\Zed\PersistentCart\PersistentCartDependencyProvider;
use Spryker\Zed\PersistentCartExtension\Dependency\Plugin\QuoteResponseExpanderPluginInterface;

class PersistentCartBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\PersistentCart\Business\PersistentCartBusinessFactory
     */
    protected $persistentCartBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToQuoteFacadeInterface
     */
    protected $persistentCartToQuoteFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\PersistentCartExtension\Dependency\Plugin\QuoteResponseExpanderPluginInterface
     */
    protected $quoteResponseExpanderPluginInterfaceMock;

    /**
     * @var \Spryker\Zed\PersistentCartExtension\Dependency\Plugin\QuoteResponseExpanderPluginInterface[]
     */
    protected $quoteResponseExpanderPluginInterfaceMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToMessengerFacadeInterface
     */
    protected $persistentCartToMessengerFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->persistentCartToQuoteFacadeInterfaceMock = $this->getMockBuilder(PersistentCartToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseExpanderPluginInterfaceMock = $this->getMockBuilder(QuoteResponseExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseExpanderPluginInterfaceMocks = [
            $this->quoteResponseExpanderPluginInterfaceMock,
        ];

        $this->persistentCartToMessengerFacadeInterfaceMock = $this->getMockBuilder(PersistentCartToMessengerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->persistentCartBusinessFactory = new PersistentCartBusinessFactory();
        $this->persistentCartBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateQuoteDeleter(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [PersistentCartDependencyProvider::FACADE_QUOTE],
                [PersistentCartDependencyProvider::PLUGINS_QUOTE_RESPONSE_EXPANDER],
                [PersistentCartDependencyProvider::FACADE_MESSENGER]
            )->willReturnOnConsecutiveCalls(
                $this->persistentCartToQuoteFacadeInterfaceMock,
                $this->quoteResponseExpanderPluginInterfaceMocks,
                $this->persistentCartToMessengerFacadeInterfaceMock
            );

        $this->assertInstanceOf(
            QuoteDeleterInterface::class,
            $this->persistentCartBusinessFactory->createQuoteDeleter()
        );
    }
}
