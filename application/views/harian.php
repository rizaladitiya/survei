<?php
$this->load->view('template/head');
date_default_timezone_set("Asia/Jakarta");
?>

<!--tambahkan custom css disini-->
<!-- iCheck -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/flat/blue.css') ?>" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.css') ?>" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css') ?>" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
 /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
} 
</style>
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?=$this->about_model->get_by_nama('program')->row()->value;?><small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Laporan</li>
        <li class="active">Harian</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  <form action="<?=base_url('admin/harian');?>" method="post">
  	<div class="nav-tabs-custom">
                  <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-pencil-square-o"></i>
                    <h3 class="box-title">Laporan Harian</h3>
                </div>
                <div class="box-body">
                        <div class="form-group">
                        <div class="row">
                       	  <div class="col-xs-3">
                        <label>Dari</label>
                    			<div class="input-group">
                     				<div class="input-group-addon">
                        				<i class="fa fa-calendar"></i>
                      				</div>
                      			<input name="datetime" type="text" class="form-control pull-right" id="datetime" value="<?=(isset($datetime))?$datetime:'';?>"/>
                    			</div>
                          </div>
    <div class="col-xs-3">
   	    <label>Hingga</label>
                           	<div class="input-group">
                            	<div class="input-group-addon">
                        				<i class="fa fa-calendar"></i>
               				  </div>
                         	    <input name="datetime2" type="text" class="form-control pull-right" id="datetime2" value="<?=(isset($datetime2))?$datetime2:'';?>"/>
           	      </div></div>
</div>
                        </div>
                </div>
                <div class="box-footer clearfix">
                  <button class="pull-left btn btn-default" id="sendEmail">Tampilkan                <i class="fa fa-search"></i></button>
                </div>
            </div>
                
          </form> 
       <?php if(!empty($survey)){
	  ?>
	  <div class="box box-primary">
	  <div class="box-header">
                    <i class="fa fa-pencil-square-o"></i>
                    <h3 class="box-title">Laporan Harian</h3>
                </div>
	  <div class="box-body table-responsive">
	  <button type="button" class="pull-left btn btn-default" onclick="selectElementContents(document.getElementById('laporan'));">Copy <i class="fa fa-copy"></i></button>
	  <a href="<?=base_url('export/harian/xlsx/'.$datetime."/".$datetime2);?>" class="pull-left btn btn-default">Excel <i class="fa fa-file-excel-o"></i></a>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center" id="laporan">
  <tr>
    <th>Tanggal</th>
    <th>Kel</th>
    <th>1</th>
    <th>2</th>
    <th>3</th>
    <th>4</th>
    <th>5</th>
    <th>6</th>
    <th>7</th>
    <th>8</th>
    <th>9</th>
    <th>Rata</th>
    <th>%</th>
    <th>P/TP</th>
	<th>Saran</th>
  </tr>
  <?php
		foreach($survey as $value){
			$persen=$this->data_model->get_by_average($value->id)->row()->avg/$this->jawaban_model->get_by_max()->row()->max*100;
			$kesimpulan=$this->data_model->get_kesimpulan($persen)->row()->value;
			
			?>
  <tr>
    <td><?=$value->datetime;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,1)->row()->jawaban;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,2)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,3)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,4)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,5)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,6)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,7)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,8)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,9)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_detail_id($value->id,10)->row()->bobot;?></td>
    <td><?=$this->data_model->get_by_average($value->id)->row()->avg;?></td>
    <td><?=$persen;?></td>
    <td><?=$kesimpulan;?></td>
	<td><?=getjawaban($this->data_model->get_by_detail_id($value->id,11)->row());?></td>
  </tr>
  <?php 
  	}
	?>
 
	</table>
  </div>
  </div>
  <?php } ?>
	</div>
  </div> 
  
  
</section><!-- /.content -->


<?php
$this->load->view('template/js');
?>

<!--tambahkan custom js disini-->
<!-- jQuery UI 1.11.2 -->
<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('assets/js/raphael-min.js') ?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.min.js') ?>" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/sparkline/jquery.sparkline.min.js') ?>" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/knob/jquery.knob.js') ?>" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker.js') ?>" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.js') ?>" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
	$('#datetime,#datetime2').datepicker({
      		autoclose: true,
			format: 'yyyy-mm-dd'
    });
	$("#laporan").dataTable();
});
</script>


<?php
$this->load->view('template/foot');
?>