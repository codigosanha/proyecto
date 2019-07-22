
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Empleados
        <small>Editar</small>
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
                        <form action="<?php echo base_url();?>mantenimiento/empleados/update" method="POST">
                            <input type="hidden" name="idEmpleado" value="<?php echo $empleado->id;?>">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $empleado->nombre;?>" required="required">
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required="required" value="<?php echo $empleado->apellido;?>">
                            </div>
                            <div class="form-group">
                                <label for="puesto_trabajo">Puesto de Trabajo:</label>
                                <input type="text" class="form-control" id="puesto_trabajo" name="puesto_trabajo" required="required" value="<?php echo $empleado->puesto_trabajo;?>">
                            </div>
                            <div class="form-group">
                                <label for="sueldo">Sueldo:</label>
                                <input type="text" class="form-control" id="sueldo" name="sueldo" required="required" value="<?php echo $empleado->sueldo;?>">
                            </div>
                            <div class="form-group">
                                <label for="sucursal">Sucursal:</label>
                                <select name="sucursal" id="sucursal" class="form-control">
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <?php
                                            $selected = "";
                                            if ($sucursal->id == $empleado->sucursal_id) {
                                                $selected = "selected";
                                            }
                                        ?>
                                        <option value="<?php echo $sucursal->id;?>" <?php echo $selected;?>><?php echo $sucursal->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
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
