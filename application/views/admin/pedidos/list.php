
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Pedidos
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="ventas" value="ventas">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($this->session->userdata("rol") == 2 || $this->session->userdata("rol") == 1): ?>
                            <a href="<?php echo base_url();?>movimientos/pedidos/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Pedido</a>
                        <?php endif ?>
                        
                        
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
                                    <th>Sucursal</th>
                                    <th>Fecha Registro</th>
                                    <th>Fecha Entrega</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pedidos)): ?>
                                    <?php foreach($pedidos as $pedido):?>

                                            <tr>
                                                <td><?php echo $pedido->id;?></td>
                                                <td><?php echo $pedido->sucursal;?></td>
                                                <td><?php echo $pedido->fecha;?></td>
                                                <td><?php echo $pedido->fecha_entrega;?></td>
                                                <td><?php echo $pedido->total;?></td>
                                                <td><?php echo $pedido->estado == 1 ? 'Entregado':'Pendiente';?></td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-view-pedido" value="<?php echo $pedido->id;?>" data-toggle="modal" data-target="#modal-pedido"><span class="fa fa-search"></span></button>
                                                </td>
                                            </tr>
                                                
                                        
                                        
                                      
                                    <?php endforeach;?>
                                <?php endif ?>
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

<div class="modal fade" id="modal-pedido">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion del Pedido</h4>
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