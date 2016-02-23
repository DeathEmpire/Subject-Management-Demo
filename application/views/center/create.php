<?= form_open('center/insert', array('class'=>'form-horizontal')); ?>
    <legend> New Center </legend>

    <?= my_validation_errors(validation_errors()); ?>

    <div class="control-group">
        <?= form_label('Center Name', 'center', array('class'=>'control-label')); ?>
        <?= form_input(array('type'=>'text', 'name'=>'name', 'id'=>'name', 'value'=>set_value('name'))); ?>
    </div>

    <div class="form-actions">
        <?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
        <?= anchor('center/index', 'Cancel', array('class'=>'btn')); ?>
    </div>

<?= form_close(); ?>