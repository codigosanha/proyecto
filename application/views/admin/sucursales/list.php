<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Sucursales
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
            	<div class="row">
            		<div class="col-md-12">
            			<a href="<?php echo base_url();?>administrador/sucursales/add" class="btn btn-primary btn-flat">
            				<span class="fa fa-plus"></span> Agregar Sucursal
            			</a>
            		</div>
            	</div>
            	<br>
                <div class="row">
                    <div class="col-md-12">
                    	<input type="hidden" id="modulo" value="administrador/sucursales">
                    	<div class="table-responsive">
	                        <table id="tableSimple" class="table table-bordered" width="100%">
	                            <thead>
	                                <tr>
	                                    <th>Nombre</th>
	                                    <th>Telefono</th>
	                                    <th>Departamento</th>
	                                    <th></th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <?php if (!empty($sucursales)): ?>
	                                    <?php foreach ($sucursales as $sucursal): ?>
	                                        <tr>
	                                            <td><?php echo $sucursal->nombre;?></td>
	                                            <td><?php echo $sucursal->telefono;?></td>
	                                            <td><?php echo $sucursal->departamento;?></td>
	                                            <td>
	                                            	<div class="btn-group">
	                                            		<button type="button" data-target="#modal-default" data-toggle="modal" class="btn btn-primary btn-sm btn-flat btn-view" value="<?php echo $sucursal->id;?>">
	                                            			<span class="fa fa-eye"></span>
	                                            		</button>
	                                            	</div>
	                                            </td>
	                                        </tr>
	                                    <?php endforeach ?>
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

<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Informacion de la Sucursal</h4>
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
