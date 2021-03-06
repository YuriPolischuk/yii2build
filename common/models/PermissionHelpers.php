<?php

namespace common\models;

use yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\ValueHelpers;

Class PermissionHelpers
{
     static function userMustBeOwner($model_name, $model_id)
    {
        $connection = \Yii::$app->db;
        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_name WHERE user_id=:userid AND id=:model_id";
        $command = $connection->createCommand($sql);
        $command->bindValue(":userid", $userid);
        $command->bindValue(":model_id", $model_id);
        if($result = $command->queryOne()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * method for requiring paid type user, if test fails, redirect to upgrade page
     * $user_type_name handed in as 'string', 'Paid' for example.
     *
     * used two lines for if statement to avoid word wrapping
     *
     * @param mixed $user_type_name
     * @return \yii\web\Response
    115Chapter Six: Helpers
     */
    public static function requireUpgradeTo($user_type_name)
    {
        if ( Yii::$app->user->identity->user_type_id !=
            ValueHelpers::getUserTypeValue($user_type_name)) {
            return Yii::$app->getResponse()->redirect(Url::to(['upgrade/index']));
        }
    }
    /**
     * @requireStatus
     * used two lines for if statement to avoid word wrapping
     * @param mixed $status_name
     */
    public static function requireStatus($status_name)
    {
        if ( Yii::$app->user->identity->status_id ==
            ValueHelpers::getStatusValue($status_name)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @requireMinimumStatus
     * used two lines for if statement to avoid word wrapping
    116Chapter Six: Helpers
     * @param mixed $status_name
     */
    public static function requireMinimumStatus($status_name)
    {
        if ( Yii::$app->user->identity->status_id >=
            ValueHelpers::getStatusValue($status_name)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @requireRole
     * used two lines for if statement to avoid word wrapping
     * @param mixed $role_name
     */
    public static function requireRole($role_name)
    {
        if ( Yii::$app->user->identity->role_id ==
            ValueHelpers::getRoleValue($role_name)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @requireMinimumRole
     * used two lines for if statement to avoid word wrapping
     * @param mixed $role_name
     */
    public static function requireMinimumRole($role_name)
    {
        if ( Yii::$app->user->identity->role_id >= ValueHelpers::getRoleValue($role_name)) {
            return true;
        } else {
            return false;
        }
    }
}