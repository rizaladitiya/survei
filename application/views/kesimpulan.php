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
        <li class="active">Kesimpulan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  <form action="<?=base_url('admin/kesimpulan');?>" method="post">
  	<div class="nav-tabs-custom">
                  <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-pencil-square-o"></i>
                    <h3 class="box-title">Laporan Kesimpulan</h3>
                </div>
                <div class="box-body">
                        <div class="form-group">
                        <div class="row">
                       	  <div class="col-xs-3">
                        <label>Bulan</label>
                    			<div class="input-group">
                     				<div class="input-group-addon">
                        				<i class="fa fa-calendar"></i>
                      				</div>
                      			<input name="datetime" type="text" class="form-control pull-right" id="datetime" value="<?=(isset($datetime))?$datetime:'';?>"/>
                    			</div>
                          </div>
    
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
                    <h3 class="box-title">Laporan Kesimpulan</h3>
                </div>
	  <div class="box-body table-responsive">
	  <button type="button" class="pull-left btn btn-default" onclick="selectElementContents(document.getElementById('laporan'));">Copy <i class="fa fa-copy"></i></button>
      <a href="<?=base_url('export/kesimpulan/xlsx/'.$datetime);?>" class="pull-left btn btn-default">Excel <i class="fa fa-file-excel-o"></i></a>
      <?php 
	  $datetime = date('Y-m-01',strtotime($datetime));
	  ?>
            <table width="200" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-hover" id="laporan">
  <tr>
    <th>No</th>
    <th>Ruang Lingkup</th>
    <th>Nilai</th>
    <th>Kategori</th>
  </tr>
  <?php 
  $no=1;
  	foreach($survey as $value){
  ?>
  <tr>
    <td><?=$no;?></td>
    <td><?=$value->ruang_lingkup;?></td>
    <td><?=round($this->data_model->get_by_kesimpulan($value->id,$datetime)->row()->rata,3);?></td>
    <td><?=$this->data_model->get_kesimpulan_rata($this->data_model->get_by_kesimpulan($value->id,$datetime)->row()->rata)->row()->value2;?></td>
  </tr>
  <?php 
  $no++;
  } ?>
</table>

  </div>
  </div>
  <?php
	   }
	   ?>
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
	$('#datetime').datepicker({
      		autoclose: true,
			format: 'yyyy-mm',
			minViewMode: 1
    });
	$("#laporan").dataTable();
});
</script>


<?php
$this->load->view('template/foot');
?>