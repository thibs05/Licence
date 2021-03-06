<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace Licence\Action\Base;

use Licence\Model\Map\LicenceTableMap;
use Licence\Event\LicenceEvent;
use Licence\Event\LicenceEvents;
use Licence\Model\LicenceQuery;
use Licence\Model\Licence;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\ToggleVisibilityEvent;
use Thelia\Core\Event\UpdatePositionEvent;
use Propel\Runtime\Propel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\TheliaEvents;
use \Thelia\Core\Event\TheliaFormEvent;

/**
 * Class LicenceAction
 * @package Licence\Action
 * @author TheliaStudio
 */
class LicenceAction extends BaseAction implements EventSubscriberInterface
{
    public function create(LicenceEvent $event)
    {
        $this->createOrUpdate($event, new Licence());
    }

    public function update(LicenceEvent $event)
    {
        $model = $this->getLicence($event);

        $this->createOrUpdate($event, $model);
    }

    public function delete(LicenceEvent $event)
    {
        $this->getLicence($event)->delete();
    }

    protected function createOrUpdate(LicenceEvent $event, Licence $model)
    {
        $con = Propel::getConnection(LicenceTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            if (null !== $id = $event->getId()) {
                $model->setId($id);
            }

            if (null !== $orderId = $event->getOrderId()) {
                $model->setOrderId($orderId);
            }

            if (null !== $customerId = $event->getCustomerId()) {
                $model->setCustomerId($customerId);
            }

            if (null !== $productId = $event->getProductId()) {
                $model->setProductId($productId);
            }

            if (null !== $productKey = $event->getProductKey()) {
                $model->setProductKey($productKey);
            }

            if (null !== $activeMachine = $event->getActiveMachine()) {
                $model->setActiveMachine($activeMachine);
            }

            if (null !== $expirationDate = $event->getExpirationDate()) {
                $model->setExpirationDate($expirationDate);
            }

            $model->save($con);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollback();

            throw $e;
        }

        $event->setLicence($model);
    }

    protected function getLicence(LicenceEvent $event)
    {
        $model = LicenceQuery::create()->findPk($event->getId());

        if (null === $model) {
            throw new \RuntimeException(sprintf(
                "The 'Licence' id '%d' doesn't exist",
                $event->getId()
            ));
        }

        return $model;
    }

    public function beforeCreateFormBuild(TheliaFormEvent $event)
    {
    }

    public function beforeUpdateFormBuild(TheliaFormEvent $event)
    {
    }

    public function afterCreateFormBuild(TheliaFormEvent $event)
    {
    }

    public function afterUpdateFormBuild(TheliaFormEvent $event)
    {
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            LicenceEvents::CREATE => array("create", 128),
            LicenceEvents::UPDATE => array("update", 128),
            LicenceEvents::DELETE => array("delete", 128),
            TheliaEvents::FORM_BEFORE_BUILD . ".Licence_create" => array("beforeCreateFormBuild", 128),
            TheliaEvents::FORM_BEFORE_BUILD . ".Licence_update" => array("beforeUpdateFormBuild", 128),
            TheliaEvents::FORM_AFTER_BUILD . ".Licence_create" => array("afterCreateFormBuild", 128),
            TheliaEvents::FORM_AFTER_BUILD . ".Licence_update" => array("afterUpdateFormBuild", 128),
        );
    }
}
