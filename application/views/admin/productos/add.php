
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Productos
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                
                <form action="<?php echo base_url();?>almacen/productos/store" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if($this->session->flashdata("error")):?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                 </div>
                            <?php endif;?>
                            
                            <div class="form-group <?php echo !empty(form_error('cod_barras')) ? 'has-error':'';?>">
                                <label for="cod_barras">Codigo de Barras:</label>
                                <div class="input-group barcode">
                                    <div class="input-group-addon">
                                    <button id="barcode_btn" class="btn-barcode fa fa-barcode"></button>
                                </div>
                                <input type="text" class="form-control" id="cod_barras" name="cod_barras" required value="<?php echo set_value('cod_barras');?>">
                               </div>
                                <?php echo form_error("cod_barras","<span class='help-block'>","</span>");?>
                            </div>                           
                                
                            <div class="form-group <?php echo !empty(form_error('nombre')) ? 'has-error':'';?>">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo set_value('nombre');?>">
                                <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                            </div>
                                
                            <div class="form-group">
                                <label for="precio_compra">Precio de Compra:</label>
                                <input type="text" class="form-control" id="precio_compra" name="precio_compra" required="required">
                            </div>
                            <div class="form-group">
                                <label for="precio_venta">Precio de Venta:</label>
                                <input type="text" class="form-control" id="precio_venta" name="precio_venta" required="required">
                            </div>

                            
                                
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat">Guardar</button>
                                <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat">Volver</a>
                            </div>
                            
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                                <label for="categoria">Categoria:</label>
                                <select name="categoria" id="categoria" class="form-control" required>
                                    <?php foreach($categorias as $categoria):?>
                                        <option value="<?php echo $categoria->id?>"><?php echo $categoria->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripcion:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" required="required">
                            </div>
                            
                              <div class="form-group">
                                <label for="marca">Marca:</label>
                                <select name="marca" id="marca" class="form-control" required>
                                    <?php foreach($marcas as $marca):?>
                                        <option value="<?php echo $marca->id?>"><?php echo $marca->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                                
                             <div class="form-group">
                                <label for="presentacion">Presentacion:</label>
                                <select name="presentacion" id="presentacion" class="form-control" required>
                                    <?php foreach($presentaciones as $presentacion):?>
                                        <option value="<?php echo $presentacion->id?>"><?php echo $presentacion->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
