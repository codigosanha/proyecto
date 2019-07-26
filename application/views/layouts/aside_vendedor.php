<aside class="main-sidebar" id="side-bar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">      
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">Menu</li>
                  <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                     <img src="<?php echo base_url();?>img/logo.png" alt="Avatar" /> 
                    </div>
                    <div class="pull-left info">
                  <p><?php echo $this->session->userdata("username")?></p>
                  <p><i class="fa fa-circle text-success"></i> En Linea</p>
                </div>
              </div>

           

    

         <li class="treeview">
          <a href="#">
            <i class="fa fa-dollar"></i>
            <span>Movimientos</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>movimientos/ventas"><i class="fa fa-circle-o"></i> Ventas</a></li> 
            <li><a href="<?php echo base_url();?>movimientos/pedidos"><i class="fa fa-circle-o"></i> Pedidos</a></li>         
          </ul>
        </li>

        

       

         
    </ul>
    </section>
    <!-- /.sidebar -->
</aside>