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
        <label for="">Numero de Documento</label><br>
        <?php echo  "A01 - ".str_pad($venta->id, 6, "0", STR_PAD_LEFT)?>
    </div>
    <div class="form-group">
        <p><b>Cliente: </b><?php echo $venta->nombres;?></p>
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
                    <th colspan="2">TOTAL:</th>
                    <th style="text-align: right;"><?php echo $venta->total;?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="form-group text-center">
        <p>Gracias por su preferencia</p>
        <p>Este comprobante <strong>no</strong> es una <strong>Factura</strong></p>
        <p>Por favor exija su factura en caja</p>
        <p>Recuerda visitarnos en:</p>
        <p><i class="fa fa-globe"> www.tallereselpunto.gt</i></p>
        <p><i class="fa fa-facebook-square"> Talleres El Punto</i></p>
    </div>
</div>