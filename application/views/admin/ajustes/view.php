<div class="contenido" >
<p class="text-center"><strong>AJUSTE DE INVENTARIO</strong></p> <br>
<p class="text-center"><strong>Fecha: </strong><?php echo $ajuste->fecha;?></p>
<p class="text-center"><strong>Usuario: </strong><?php echo $ajuste->username;?></p><br>
<p class="text-center"><strong>Productos</strong></p>
<table class="table table-bordered" >
	<thead>
		<tr>
			<th>Producto</th>
			<th>Stock BD</th>
			<th>Stock Fisico</th>
			<th>Ajuste</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($productos as $p): ?>
			<tr>
				<td><?php echo $p->nombre; ?></td>
				<td><?php echo $p->stock_bd; ?></td>
				<td><?php echo $p->stock_fisico; ?></td>
				<td><?php echo abs($p->diferencia_stock); ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
</div>