
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Productos a Inventariar
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php if($this->session->flashdata("error")):?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                
                             </div>
                        <?php endif;?>
                        <form action="<?php echo base_url();?>inventario/productos/store" method="POST">
                            <div class="form-group">
                                <p>Seleccione los nuevos a inventariar</p>
                        
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Codigo de Barra</th>
                                            <th>Nombre</th>
                                            <th>Categoria</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($productos as $producto): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="checkProducto" id="<?php echo "p".$producto->id;?>" value="<?php echo $producto->id?>" class="checkProducto">
                                                </td>
                                                <td><?php echo $producto->cod_barras;?></td>
                                                <td><?php echo $producto->nombre;?></td>
                                                <td><?php echo $producto->categoria;?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="productos-seleccionados"></div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat">Guardar</button>
                                <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat">Volver</a>
                            </div>
                        </form>
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
