<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Pedidos
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                 <form action="<?php echo base_url();?>movimientos/pedidos/store" method="POST">
                    <div class="row">
                        <!--Inicio Primer Columna-->
                        <div class="col-md-9">
                            <!-- <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $usuario->sucursal_id;?>"> -->
                            
                            <input type="hidden" id="modulo" value="movimientos/pedidos">
                            <div class="form-group">
                                <label for="">Sucursal</label>
                                <select name="sucursal" id="sucursal" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Producto:</label>
                                <div class="input-group barcode">
                                    <div class="input-group-addon">
                                        <i class="fa fa-barcode"></i>
                                    </div>
                                    <input type="text" class="form-control" id="searchProductoVenta" placeholder="Buscar por codigo de barras o nombre del proucto">
                                </div>
                            </div>
                            <div class="form-group">
                                <table id="tbventas" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Stock Max.</th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                            </div>
                          
                        </div>
                        <!--Inicio 2da Columna-->
                        <div class="col-md-3">
                            <div class="form-group">       
                                <label for="">Clientes:</label>
                                <select name="cliente" id="cliente" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?php echo $cliente->id?>"><?php echo $cliente->nombres?></option>
                                    <?php endforeach ?>
                                    
                                </select>
                            </div> 
                            <div class="form-group">            
                                <label for="">Fecha de Registro:</label>
                                <input type="date" class="form-control" name="fecha_registro" value="<?php echo date("Y-m-d");?>" required>
                            </div>          
                            <div class="form-group">            
                                <label for="">Fecha de Entrega:</label>
                                <input type="date" class="form-control" name="fecha_entrega" value="<?php echo date("Y-m-d");?>" required>
                            </div>    
                            <div class="form-group">              
                                <div class="input-group">
                                    <span class="input-group-addon">Total:</span>
                                    <input type="text" class="form-control" placeholder="0.00" name="total" readonly="readonly">
                                </div>    
                            </div>  
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat" id="btn-guardar-venta"><i class="fa fa-save"></i> Guardar Venta</button>
                                <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat"><i class="fa fa-times"></i> Cancelar</a>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-cliente">Registrar cliente</button>
                            </div>
                                
                        </div>
                    </div>
                </form>
                    <!--Fin de Primer Columna-->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>

    <!-- /.content -->

</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="modal-add-cliente">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registro de Cliente</h4>
      </div>
      <form action="#" method="POST" id="form-add-cliente">
      <div class="modal-body">
        <div class="form-group">
            <label for="">Nombres</label>
            <input type="text" name="nombres" class="form-control" placeholder="Nombres">
        </div>
        <div class="form-group">
            <label for="">Direccion</label>
            <input type="text" name="direccion" class="form-control" placeholder="Direccion">
        </div>
        <div class="form-group">
            <label for="">Telefono</label>
            <input type="text" name="telefono" class="form-control" placeholder="Telefono">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary btn-flat"><span class="fa fa-print"></span> Guardar</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->