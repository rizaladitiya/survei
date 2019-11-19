</head>
<body class="skin-blue">
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <a href="#" class="logo">SI DILMIL</a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                      <li class="dropdown tasks-menu"> </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/img/avatar5.png') ?>" class="user-image" alt="User Image"/>
                            <span class="hidden-xs">
                            <?=$nama;?>
                          </span>
                          </a>
                          <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                              <img src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/img/avatar5.png') ?>" class="img-circle" alt="User Image" />
                              <p>
                                <?=$nama;?> 
                                <small><?=$this->about_model->get_by_nama('title')->row()->value;?> </small>
                              </p>
                            </li>
                            <!-- Menu Body -->                                <!-- Menu Footer-->
                            <li class="user-footer">
                              <div class="pull-left">
                                <a href="<?php echo site_url('setting') ?>" class="btn btn-default btn-flat">Profile</a>
                              </div>
                              <div class="pull-right">
                                <a href="<?php echo site_url('auth/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                              </div>
                            </li>
                          </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- =============================================== -->
