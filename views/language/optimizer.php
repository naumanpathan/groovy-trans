<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */

/* @var $this \yii\web\View */
/* @var $newDataProvider \yii\data\ArrayDataProvider */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('language', 'Optimise database');
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
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <rect fill="#000000" opacity="0.3" x="12" y="7" width="10" height="2" rx="1"/>
                                    <path d="M2,9 C1.44771525,9 1,8.55228475 1,8 C1,7.44771525 1.44771525,7 2,7 L7.35012691,7 C8.14050434,7 8.85674733,7.46546704 9.17775001,8.18772307 L12.6498731,16 L22,16 C22.5522847,16 23,16.4477153 23,17 C23,17.5522847 22.5522847,18 22,18 L12.6498731,18 C11.8594957,18 11.1432527,17.534533 10.82225,16.8122769 L7.35012691,9 L2,9 Z" fill="#000000" fill-rule="nonzero"/>
                                </g>
                            </svg>
                            <h3 class="kt-portlet__head-title"> &nbsp; Optimizer </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <a href="<?= Url::to(['list'], $schema = true)?>" class="btn btn-clean btn-icon-sm">
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
                                    <div id="w2-info" class="alert-info alert fade in">
                                        <?= Yii::t('language', '{n, plural, =0{No entries} =1{One entry} other{# entries}} were removed!', ['n' => $newDataProvider->totalCount]) ?>
                                    </div>

                                    <?= $this->render('__scanNew', [
                                        'newDataProvider' => $newDataProvider,
                                    ]) ?>

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