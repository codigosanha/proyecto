<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Ventas
        <small>Nueva</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                 <form action="<?php echo base_url();?>movimientos/ventas/store" method="POST">
                    <div class="row">
                        <!--Inicio Primer Columna-->
                        <div class="col-md-9">
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
                                <div class="input-group">
                                    <span class="input-group-addon">Total:</span>
                                    <input type="text" class="form-control" placeholder="0.00" name="total" readonly="readonly">
                                </div>    
                            </div>  
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat" id="btn-guardar-venta"><i class="fa fa-save"></i> Guardar Venta</button>
                                <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat"><i class="fa fa-times"></i> Cancelar</a>
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