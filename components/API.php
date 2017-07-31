<?php
/**
 * Created by IntelliJ IDEA.
 * User: User
 * Date: 09.01.2017
 * Time: 16:45
 */

namespace andyharis\yii2apigql\components;

use yii\web\Controller;
use yii\web\Response;

class API extends Controller
{
  public $enableCsrfValidation = false;
  public $authIndex = 'Auth';
  public $allowedActions = [];

  public function beforeAction($action)
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
    ini_set('memory_limit', '1024M');
    header('Access-Control-Allow-Origin: *');
//    $req = \Yii::$app->request;
//    if (!isset($_GET['ZADMINA']) && $action->id != 'pdf') {
//      if (!isset($req->headers['Authorization'])) {
//        throw new ForbiddenHttpException('You need to provide Basic auth token to get access.');
//      }
//      $token = str_replace('Basic: ', '', $req->headers['Authorization']);
//      if (!SecUser::getAccess($token)) {
//        throw new ForbiddenHttpException('The token you provided has exceed or wrong.');
//      }
//      \Yii::$app->user->login(SecUser::findIdentityByAccessToken($token));
//    }
//    \Yii::$app->user->login(SecUser::findIdentityByAccessToken(SecUser::findOne(['iID' => 1004])->auth_token));
    return parent::beforeAction($action); // TODO: Change the autogenerated stub
  }

  public function behaviors()
  {
    return [
      'corsFilter' => [
        'class' => \yii\filters\Cors::className(),
      ],
    ];
  }
}