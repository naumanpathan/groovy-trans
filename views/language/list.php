<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use lajax\translatemanager\models\Language;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel lajax\translatemanager\models\searches\LanguageSearch */

$this->title = Yii::t('language', 'List of languages');
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
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <path d="M0.18,19 L7.1,4.64 L14.02,19 L12.06,19 L10.3,15.28 L3.9,15.28 L2.14,19 L0.18,19 Z M7.1,8.52 L4.7,13.6 L9.5,13.6 L7.1,8.52 Z" fill="#000000"></path>
                                    <path d="M21.34,19 L21.34,18 C20.5,18.76 19.38,19.16 18.16,19.16 C15.22,19.16 13.06,16.9 13.06,14 C13.06,11.1 15.22,8.84 18.16,8.84 C19.38,8.84 20.5,9.24 21.34,10 L21.34,9 L23.06,9 L23.06,19 L21.34,19 Z M18.2,17.54 C19.64,17.54 20.76,16.86 21.34,15.92 L21.34,12.08 C20.76,11.14 19.64,10.46 18.2,10.46 C16.24,10.46 14.84,12.02 14.84,14 C14.84,15.98 16.24,17.54 18.2,17.54 Z" fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <h3 class="kt-portlet__head-title"> &nbsp; Launguage List </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <div class="dropdown dropdown-inline">
                                    <a href = "<?= Url::toRoute(['scan'], $schema = true)?>" class="btn btn-outline-brand btn-icon-sm">
                                        <i class="flaticon-eye"></i> Scan aunguage
                                    </a> &nbsp;
                                    <a href = "<?= Url::toRoute(['optimizer'], $schema = true)?>" class="btn btn-outline-brand btn-icon-sm">
                                        <i class="flaticon-eye"></i> Optimizer List
                                    </a> &nbsp;
                                    <a href = "<?= Url::toRoute(['create'], $schema = true)?>" class="btn btn-brand btn-icon-sm">
                                        <i class="flaticon2-plus"></i> Add New Launguage
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <!--begin: Datatable -->
                        <div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    Pjax::begin([ 'id' => 'languages', ]);
                                    echo GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'pager' => ['prevPageCssClass' => 'previous'],
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            'language_id',
                                            'name_ascii',
                                            [
                                                'format' => 'raw',
                                                'filter' => Language::getStatusNames(),
                                                'attribute' => 'status',
                                                'filterInputOptions' => ['class' => 'form-control', 'id' => 'status'],
                                                'label' => Yii::t('language', 'Status'),
                                                'content' => function ($language) {
                                                    return Html::activeDropDownList($language, 'status', Language::getStatusNames(), ['class' => 'status form-control', 'id' => $language->language_id, 'data-url' => Yii::$app->urlManager->createUrl('/translatemanager/language/change-status')]);
                                                },
                                            ],
                                            [
                                                'format' => 'raw',
                                                'attribute' => Yii::t('language', 'Statistic'),
                                                'content' => function ($language) {
                                                    return '<span class="statistic"><span style="width:' . $language->gridStatistic . '%"></span><i>' . $language->gridStatistic . '%</i></span>';
                                                },
                                            ],
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{translate} {view} {update} {delete}',
                                                'header'=>'Action',
                                                'buttons' => [
                                                    'translate' => function ($url, $model, $key) {
                                                        return Html::a('Translate', ['language/translate', 'language_id' => $model->language_id], [
                                                            'title' => Yii::t('language', 'Translate'),'class'=>'btn btn-success margin-right-5',
                                                            'data-pjax' => '0',
                                                        ]);
                                                    },
                                                    'view'=>function ($url) {
                                                        return Html::a('<i class="fa fa-eye padding-right-0"></i>', $url, ['class'=>'btn btn-primary margin-right-5']);
                                                    },
                                                    'update'=>function ($url) {
                                                        return Html::a('<i class="fa fa-pencil-alt padding-right-0"></i>', $url, ['class'=>'btn btn-info margin-right-5']);
                                                    },
                                                    'delete' => function($url, $model) {
                                                        return Html::a('<i class="fa fa-trash padding-right-0"></i>', ['delete', 'id' => $model->language_id], ['title' => 'Delete', 'class' => 'btn btn-danger', 'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.', 'method' => 'post', 'data-pjax' => false],]);
                                                    }
                                                ],
                                            ],
                                        ],
                                    ]);
                                    Pjax::end();
                                    ?>

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