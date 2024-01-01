<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class MultipleModel
{
    /**
     * Return merged model
     *
     * @param $modelClass
     * @param $field
     * @param array $multipleModels
     *
     * @return array
     */
    public static function createMultiple($modelClass, $field, $multipleModels = [], $data = [])
    {

        $model = new $modelClass();
        $formName = $model->formName();

        if(!empty($data) && isset($data[$formName])) {
            $post =  $data[$formName];
        } else {
            if(is_string(Yii::$app->request->post($formName))) {
                $post = json_decode(Yii::$app->request->post($formName), true);
            } else {
                $post = Yii::$app->request->post($formName);
            }
        }



        $models = [];

        if (!empty($multipleModels)) {
            $keys = [];

            foreach ($multipleModels as $multipleModel) {
                $keys[] = $multipleModel->$field;
            }
            $multipleModels = \array_combine($keys, $multipleModels);
        }

        if ($post && \is_array($post)) {
            foreach ($post as $i => $item) {

                if (isset($item[$field]) && !empty($item[$field]) && isset($multipleModels[$item[$field]])) {
                    $models[$i] = $multipleModels[$item[$field]];
                } else {
                    $models[$i] = new $modelClass();
                }
            }
        }


        unset($model, $formName, $post);

        return $models;
    }
    public static function updateMultiple($modelClass, $multipleModels = [])
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }


}
