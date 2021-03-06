<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserIdentity */

$this->title = 'Create User Identity';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-identity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
