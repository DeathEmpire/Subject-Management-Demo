<?php $centers = array("01"=>"Center 01","02"=>"Cetner 02"); ?>
<?= form_open('usuario/update', array('class'=>'form-horizontal')); ?>
    <legend> Actualizar Registro </legend>

    <?= my_validation_errors(validation_errors()); ?>

    <div class="control-group">
        <?= form_label('ID', 'id', array('class'=>'control-label')); ?>
        <span class="uneditable-input"> <?= $registro->id; ?> </span>
        <?= form_hidden('id', $registro->id); ?>
    </div>

    <div class="control-group">
        <?= form_label('Name', 'name', array('class'=>'control-label')); ?>
        <?= form_input(array('type'=>'text', 'name'=>'name', 'id'=>'name', 'value'=>$registro->name)); ?>
    </div>

    <div class="control-group">
        <?= form_label('Username', 'login', array('class'=>'control-label')); ?>
        <?= form_input(array('type'=>'text', 'name'=>'login', 'id'=>'login', 'value'=>$registro->login)); ?>
    </div>

    <div class="control-group">
        <?= form_label('eMail', 'email', array('class'=>'control-label')); ?>
        <?= form_input(array('type'=>'email', 'name'=>'email', 'id'=>'email', 'value'=>$registro->email)); ?>
    </div>
    
    <div class="control-group">
        <?= form_label('Center', 'center', array('class'=>'control-label')); ?>
        <?= form_dropdown('center', $centers, set_value('center')); ?>
    </div> 

    <div class="control-group">
        <?= form_label('Perfil', 'perfil_id', array('class'=>'control-label')); ?>
        <?= form_dropdown('perfil_id', $perfiles, $registro->perfil_id); ?>
    </div>       

    <div class="form-actions">
        <?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
        <?= anchor('usuario/index', 'Cancel', array('class'=>'btn')); ?>
        <?= anchor('usuario/delete/'.$registro->id, 'Delete', array('class'=>'btn btn-warning', 'onClick'=>"return confirm('¿Está Seguro?')")); ?>
    </div>
<?= form_close(); ?>
