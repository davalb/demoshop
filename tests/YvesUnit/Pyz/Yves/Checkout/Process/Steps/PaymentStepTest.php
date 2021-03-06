<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace YvesUnit\Pyz\Yves\Checkout\Process\Steps;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit_Framework_TestCase;
use Pyz\Yves\Checkout\Process\Steps\PaymentStep;
use Spryker\Yves\Messenger\FlashMessenger\FlashMessengerInterface;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @group YvesUnit
 * @group Pyz
 * @group Yves
 * @group Checkout
 * @group Process
 * @group Steps
 * @group PaymentStepTest
 */
class PaymentStepTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testExecuteShouldSelectPlugin()
    {
        $paymentPluginMock = $this->createPaymentPluginMock();
        $paymentPluginMock->expects($this->once())->method('addToDataClass');

        $paymentStepHandler = new StepHandlerPluginCollection();
        $paymentStepHandler->add($paymentPluginMock, 'test');
        $paymentStep = $this->createPaymentStep($paymentStepHandler);

        $quoteTransfer = new QuoteTransfer();

        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer->setPaymentSelection('test');
        $quoteTransfer->setPayment($paymentTransfer);

        $paymentStep->execute($this->createRequest(), $quoteTransfer);
    }

    /**
     * @return void
     */
    public function testPostConditionsShouldReturnTrueWhenPaymentSet()
    {
        $quoteTransfer = new QuoteTransfer();
        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer->setPaymentProvider('test');
        $quoteTransfer->setPayment($paymentTransfer);

        $paymentStep = $this->createPaymentStep(new StepHandlerPluginCollection());

        $this->assertTrue($paymentStep->postCondition($quoteTransfer));
    }


    /**
     * @return void
     */
    public function testShipmentRequireInputShouldReturnTrue()
    {
        $paymentStep = $this->createPaymentStep(new StepHandlerPluginCollection());
        $this->assertTrue($paymentStep->requireInput(new QuoteTransfer()));
    }

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection $paymentPlugins
     *
     * @return \Pyz\Yves\Checkout\Process\Steps\PaymentStep
     */
    protected function createPaymentStep(StepHandlerPluginCollection $paymentPlugins)
    {
        return new PaymentStep(
            $paymentPlugins,
            'payment',
            'escape_route',
            $this->getFlashMessengerMock()
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequest()
    {
        return Request::createFromGlobals();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface
     */
    protected function createPaymentPluginMock()
    {
        return $this->getMock(StepHandlerPluginInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Yves\Messenger\FlashMessenger\FlashMessengerInterface
     */
    protected function getFlashMessengerMock()
    {
        return $this->getMock(FlashMessengerInterface::class);
    }

}
