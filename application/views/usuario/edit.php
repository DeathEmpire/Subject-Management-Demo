<div>
<?php 
   
    foreach ($centers as $center) {
        $aux[$center->id] = $center->name;
    }
    $centers = array(''=>'')+$aux;
    $centers['Todos'] = 'Todos';
?>
<?= form_open('usuario/update', array('class'=>'form-horizontal', 'role'=>'form')); ?>
    <legend> Actualizar Registro </legend>

    <?= my_validation_errors(validation_errors()); ?>

    <div class="form-group">
        <?= form_label('ID', 'id', array('class'=>'control-label col-sm-1')); ?>
        <div class="col-sm-4">
            <span class="uneditable-input"> <?= $registro->id; ?> </span>
            <?= form_hidden('id', $registro->id); ?>
        </div>
    </div>

    <div class="form-group">
        <?= form_label('Nombre: ', 'name', array('class'=>'control-label col-sm-1')); ?>
        <div class="col-sm-4">
            <?= form_input(array('type'=>'text', 'name'=>'name', 'id'=>'name', 'value'=>$registro->name, 'class'=>'form-control')); ?>
        </div>
    </div>

    <div class="form-group">
        <?= form_label('Username', 'login', array('class'=>'control-label col-sm-1')); ?>
        <div class="col-sm-4">
            <?= form_input(array('type'=>'text', 'name'=>'login', 'id'=>'login', 'value'=>$registro->login, 'class'=>'form-control')); ?>
        </div>
    </div>

    <div class="form-group">
        <?= form_label('Email', 'email', array('class'=>'control-label col-sm-1')); ?>
        <div class="col-sm-4">
            <?= form_input(array('type'=>'email', 'name'=>'email', 'id'=>'email', 'value'=>$registro->email, 'class'=>'form-control')); ?>
        </div>
    </div>
    
    <div class="form-group">
        <?= form_label('Centro', 'center', array('class'=>'control-label col-sm-1')); ?>
        <div class="col-sm-4">
            <?= form_dropdown('center', $centers, set_value('center',$registro->center), array('class'=>'form-control')); ?>
        </div>
    </div> 

    <div class="form-group">
        <?= form_label('Perfil', 'perfil_id', array('class'=>'control-label col-sm-1')); ?>
        <div class="col-sm-4">
            <?= form_dropdown('perfil_id', $perfiles, set_value('perfil_id', $registro->perfil_id), array('class'=>'form-control')); ?>
        </div>
    </div>       

    <div class="form-actions">
        <?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
        <?= anchor('usuario/index', 'Cancelar', array('class'=>'btn')); ?>
        <?= anchor('usuario/delete/'.$registro->id, 'Eliminar', array('class'=>'btn btn-warning', 'onClick'=>"return confirm('¿Está Seguro?')")); ?>
    </div>
<?= form_close(); ?>
</div>