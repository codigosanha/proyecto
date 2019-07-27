<div class="contenido">
    <div class="form-group text-center">
        <label for="">Talleres El Punto</label><br>
        <p>
        <img src="<?php echo base_url();?>img/logo.png" height="64" width="64"> 
        </p>
        Km 168.7 Ruta a Chiché,
        Santa Cruz del Quiche
    </div>
    <div class="form-group">
        <p><b>Cliente: </b><?php echo $pedido->nombres;?></p>
        <p><b>Direccion: </b><?php echo $pedido->direccion;?></p>
        <p><b>Telefono: </b><?php echo $pedido->telefono;?></p>
        <p><b>Fecha Registro: </b><?php echo $pedido->fecha;?></p>
        <p><b>Fecha Entrega: </b><?php echo $pedido->fecha_entrega;?></p>
        <p><b>Estado del Pedido: </b><?php echo $pedido->estado == 1?'Entregado':'Pendiente';?></p>
        <p><b>Sucursal: </b><?php echo $pedido->sucursal;?></p>
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
                    <th colspan="2">TOTAL:</th>
                    <th style="text-align: right;"><?php echo $pedido->total;?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="form-group">
        <?php if (!$pedido->estado && $this->session->userdata("rol") != 2): ?>
            <a href="<?php echo base_url();?>movimientos/pedidos/finalizarPedido/<?php echo $pedido->id;?>" class="btn btn-success btn-block">Finalizar Pedido</a>
        <?php endif ?>
        
        
    </div>

</div>