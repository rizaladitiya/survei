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
        <small>Master </small>Pegawai </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Master</li>
        <li class="active">Pegawai </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
 <div class="panel panel-default">
		<div class="panel-body">
			<div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">

                  <div class="input-group-btn">
                  <form action="<?=base_url('master/pegawaiupdate');?>" method="post" id="formpegawai">
                    <button type="submit" class="btn btn-default" id="add"><i class="fa fa-plus"></i>Add</button>
                    </form>
                  </div>
                </div>
              </div>

			<div class='table-responsive'>
				
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Nama</th>
							<th>NRP</th>
							<th>Pangkat</th>
							<th>Jabatan</th>
                            <th>Kesatuan</th>
							<th>Gelar</th>
							<th class='no-sort'>HP</th>
							<th class='no-sort'>Edit</th>
							<th class='no-sort'>Hapus</th>
						</tr>
					</thead>
                    <tbody>
                        <?php 
						$no=1;
						foreach($pegawais as $pegawai) { ?>
                    	<tr>
							<td><?=$no;?></td>
                            <td><?=$pegawai->nama;?></td>
                            <td><?=$pegawai->nrp;?></td>
                            <td><?=$pegawai->pangkat;?></td>
                            <td><?=$pegawai->jabatan;?></td>
                            <td><?=$pegawai->kesatuan;?></td>
                            <td><?=$pegawai->gelar;?></td>
                            <td class='no-sort'><?=$pegawai->hp;?></td>
							<td class='no-sort'><a href="<?=base_url('master/pegawaiupdate')."/".$pegawai->id;?>" class="fa fa-pencil">&nbsp;</a></td>
							<td class='no-sort'><a href="<?=base_url('master/pegawaidelete')."/".$pegawai->id;?>" class="fa fa-trash">&nbsp;</a></td>
                            
                        </tr>
						<?php 
						$no++;
						} ?>
                    </tbody>
				</table>
			</div>
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