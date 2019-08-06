<?php

namespace FondOfSpryker\Zed\PersistentCart\Business\Model;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\PersistentCart\Business\Model\QuoteDeleter as SprykerQuoteDeleter;

class QuoteDeleter extends SprykerQuoteDeleter
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    protected function isQuoteDeleteAllowed(QuoteTransfer $quoteTransfer, CustomerTransfer $customerTransfer): bool
    {
        if (!$this->isDeleteAllowedForCustomer($quoteTransfer, $customerTransfer)) {
            $messageTransfer = new MessageTransfer();
            $messageTransfer->setValue(static::GLOSSARY_KEY_PERMISSION_FAILED);
            $this->messengerFacade->addErrorMessage($messageTransfer);

            return false;
        }

        return true;
    }
}
