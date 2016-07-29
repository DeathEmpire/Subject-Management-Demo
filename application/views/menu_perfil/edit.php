<?= form_open('menu_perfil/update', array('class'=>'form-horizontal')); ?>
    <legend> Actualizar Registro </legend>

    <?= my_validation_errors(validation_errors()); ?>
    <?= form_hidden('id', $registro->id); ?>
    
    <table class='table table-bordered table-striped'>
        <tr>
            <td><?= form_label('Menú', 'menu_id', array('class'=>'control-label')); ?></td>
            <td><?= form_dropdown('menu_id', $menus, $registro->menu_id); ?></td>
        </tr>
        <tr>
            <td><?= form_label('Perfil', 'perfil_id', array('class'=>'control-label')); ?></td>
            <td><?= form_dropdown('perfil_id', $perfiles, $registro->perfil_id); ?></td>
        </tr>
        <tr>
            <td><?= form_label('Creado', 'created', array('class'=>'control-label')); ?></td>
            <td>
                <span class="uneditable-input"> <?= date("d/m/Y - H:i", strtotime($registro->created)); ?> </span>
                <?= form_hidden('created', $registro->created); ?>
            </td>
        </tr>
        <tr>
            <td><?= form_label('Modificado', 'updated', array('class'=>'control-label')); ?>
            <td>
                <span class="uneditable-input"> <?= date("d/m/Y - H:i", strtotime($registro->updated)); ?> </span>
                <?= form_hidden('updated', $registro->updated); ?>
            </td>
        </tr>
        <tr>
            <td colspan='2' style='text-align:center;'>
                <?= form_button(array('type'=>'submit', 'content'=>'Aceptar', 'class'=>'btn btn-primary')); ?>
                <?= anchor('menu_perfil/index', 'Cancelar', array('class'=>'btn')); ?>
                <?= anchor('menu_perfil/delete/'.$registro->id, 'Eliminar', array('class'=>'btn btn-warning', 'onClick'=>"return confirm('¿Está Seguro?')")); ?>
            </td>
        </tr>
    </table>
    
<?= form_close(); ?>
