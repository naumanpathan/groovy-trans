<?php

/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use lajax\translatemanager\helpers\Language;
use lajax\translatemanager\models\Language as Lang;

/* @var $this \yii\web\View */
/* @var $language_id string */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel lajax\translatemanager\models\searches\LanguageSourceSearch */
/* @var $searchEmptyCommand string */

$this->title = Yii::t('language', 'Translation into {language_id}', ['language_id' => $language_id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('language', 'Languages'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-grid--stretch">
    <div class="kt-container kt-body  kt-grid kt-grid--ver" id="kt_body">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
            <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title"><?= Html::encode($this->title) ?></h3>
                    <h4 class="kt-subheader__desc">
                    <div class="kt-subheader__breadcrumbs">		
                        <?php                                            
                        echo Breadcrumbs::widget([
                            'tag'=>false,
                            'itemTemplate' => '{link} <span class="kt-subheader__breadcrumbs-separator"></span>',
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]);
                        ?>										
                    </div>
                    </h4>
                </div>
            </div>

            <div class="kt-content kt-grid__item kt-grid__item--fluid">
                
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                </g>
                            </svg>
                            <h3 class="kt-portlet__head-title"> &nbsp; Translation </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <a href="<?= Url::toRoute(['list'], $schema = true)?>" class="btn btn-clean btn-icon-sm">
                                    <i class="la la-long-arrow-left"></i>
                                    Back To Language List
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                <?= Html::hiddenInput('language_id', $language_id, ['id' => 'language_id', 'data-url' => Yii::$app->urlManager->createUrl('/translatemanager/language/save')]); ?>
                                    <div id="translates" class="<?= $language_id ?>">
                                        <?php
                                        Pjax::begin([
                                            'id' => 'translates',
                                        ]);
                                        $form = ActiveForm::begin([
                                            'method' => 'get',
                                            'id' => 'search-form',
                                            'enableAjaxValidation' => false,
                                            'enableClientValidation' => false,
                                        ]);
                                        echo $form->field($searchModel, 'source')->dropDownList(['' => Yii::t('language', 'Original')] + Lang::getLanguageNames(true))->label(Yii::t('language', 'Source language'));
                                        ActiveForm::end();
                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'pager' => ['prevPageCssClass' => 'previous'],
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'format' => 'raw',
                                                    'filter' => Language::getCategories(),
                                                    'attribute' => 'category',
                                                    'filterInputOptions' => ['class' => 'form-control', 'id' => 'category'],
                                                ],
                                                [
                                                    'format' => 'raw',
                                                    'attribute' => 'message',
                                                    'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                                                    'label' => Yii::t('language', 'Source'),
                                                    'content' => function ($data) {
                                                        return Html::textarea('LanguageSource[' . $data->id . ']', $data->source, ['class' => 'form-control source', 'readonly' => 'readonly']);
                                                    },
                                                ],
                                                [
                                                    'format' => 'raw',
                                                    'attribute' => 'translation',
                                                    'filterInputOptions' => [
                                                        'class' => 'form-control',
                                                        'id' => 'translation',
                                                        'placeholder' => $searchEmptyCommand ? Yii::t('language', 'Enter "{command}" to search for empty translations.', ['command' => $searchEmptyCommand]) : '',
                                                    ],
                                                    'label' => Yii::t('language', 'Translation'),
                                                    'content' => function ($data) {
                                                        return Html::textarea('LanguageTranslate[' . $data->id . ']', $data->translation, ['class' => 'form-control translation', 'data-id' => $data->id, 'tabindex' => $data->id]);
                                                    },
                                                ],
                                                [
                                                    'format' => 'raw',
                                                    'label' => Yii::t('language', 'Action'),
                                                    'content' => function ($data) {
                                                        return Html::button(Yii::t('language', 'Save'), ['type' => 'button', 'data-id' => $data->id, 'class' => 'btn btn-success']);
                                                    },
                                                ],
                                            ],
                                        ]);
                                        Pjax::end();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>