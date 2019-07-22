<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Empleados
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="mantenimiento/empleados">
                <div class="row">
                    <div class="col-md-12">  
                        <a href="<?php echo base_url();?>mantenimiento/empleados/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Empleado</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Puesto de Trabajo</th>
                                    <th>Sueldo</th>
                                    <th>Sucursal</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($empleados)):?>
                                    <?php foreach($empleados as $empleado):?>
                                        <tr>
                                            <td><?php echo $empleado->id;?></td>
                                            <td><?php echo $empleado->nombre;?></td>
                                            <td><?php echo $empleado->apellido;?></td>
                                            <td><?php echo $empleado->puesto_trabajo;?></td>
                                            <td><?php echo $empleado->sueldo;?></td>
                                            <td><?php echo $empleado->sucursal;?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view" data-toggle="modal" data-target="#modal-default" value="<?php echo $empleado->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                   
                                                    <a href="<?php echo base_url()?>mantenimiento/empleados/edit/<?php echo $empleado->id;?>" class="btn btn-warning"><span class="fa fa-pencil"></span></a>

                                                    <?php if($empleado->estado): ?>
                                                    <a href="<?php echo base_url();?>mantenimiento/empleados/delete/<?php echo $empleado->id;?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
                                                     <?php else :?>
                                                    <a href="<?php echo base_url();?>mantenimiento/empleados/restore/<?php echo $empleado->id;?>" class="btn btn-success btn-check"><span class="fa fa-check"></span></a>
                                                    <?php endif;?>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                       </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion del Empleado</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
