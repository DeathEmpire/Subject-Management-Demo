<style type="text/css">
    #ui-datepicker-div { display: none; }
</style>
<div class="row">
    <?= form_open('center/insert', array('class'=>'form-horizontal')); ?>
        <legend> Agregar Nuevo Centro </legend>

        <?= my_validation_errors(validation_errors()); ?>
        <!--Centro-->
        <div style='font-weight:bold;'>Informacion del Centro<br /></div>
        <div class="control-group col-xs-4">
            <?= form_label('Nombre del Centro: *', 'center', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'name', 'id'=>'name', 'value'=>set_value('name'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Direccion: *', 'direccion', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'direccion', 'id'=>'direccion', 'value'=>set_value('direccion'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Ciudad/Localidad: *', 'ciudad_localidad', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'ciudad_localidad', 'id'=>'ciudad_localidad', 'value'=>set_value('ciudad_localidad'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Estado/Provincia: *', 'estado_provincia', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'estado_provincia', 'id'=>'estado_provincia', 'value'=>set_value('estado_provincia'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Codigo Zip/Postal: ', 'zip_postal', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'zip_postal', 'id'=>'zip_postal', 'value'=>set_value('zip_postal'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Pais: *', 'pais', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'pais', 'id'=>'pais', 'value'=>set_value('pais'), 'class'=>'form-control')); ?>
        </div>

        <!--Contacto-->
        <br />&nbsp;<br /><br />&nbsp;<br />
        <div style='font-weight:bold;'>Contacto del Centro<br /></div>
        <div class="control-group col-xs-4">
            <?= form_label('Nombre Contacto: ', 'contacto_nombre', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'contacto_nombre', 'id'=>'contacto_nombre', 'value'=>set_value('contacto_nombre'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Codigo Pais Contacto: ', 'contacto_codigo__pais', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'number', 'name'=>'contacto_codigo_pais', 'id'=>'contacto_codigo_pais', 'value'=>set_value('contacto_codigo__pais'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Telefono Contacto: ', 'contacto_fono', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'contacto_fono', 'id'=>'contacto_fono', 'value'=>set_value('contacto_fono'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Fax Contacto: ', 'contacto_fax', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'text', 'name'=>'contacto_fax', 'id'=>'contacto_fax', 'value'=>set_value('contacto_fax'), 'class'=>'form-control')); ?>
        </div>
        <div class="control-group col-xs-4">
            <?= form_label('Email Contacto: ', 'contacto_email', array('class'=>'control-label')); ?>
            <?= form_input(array('type'=>'email', 'name'=>'contacto_email', 'id'=>'contacto_email', 'value'=>set_value('contacto_email'), 'class'=>'form-control')); ?>
        </div>   
        
        <!--Adicionales-->
        <?php 
            $data = array(
                'name'        => 'type',                
                'value'       => 'Centro Administrativo',            
                'checked'     => set_radio('type', 1),
            );
            $data2 = array(
                'name'        => 'type',
                'id'          => 'type',
                'value'       => 'Centro Actual',
                'checked'     => set_radio('type', 0),           
            );
        ?>
        <div style='font-weight:bold;'>Propiedades del Centro<br /></div>
        <div class="control-group col-xs-4">        
           Tipo: <?= form_radio($data); ?>Centro Administrativo - <?= form_radio($data2); ?> Centro Actual 
        </div>
        <?php
            $disabled = array(
                'name'        => 'disabled',
                'id'          => 'disabled',
                'value'       => '1',
                'checked'     => set_checkbox('disabled','1')
            );
        ?>
        <div class="control-group col-xs-4">
            <?= form_checkbox($disabled);?>Deshabilitado
            <p class='disabled' style='display:none;'>
                Fecha: <?= form_input(array('type'=>'text', 'name'=>'last_disabled', 'id'=>'last_disabled', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('last_disabled')));?></td><br />
                Razon: <?= form_textarea(array('name'=>'disabled_reason', 'id'=>'disabled_reason', 'value'=>set_value('disabled_reason'), 'rows'=>'4','cols'=>'40')); ?>
            </p>                                      
        </div>        
        <br />&nbsp;<br />
        <div class="form-actions" style='text-align:center;'>
            <?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
            <?= anchor('center/index', 'Cancelar', array('class'=>'btn btn-default')); ?>
        </div>

    <?= form_close(); ?>
</div>
<script type="text/javascript">
    $("#last_disabled").datepicker();

    $("#disabled").click(function(){
        if($(this).is(":checked")){
            $(".disabled").show();
        }
        else{
            $(".disabled").hide();
        }
    });

</script>