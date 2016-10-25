<?= form_open('correos/update', array('class'=>'form-horizontal')); ?>
    <legend> Actualizar Registro </legend>

    <?= my_validation_errors(validation_errors()); ?>

    <div class="control-group" style="text-align:left;">        
        ID: <?= $registro->id; ?>
        <?= form_hidden('id', $registro->id); ?>
    </div>

    <div class="control-group" style="text-align:left;">        
		Nombre: <?= $registro->nombre; ?>
        <?= form_hidden('nombre', $registro->nombre); ?>
    </div>

    <div class="control-group" style="text-align:left;">
        Descripcion:	<?= $registro->descripcion; ?>
        <?= form_hidden('descripcion', $registro->descripcion); ?>
    </div>

    <div class="control-group" style="text-align:left;">
        <?= form_label('Lista', 'correos', array('class'=>'control-label')); ?>
        <?= form_textarea(array('name'=>'correos', 'id'=>'correos', 'value'=>$registro->correos)); ?>
		<i><b>Ingresar correos separados por ,<b></i>
    </div>   

    <div class="form-actions">
        <?= form_button(array('type'=>'submit', 'content'=>'Aceptar', 'class'=>'btn btn-primary')); ?>
        <?= anchor('correos/index', 'Cancelar', array('class'=>'btn')); ?>        
    </div>
<?= form_close(); ?>
