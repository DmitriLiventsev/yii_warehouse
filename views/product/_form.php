<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories app\models\Category[] */

$this->registerJsFile("/assets/js/product.js");

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'product_form', 'data-method' => $model->isNewRecord ? 'POST' : 'POST']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_ids')->dropDownList($categories, ['multiple' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div id="imagePreview">

    </div>

    <?php if($model->getImageUrl() !== null):?>
        <img  id="productImage" src="<?= $model->getImageUrl()?>" />
    <?php endif;?>

    <?= $form->field($model, 'picture')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
