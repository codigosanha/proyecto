<!DOCTYPE html>
<html lang="en">
<head>
  <title>QPharmaPOS | Selección de Sucursales</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/bootstrap.min.css">

</head>
<body>

<div class="container">
    <div class="row">
    	<div class="col-md-4 col-md-offset-4">	
			<h2 class="text-center">Lista de Sucursales</h2>
			<div class="list-group">
                <?php foreach ($sucursales as $sucursal): ?>
                    <a href="<?php echo base_url();?>dashboard/setSucursal/<?php echo $sucursal->id;?>" class="list-group-item ">
                       <h4 class="list-group-item-heading"><?php echo $sucursal->nombre; ?></h4>
                        <p class="list-group-item-text">
                            <b>Departamento : </b> <?php echo $sucursal->departamento; ?><br>
                            <b>Telefono:</b> <?php echo $sucursal->telefono ?><br>
                        </p>
                    </a>
                <?php endforeach ?>
    		    
    		</div>
        <?php if ($this->session->userdata("sucursal_id")): ?>
          <a href="<?php echo base_url();?>dashboard" class="btn btn-danger btn-block">Regresar</a>
        <?php endif ?>
        
    	</div>
    </div>
</div>
  
<script src="<?php echo base_url();?>assets/template/jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/template/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>