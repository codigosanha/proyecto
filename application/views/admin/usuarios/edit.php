
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Usuarios
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
                        <form action="<?php echo base_url();?>administrador/usuarios/update" method="POST">
                            <input type="hidden" name="idUsuario" value="<?php echo $usuario->id ?>">
                            <div class="form-group">
                                <label for="nombres">Empleado:</label>
                                <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo $usuario->nombre." ".$usuario->apellido;?>" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label for="username">Usuario:</label>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo $usuario->username;?>" required="required">
                            </div>
                           
                            <div class="form-group">
                                <label for="rol">Roles:</label>
                                <select name="rol" id="rol" class="form-control" required="required">
                                    <option value="1" <?php echo $usuario->rol == 1 ? "selected":""; ?>>Administrador</option>
                                    <option value="2" <?php echo $usuario->rol == 2 ? "selected":""; ?>>CallCenter</option>
                                    <option value="3" <?php echo $usuario->rol == 3 ? "selected":""; ?>>Bodeguero</option>
                                    <option value="4" <?php echo $usuario->rol == 4 ? "selected":""; ?>>Dependiente de Farmacia</option>
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
