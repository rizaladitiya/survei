</div><!-- /.content-wrapper -->

<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <?=$this->about_model->get_by_nama('title')->row()->value;?>
    </div>
    Copyright &copy; 2017 
    <?=$this->about_model->get_by_nama('program')->row()->value;?>
    | created
  by <strong><?=$this->about_model->get_by_nama('creator')->row()->value;?></strong></footer>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets/fungsi.js') ?>"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/slimScroll/jquery.slimScroll.min.js') ?>" type="text/javascript"></script>
<!-- FastClick -->
<script src='<?php echo base_url('assets/AdminLTE-2.0.5/plugins/fastclick/fastclick.min.js') ?>'></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/js/app.min.js') ?>" type="text/javascript"></script>