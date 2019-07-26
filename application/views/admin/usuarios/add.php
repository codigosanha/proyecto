
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Usuarios
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
                        <form action="<?php echo base_url();?>administrador/usuarios/store" method="POST">
                            <div class="form-group">
                                <label for="nombres">Empleados:</label>
                                <select name="empleado_id" id="empleado_id" class="form-control" required="required">
                                    <option value="">Seleccione..</option>
                                    <?php foreach ($empleados as $empleado): ?>
                                        <option value="<?php echo $empleado->id;?>"><?php echo $empleado->nombre." ".$empleado->apellido ?></option>
                                    <?php endforeach ?>
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label for="username">Usuario:</label>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo set_value('username') ?: '';?>" required="required">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label for="rol">Roles:</label>
                                <select name="rol" id="rol" class="form-control" required="required">
                                    <option value="1">Administrador</option>
                                    <option value="2">CallCenter</option>
                                    <option value="3">Bodeguero</option>
                                    <option value="4">Dependiente de Farmacia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Guardar">
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
