<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TopicAll;
use app\models\Cchangwat;
use app\models\Campur;
use app\models\Chospital2;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'KPI ระดับสถานบริการ';
$this->params['breadcrumbs'][] = $this->title;
$topic = TopicAll::find()->where(['id' => $kpi_id])->asArray()->one();
?>
<div class="kpi-type1-index">

    <h4><?= Html::encode("ตัวชี้วัด : " . $kpi_id . "-" . $topic['topic']) ?></h4>
   <?php
        $feq= $topic['frequency'];
      ?>
    <p>
        <?= Html::a('<i class="fa fa-undo"></i>', ['moph/index'], ['class' => 'btn btn-flat btn-warning']) ?>
        <?= Html::a('เพิ่มข้อมูล', ['create', 'rep_year' => $rep_year, 'kpi_id' => $kpi_id,'feq'=>$feq], ['class' => 'btn btn-success', ['rep_year' => '2333']]) ?>
    </p>

    <?=
      \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
         'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '0'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'kpi_id',
                'label' => 'รหัส Kpi'
            ],
            [
                'attribute' => 'rep_year',
                'label' => 'ปีงบประมาณ',
                'value'=>  function ($model){
                    return $model->rep_year+543;
                }
            ],
            [
                'attribute' => 'hospcode',
                'label' => 'สถานบริการ',
                'value'=>  function ($model){
                    $hospcode = $model->hospcode;
                    $hos = Chospital2::find()->where(['hospcode'=>$hospcode])->one();
                    return $hospcode."-".$hos->hosname;
                }
            ],
            [
                'attribute' => 'provcode',
                'label' => 'จังหวัด',
                'value'=>  function ($model){
                    $provcode=$model->provcode;
                    $prov=Cchangwat::find()->where(['provcode'=>$provcode])->one();
                    return $provcode."-".$prov->provname;
                }
            ],
            [
                'attribute' => 'ampcode',
                'label' => 'อำเภอ',
                 'value'=>  function ($model){
                    $provcode=$model->provcode;
                    $ampcode = $model->ampcode;
                    $amp=  Campur::find()->where(['provcode'=>$provcode,'ampcode'=>$ampcode])->one();
                    return $ampcode."-".$amp->ampname;
                }
            ],
            [
                'attribute' => 'target',
                'label' => 'เป้าหมาย'
            ],
            [
                'attribute' => 'total',
                'label' => 'ผลงาน'
            ],
            'ratio',
              ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>


