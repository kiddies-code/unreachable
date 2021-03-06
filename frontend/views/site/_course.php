
<?php
// use yii\helpers\Html;
use yii\bootstrap\Html;

$formatter = \Yii::$app->formatter;
?>

<div class="col-md-12" >
  <div class="panel panel-default" style="border-radius:0px;">
    <div class="panel-body" >
      <div>
      <div class="col-md-3">
        <img class="img-square" src="<?= Yii::$app->urlManagerBackend->baseUrl ?><?= '/'.$model->image ?>" alt="test" width="100%" height='50%' style="box-shadow: 0px 0px 3px grey;" >
      </div>
      <div class="col-md-9">
        <h4 align='left' style="margin: 10px 0px 0px 0px;" ><?= Html::a($model->nama_course,['site/viewcourse','ID' => $model->ID]) ?></h4><hr style="margin:5px 0px 10px 0px;">
        <p><?= $model->prev; ?></p><br></div>
    </div>
      <div class="text-right">
        <div class="label label-danger" style="font-size:13px;"><span class="glyphicon glyphicon-exclamation-sign"></span>
        <?php
        echo $formatter->asDate($model->tanggal_tutup, 'long');
      //     if($model->tanggal_pelaksanaan == $model->tanggal_berakhir){
      //   echo $formatter->asDate($model->tanggal_pelaksanaan, 'long');
      // }else{
      //   echo $formatter->asDate($model->tanggal_pelaksanaan, 'long').' - '.$formatter->asDate($model->tanggal_berakhir, 'long');;
      // }
             ?>
      </div>
    &nbsp;
      <div class="label label-primary" style="font-size:13px;">
        <span class="glyphicon glyphicon-user"></span>
        <?php
          if($model->jumlah_max != '99999'){
            echo $model->jumlah_max.' Orang';
          }else{
            echo 'Unlimited';
          }
         ?>
      </div>
    &nbsp;
      <div class="label label-success" style="font-size:13px;">
        <span class="glyphicon glyphicon-tag"></span>&nbsp;
        <?php
          if($model->bayar == 'Y' && $model->harga > 0){
            echo 'Rp.'.$model->harga;
          }else{
            echo 'Free';
          }
         ?>
      </div>
      </div>
    </div>
  </div>
</div>
