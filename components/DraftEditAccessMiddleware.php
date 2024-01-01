<?php

namespace app\components;

use app\models\Purchases;
use Yii;
use yii\base\Behavior;
use yii\base\Controller;

class DraftEditAccessMiddleware extends Behavior
{
    public $only = [];

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        $requestId = Yii::$app->request->get('id');
        $purchases = Purchases::findOne($requestId);
        $action = $event->action->id;

        if (in_array($action, $this->only)) {
            if (
                ($purchases->status_id === Purchases::STATUS_DRAFT && $purchases->user_id !== Yii::$app->user->identity->getId()) ||
                $action === "update" && $purchases->status_id === Purchases::STATUS_ACTIVE
            ) {
                Yii::$app->session->setFlash('error', 'У вас нет доступа.');
                $this->owner->redirect(['/site/error']);
            }
        }
    }
}
