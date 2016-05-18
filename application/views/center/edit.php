<?= form_open('center/update', array('class'=>'form-horizontal')); ?>
    <legend> Editar Centro </legend>

    <?= my_validation_errors(validation_errors()); ?>
    <div class="control-group">
        <?= form_label('ID', 'id', array('class'=>'control-label')); ?>
        <span class="uneditable-input"> <?= $registro->id; ?> </span>
        <?= form_hidden('id', $registro->id); ?>
    </div>

    <div class="control-group">
        <?= form_label('Nombre', 'name', array('class'=>'control-label')); ?>
        <?= form_input(array('type'=>'text', 'name'=>'name', 'id'=>'name', 'value'=>$registro->name)); ?>
    </div>         

    <div class="form-actions">
        <?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
        <?= anchor('center/index', 'Cancelar', array('class'=>'btn')); ?>
        <?= anchor('center/delete/'.$registro->id, 'Borrar', array('class'=>'btn btn-warning', 'onClick'=>"return confirm('Esta seguro?')")); ?>
    </div>
<?= form_close(); ?>
