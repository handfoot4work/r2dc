<?php

namespace app\controllers;

use yii;
use yii\data\ArrayDataProvider;

class ProvinceController extends \yii\web\Controller {

    public function actionIndex() {
        $year='2015';
        $connection = Yii::$app->db;
        $sql = "";
        $row = $connection->createCommand('SELECT id,topic FROM topic_province')
                ->queryAll();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $row,
            'pagination' => [
                'pageSize' => 2,
            ]
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    
    public function actionChangwat() {
        $year=date('Y');
        $percent[]=0;
        $changwatname[]='';
        $work[]=0;
        $a=0;
        $id1=$_GET['id'];
         if (isset($_POST['year'])) {
             $year=$_POST['year'];
              //$id1=$_GET['id'];
         }
        //echo  $id1.'dd';
        $connection = Yii::$app->db;
        $sql = "SELECT kpi_id,rep_year+543 AS rep_year,provcode,CONCAT(provcode,ampcode) AS prov,ch.changwatname,hospcode,provcode,ampcode,target,
total,round(sum(total)*100/sum(target),2) AS ratio,
SUM(mon1) AS mon1,SUM(mon2) AS mon2,SUM(mon3) AS mon3,SUM(mon4) AS mon4,
SUM(mon5) AS mon5,SUM(mon6) AS mon6,SUM(mon7) AS mon7,SUM(mon8) AS mon8,
SUM(mon9) AS mon9,SUM(mon10) AS mon10,SUM(mon11) AS mon11,SUM(mon12) AS mon12,
(mon1+mon2+mon3) AS t1,
(mon4+mon5+mon6) AS t2,
(mon7+mon8+mon9) AS t3,
(mon10+mon11+mon12) AS t4
FROM  kpi_province r
INNER JOIN cchangwat ch ON ch.changwatcode=provcode
WHERE rep_year= '$year'  and kpi_id='$id1'
GROUP BY  provcode ";
        
         

       
        
        $data = $connection->createCommand($sql)
                ->queryAll();
        
         for ($i = 0; $i < sizeof($data); $i++) {
            $percent[] = $data[$i]['ratio']*1;
            $changwatname[] = $data[$i]['changwatname'];
            $work[] = $data[$i]['total'];
            $a=1;
            
        }
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            /*'pagination' => [
                'pageSize' => 2,
            ]*/
        ]);
        return $this->render('changwat', ['dataProvider' => $dataProvider,
                            'percent'=>$percent,
                            'changwatname'=>$changwatname,
                            'work'=>$work,
                            'a'=>$a,
                            ]);
    }
    
    public function actionAmpur() {
        if(isset($_GET['year'])){
            $year=$_GET['year']-543;
            $chw=$_GET['chw'];
            $id=$_GET['id'];
            
        }
        
        $connection = Yii::$app->db;
        $sql = "SELECT kpi_id,rep_year+543 AS rep_year,provcode,CONCAT(provcode,ampcode) AS prov,a.ampurname,hospcode,provcode,ampcode,target,
total,round(sum(total)*100/sum(target),2) AS ratio,
SUM(mon1) AS mon1,SUM(mon2) AS mon2,SUM(mon3) AS mon3,SUM(mon4) AS mon4,
SUM(mon5) AS mon5,SUM(mon6) AS mon6,SUM(mon7) AS mon7,SUM(mon8) AS mon8,
SUM(mon9) AS mon9,SUM(mon10) AS mon10,SUM(mon11) AS mon11,SUM(mon12) AS mon12
FROM  kpi_province r
INNER JOIN campur a ON a.ampurcodefull=CONCAT(r.provcode,r.ampcode)
WHERE rep_year = '$year'  and kpi_id='$id' AND provcode='$chw'
GROUP BY  provcode,ampcode";
        
        
        $row = $connection->createCommand($sql)
                ->queryAll();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $row,
            /*'pagination' => [
                'pageSize' => 2,
            ]*/
        ]);
        return $this->render('ampur', ['dataProvider' => $dataProvider ]);
    }
    
    
    public function actionHospital() {
        $id=$_GET['id'];
        if(isset($_GET['year'])){
            $year=$_GET['year']-543;
            $chw=$_GET['chw'];
            $amp=$_GET['amp'];
             
        }
        
        $connection = Yii::$app->db;
        $sql = "SELECT kpi_id,rep_year+543 AS rep_year,r.provcode,CONCAT(r.provcode,ampcode) AS prov,ch.hosname,hospcode,ampcode,target,
total,round(sum(total)*100/sum(target),2) AS ratio,
SUM(mon1) AS mon1,SUM(mon2) AS mon2,SUM(mon3) AS mon3,SUM(mon4) AS mon4,
SUM(mon5) AS mon5,SUM(mon6) AS mon6,SUM(mon7) AS mon7,SUM(mon8) AS mon8,
SUM(mon9) AS mon9,SUM(mon10) AS mon10,SUM(mon11) AS mon11,SUM(mon12) AS mon12
FROM  kpi_province r
INNER JOIN chospital2 ch ON ch.hoscode=r.hospcode
WHERE rep_year = '$year'  and kpi_id='$id' AND r.provcode='$chw' AND ampcode='$amp'
GROUP BY  r.provcode,ampcode,hospcode  ";
        $row = $connection->createCommand($sql)
                ->queryAll();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $row,
            /*'pagination' => [
                'pageSize' => 2,
            ]*/
        ]);
        return $this->render('hospital', ['dataProvider' => $dataProvider]);
    }

}