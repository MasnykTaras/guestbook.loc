<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if(!Yii::$app->user->isGuest):?>
    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            'created',
            'homepage',
            'text:ntext',
            'user_ip',
            'user_brouser',
             [
                'label' => 'File',
                'format' => 'raw',
                'value' => function($model){
                    $view = '';
                   
                    if(pathinfo($model->file)['extension'] == 'txt'){
                        $view = Html::a($model->file, '/upload/'. $model->file,  ['target'=>'_blank']);
                    }else{
                         $view = Html::img('/upload/'. $model->file, ['width' => '60px']);
                    }
                    
                     return $view;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                 'visibleButtons' => [
                   'delete' => Yii::$app->user->can('createTask'),
                   'update' => Yii::$app->user->can('createTask'),
                ]
            ],
        ],
    ]); ?>
</div>
