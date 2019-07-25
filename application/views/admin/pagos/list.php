<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Pagos
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="planilla/pagos">
                <div class="row">
                    <div class="col-md-12">  
                        <a href="<?php echo base_url();?>planilla/pagos/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Pago</a>
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
                                    <th>Empleado</th>
                                    <th>Puesto de Trabajo</th>
                                    <th>Sueldo</th>
                                    <th>Fecha de Pago</th>
                                    <th>Mes</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($pagos)):?>
                                    <?php foreach($pagos as $pago):?>
                                        <tr>
                                            <td><?php echo $pago->id;?></td>
                                            <td><?php echo $pago->nombre." ".$pago->apellido;?></td>
                                            <td><?php echo $pago->puesto_trabajo;?></td>
                                            <td><?php echo $pago->sueldo;?></td>
                                            <td><?php echo $pago->fecha;?></td>
                                            <td><?php echo $pago->mes;?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view" data-toggle="modal" data-target="#modal-default" value="<?php echo $pago->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>

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
        <h4 class="modal-title">Informacion de la Pago</h4>
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
