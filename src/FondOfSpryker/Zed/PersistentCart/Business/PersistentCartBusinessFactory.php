<?php

namespace FondOfSpryker\Zed\PersistentCart\Business;

use FondOfSpryker\Zed\PersistentCart\Business\Model\QuoteDeleter;
use Spryker\Zed\PersistentCart\Business\Model\QuoteDeleterInterface;
use Spryker\Zed\PersistentCart\Business\PersistentCartBusinessFactory as SprykerPersistentCartBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\PersistentCart\PersistentCartConfig getConfig()
 */
class PersistentCartBusinessFactory extends SprykerPersistentCartBusinessFactory
{
    /**
     * @return \Spryker\Zed\PersistentCart\Business\Model\QuoteDeleterInterface
     */
    public function createQuoteDeleter(): QuoteDeleterInterface
    {
        return new QuoteDeleter(
            $this->getQuoteFacade(),
            $this->createQuoteResponseExpander(),
            $this->getMessengerFacade()
        );
    }
}
