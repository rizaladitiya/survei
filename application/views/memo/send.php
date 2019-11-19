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
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />

<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        SISKOMINFOSID
    <br /><small>(Sistem Komunikasi dan Informasi Persidangan)</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">SISKOMINFOSID</li>
        <li class="active">Kirim</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
 <form action="<?=base_url('memo/send');?>" method="post" id="formcuti">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
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
                    <h3 class="box-title">Kirim Informasi</h3>
                </div>
                
                <div class="box-body">
                  <div class="form-group">
                        <div class="row">
                      		<div class="col-xs-4"></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4"> </div>
                    </div>
                    <div class="form-group">
                  <label>Isi Informasi</label>
                  <textarea name="pesan" class="textarea" id="pesan" style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" placeholder="Tujuan.....">&nbsp;</textarea>
                    </div>
                    <div class="form-group"></div>
                    <div class="row">
                      <div class="col-xs-4"> </div>
                    </div>
                    <div class="row">
                    		
                    	<div class="col-xs-6">
                          <label>Dikirimkan Kepada</label>
                    			<div class="input-group">
                      			<select class="form-control select2"  multiple="multiple"  name="kepada[]" id="kepada"   data-placeholder="Kepada......." >
							<?php  
							foreach($pegawais as $pegawai){
							?>
      							<option value=<?=$pegawai->hp; ?>><?=$pegawai->nama; ?></option>
      <?php } ?>            </select>
           				  </div>
               		  </div>
                  </div>
                     </div>
                       <!-- /.login-box-body --><div class="callout callout-success" id="alert-success" <?php if(!empty($message)){echo "";}else{echo "style='display:none'";}?>>
              <h4>Success</h4>
              <p><?=isset($message)?$message:'';?></p>
            </div>
                </div>
                <div class="box-footer clearfix">
                    <button class="pull-right btn btn-default" id="sendEmail">Kirim <i class="fa fa-save"></i></button>
                </div>
            </div>
                </div>
                
       
            </div><!-- /.nav-tabs-custom -->


			<!-- /.box -->
            <!-- TO DO List --><!-- /.box -->

            <!-- quick email widget -->
          

        </section><!-- /.Left col -->
        <p>
          <!-- right col (We are only adding the ID to make the widgets sortable)--></p>
        <p>&nbsp;</p>
        <!-- right col -->
    </div><!-- /.row (main row) -->

                    </form>
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
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.full.min.js') ?>" type="text/javascript"></script>



<script type="text/javascript">
$(function () {
		var pesan,kepada;
		var message='<?=isset($message)?$message:'';?>';
		$('.select2').select2();
			if(message){
			$("#alert-success").slideUp(5000);
			}
		
		/*
        $("#sendEmail").click(function(){
			
        isipesan=$("#pesan").val();
         isikepada=JSON.stringify($("#kepada").val());
		//alert($("#kepada").val());
*/
			/*
          $.post("https://glamorous-background.glitch.me/wa",{pesan: isipesan,kepada: isikepada}, function(data){
            alert(data);
          });
		  */
/*
		  $.ajax({
                url: 'https://glamorous-background.glitch.me/wa',
                type: 'POST',
                data: {pesan: isipesan,kepada: isikepada},
                success: function( data, textStatus, jQxhr ){
                    alert(data );
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
					alert(JSON.stringify(jqXhr));
                }
            });
			
		  //alert(0);
		  return false;
        });
	*/
});
</script>
<?php
$this->load->view('template/foot');
?>
