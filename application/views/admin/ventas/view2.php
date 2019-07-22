<div class="contenido">
	<div class="form-group text-center">
		<label for="">Talleres El Punto</label><br>
		<p>
		<img src="<?php echo base_url();?>img/logo.png" height="64" width="64"> 
		</p>
		Km 168.7 Ruta a Chiché,
		Santa Cruz del Quiche
	</div>
	<div class="form-group text-center">
		<label for=""><?php echo $venta->tipocomprobante;?></label><br>
		<?php echo $venta->serie ." - ".$venta->num_documento;?>
	</div>
	<div class="form-group">
		<p><b>Estado: </b><?php if ($venta->estado == "1") {
                                                    echo '<span class="label label-success">Pagado</span>';
                                                }else if($venta->estado == "2"){
                                                    echo '<span class="label label-warning">Credito</span>';
                                                }else{
                                                    echo '<span class="label label-danger">Anulado</span>';
                                                } ?>
                                            </p>
		<p><b>Cliente: </b><?php echo $venta->nombre;?></p>
		<p><b>No. Documento: </b><?php echo $venta->num_documento;?></p>
		<p><b>Direccion: </b><?php echo $venta->direccion;?></p>
		<p><b>Telefono: </b><?php echo $venta->telefono;?></p>
		<p><b>Fecha: </b><?php echo $venta->fecha;?></p>
	</div>

	<div class="form-group">
		<table width="100%" cellpadding="10" cellspacing="0" border="0">
			<thead>
				<tr>
					<th>Cant.</th>
					<th>Producto</th>
					<th>Precio</th>
					<th style="text-align: right;">Importe</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($detalles as $detalle):?>
				<tr>
					<td><?php echo $detalle->cantidad;?></td>
					<td><?php echo $detalle->nombre;?></td>
					<td><?php echo $detalle->precio;?></td>
					<td style="text-align: right;"><?php echo $detalle->importe;?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">Subtotal:</td>
					<td style="text-align: right;"><?php echo $venta->subtotal;?></td>
				</tr>
				<!--
				<tr>
					<td colspan="2">iva:</td>
					<td style="text-align: right;">?php echo $venta->iva;?></td>
				</tr>
			-->
				<tr>
					<td colspan="2">Descuento:</td>
					<td style="text-align: right;"><?php echo $venta->descuento;?></td>
				</tr>
				<tr>
					<th colspan="2">TOTAL:</th>
					<th style="text-align: right;"><?php echo $venta->total;?></th>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="form-group text-center">
        <p>Gracias por tu preferencia!!!</p>
        <p>Este comprobante no es una <strong>Factura</strong></p>
        <p>Por favor exija su factura en caja</p>
        <p>Recuerda visitarnos en:</p>
        <p><i class="fa fa-globe"> www.tallereselpunto.gt</i></p>
        <p><i class="fa fa-facebook-square"> Talleres El Punto</i></p>
    </div>
</div>