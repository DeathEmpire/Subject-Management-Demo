<?= form_open('subject/update', array('class'=>'form-horizontal')); ?>
    <legend> Update Subject </legend>

    <?= my_validation_errors(validation_errors()); ?>

    <div class="control-group">
        <?= form_label('ID', 'id', array('class'=>'control-label')); ?>
        <span class="uneditable-input"> <?= $registro->id; ?> </span>
        <?= form_hidden('id', $registro->id); ?>
    </div>

    <div class="control-group">
        <?= form_label('Initials', 'initials', array('class'=>'control-label')); ?>
        <?= form_input(array('type'=>'text', 'name'=>'initials', 'id'=>'initials', 'value'=>$registro->initials)); ?>
    </div>    

    <div class="control-group">
        <?= form_label('Screening Date', 'screening_date', array('class'=>'control-label')); ?>
        <?= form_input(array('type'=>'text', 'name'=>'screening_date', 'id'=>'screening_date', 'value'=>$registro->screening_date)); ?>
    </div>

    <div class="control-group">
        <?= form_label('Center', 'center', array('class'=>'control-label')); ?>
        <?= form_dropdown('center', $centers, $registro->center); ?>
    </div>    

    <div class="form-actions">
        <?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
        <?= anchor('subject/index', 'Cancel', array('class'=>'btn')); ?>
        <?= anchor('subject/delete/'.$registro->id, 'Delete', array('class'=>'btn btn-warning', 'onClick'=>"return confirm('Are you sure?')")); ?>
    </div>
<?= form_close(); ?>
