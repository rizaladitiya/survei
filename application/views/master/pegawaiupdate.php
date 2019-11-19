<?php
$this->load->view('template/head');
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
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />

<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');



?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <small>Master </small>
        Pegawai
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Master</li>
        <li class="active">Pegawai</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<form action="<?=base_url('master/pegawaisave');?>" method="post" id="formcuti">
 <section class="col-lg-7 connectedSortable">
        <div class="alert alert-success" id="success-alert" style="display:none">
    		<button type="button" class="close" data-dismiss="alert">x</button>
    		Data Berhasil Disimpan.
		</div>
        <div class="alert alert-danger" id="alert-danger" style="display:none">
    		<button type="button" class="close" data-dismiss="alert">x</button>
    		Data Gagal Disimpan, hubungi Administrator.
		</div>
        
        <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <div class="tab-content no-padding">
                    <!-- Morris chart - Sales -->
                  <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-pencil-square-o"></i>
                    <h3 class="box-title">Pegawai</h3>
                </div>
                
                <div class="box-body">
                  <div class="form-group">
                        <div class="row">
                      		<div class="col-xs-4">
                            <label>Nama</label>
                    			<div class="input-group">
                    			  <input name="nama" type="text" class="form-control pull-right" id="nama" value="<?=(isset($pegawai->nama))?$pegawai->nama:'';?>"/>
                    			</div>
                       		</div>
                            <div class="col-xs-4">
                            <label>NRP</label>
                      		  <div class="input-group">
                      		    <input name="nrp" type="text" class="form-control pull-right" id="nrp" value="<?=(isset($pegawai->nrp))?$pegawai->nrp:'';?>"/>
                      		  </div>
                       		</div>
                            <div class="col-xs-4">
                            <label>HP</label>
                      		  <div class="input-group">
                      		    <input name="hp" type="text" class="form-control pull-right" id="hp" value="<?=(isset($pegawai->hp))?$pegawai->hp:'';?>"/>
                      		  </div>
                       		</div>
                    </div>
                    <div class="row">
                    <div class="col-xs-4">
                    <label>Pangkat</label>
                      		  <div class="input-group">
                      		    <input name="pangkat" type="text" class="form-control pull-right" id="pangkat" value="<?=(isset($pegawai->pangkat))?$pegawai->pangkat:'';?>"/>
                      		  </div>
               		  </div>
                      <div class="col-xs-4">
                      <label>Jabatan</label>
                      		  <div class="input-group">
                      		    <input name="jabatan" type="text" class="form-control pull-right" id="jabatan" value="<?=(isset($pegawai->jabatan))?$pegawai->jabatan:'';?>"/>
                      		  </div>
               		  </div>
                         </div>
                    <div class="row">
                    <div class="col-xs-4">
                    <label>Kesatuan</label>
                      		  <div class="input-group">
                      		    <input name="kesatuan" type="text" class="form-control pull-right" id="kesatuan" value="<?=(isset($pegawai->kesatuan))?$pegawai->kesatuan:'';?>"/>
                      		  </div>
               		  </div>
                        <div class="col-xs-4">
                        <label>Gelar</label>
                                  <div class="input-group">
                                    <input name="gelar" type="text" class="form-control pull-right" id="gelar" value="<?=(isset($pegawai->gelar))?$pegawai->gelar:'';?>"/>
                          </div>
                      </div>
                    </div>
                  </div>
                       <!-- Loading (remove the following to stop the loading)-->
            <div class="overlay" style="display:none">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- end loading -->
                </div>
                <div class="box-footer clearfix">
                    <button class="pull-right btn btn-default" id="sendEmail">Simpan <i class="fa fa-save"></i></button>
                    <input name="id" type="hidden" id="id" value="<?=(isset($pegawai->id))?$pegawai->id:0;?>" />
                </div>
            </div>
                </div>
                
       
            </div><!-- /.nav-tabs-custom -->


			<!-- /.box -->
            <!-- TO DO List --><!-- /.box -->

            <!-- quick email widget -->
          
</form>
        </section>
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
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>



<script type="text/javascript">
$(function () {
		$(document).ready(function() {
		});
});
</script>
<?php
$this->load->view('template/foot');
?>