<?= form_open('center/update', array('class'=>'form-horizontal')); ?>
    <legend> Update Center </legend>

    <?= my_validation_errors(validation_errors()); ?>
    <div class="control-group">
        <?= form_label('ID', 'id', array('class'=>'control-label')); ?>
        <span class="uneditable-input"> <?= $registro->id; ?> </span>
        <?= form_hidden('id', $registro->id); ?>
    </div>

    <div class="control-group">
        <?= form_label('Center Name', 'name', array('class'=>'control-label')); ?>
        <?= form_input(array('type'=>'text', 'name'=>'name', 'id'=>'name', 'value'=>$registro->name)); ?>
    </div>         

    <div class="form-actions">
        <?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
        <?= anchor('center/index', 'Cancel', array('class'=>'btn')); ?>
        <?= anchor('center/delete/'.$registro->id, 'Delete', array('class'=>'btn btn-warning', 'onClick'=>"return confirm('Are you sure?')")); ?>
    </div>
<?= form_close(); ?>
