<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/img/avatar5.png') ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?=$nama;?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form --><!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
            <li class="header">Navigasi</li>
		<li class="treeview" <?=($user=="adminsiskom")?"":"style='display:none'";?>>
                <a href="#">
                    <i class="fa fa-dashboard" ></i>SISKOMINFOSID<i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                	<li class="<?=$this->uri->segment('1')=="memo"?'active':'';?>"><a href="<?php echo site_url('memo') ?>"><i class="fa fa-user"></i> Kirim Informasi</a></li>
                </ul>
                <ul class="treeview-menu">
                	<li class="<?=$this->uri->segment('2')=="pegawai"?'active':'';?>"><a href="<?php echo site_url('master/pegawai') ?>"><i class="fa fa-user"></i> Pegawai</a></li>
                </ul>
                <ul class="treeview-menu">
                	<li class="<?=$this->uri->segment('2')=="log"?'active':'';?>"><a href="<?php echo site_url('memo/log') ?>"><i class="fa fa-user"></i> Terkirim</a></li>
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-database" ></i> <span>Laporan SUKMA</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                	<li class="<?=$this->uri->segment('2')=="index"?'active':'';?>"><a href="<?php echo site_url('admin/index') ?>"><i class="fa fa-home"></i> Home</a></li>
                	<li class="<?=$this->uri->segment('2')=="harian"?'active':'';?>"><a href="<?php echo site_url('admin/harian') ?>"><i class="fa  fa-list-alt"></i> Harian</a></li>
                    <li class="<?=$this->uri->segment('2')=="bulanan"?'active':'';?>"><a href="<?php echo site_url('admin2/bulanan') ?>"><i class="fa fa-indent"></i> Bulanan</a></li>
                    <li class="<?=$this->uri->segment('2')=="kesimpulan"?'active':'';?>"><a href="<?php echo site_url('admin2/kesimpulan') ?>"><i class="fa fa-th-large"></i> Kesimpulan</a></li>
                    
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard" ></i> <span>Setting</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                	<li class="<?=$this->uri->segment('1')=="user"?'active':'';?>"><a href="<?php echo site_url('user') ?>"><i class="fa fa-cog"></i> User</a></li>
                    <li class="<?=$this->uri->segment('1')=="program"?'active':'';?>"><a href="<?php echo site_url('setting') ?>"><i class="fa fa-bolt"></i>Program</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
