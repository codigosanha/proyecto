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

           <li><a href="<?php echo base_url();?>dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-database"></i>
            <span>Almacen</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>almacen/productos"><i class="fa fa-circle-o"></i> Productos</a></li>
            <li><a href="<?php echo base_url();?>almacen/categorias"><i class="fa fa-circle-o"></i> Categorias</a></li>
            <li><a href="<?php echo base_url();?>almacen/activos"><i class="fa fa-circle-o"></i> Activos</a></li>
          </ul>
        </li>

         <li class="treeview">
          <a href="#">
            <i class="fa fa-cog"></i>
            <span>Mantenimiento</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>mantenimiento/clientes"><i class="fa fa-circle-o"></i> Clientes</a></li>
            <li><a href="<?php echo base_url();?>mantenimiento/empleados"><i class="fa fa-circle-o"></i> Empleados</a></li>
            <li><a href="<?php echo base_url();?>mantenimiento/proveedores"><i class="fa fa-circle-o"></i> Proveedores</a></li>
            <li><a href="<?php echo base_url();?>mantenimiento/departamentos"><i class="fa fa-circle-o"></i> Departamentos</a></li>
          </ul>
        </li>

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
            <li><a href="<?php echo base_url();?>movimientos/compras"><i class="fa fa-circle-o"></i> Compras</a></li>
            <li><a href="<?php echo base_url();?>movimientos/pedidos"><i class="fa fa-circle-o"></i> Pedidos</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Administrador</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Usuarios</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Sucursales</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-dropbox"></i>
            <span>Inventario</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>inventario/productos"><i class="fa fa-circle-o"></i> Productos</a></li>
          </ul>
        </li>

         <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Reportes</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>reportes/ventas"><i class="fa fa-circle-o"></i> Reporte de Ventas</a></li>
            <li><a href="<?php echo base_url();?>reportes/compras"><i class="fa fa-circle-o"></i> Reporte de Compras</a></li>
            <li><a href="<?php echo base_url();?>reportes/activos"><i class="fa fa-circle-o"></i> Reporte de Activos</a></li>
            <li><a href="<?php echo base_url();?>reportes/productos"><i class="fa fa-circle-o"></i> Reporte de Productos</a></li>
          </ul>
        </li>
    </ul>
    </section>
    <!-- /.sidebar -->
</aside>