<style type="text/css">
    #ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
    $("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

    $("input[name=realizado]").change(function(){
        if($(this).val() == 0){
            $("#fecha").attr('readonly','readonly');
            $("#form_columbia :input").each(function(){
                if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
                    $(this).val('');
                }
            });
        }
        else{
            $("#fecha").removeAttr('readonly');
        }
    });
    if($("input[name=realizado]:checked").val() == 0){
        $("#fecha").attr('readonly','readonly');
        $("#form_columbia :input").each(function(){
                if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
                    $(this).val('');
                }
            });
    }
    else{
        $("#fecha").removeAttr('readonly');
    }

    $("input[name=realizado]").change(function(){
        if($(this).val() == 0){
            $("#form_columbia :input").attr('readonly','readonly');
            $("#form_columbia :input").each(function(){
                if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
                    $(this).val('');
                }
            });
            $('select option:not(:selected)').each(function(){
                $(this).attr('disabled', 'disabled');
            });
            $("input[name=realizado]").removeAttr('readonly');

        }else{
            $("#form_columbia :input").removeAttr('readonly');
            $('select option:not(:selected)').each(function(){
                $(this).removeAttr('disabled', 'disabled');
            });
        }
    });
    if($("input[name=realizado]:checked").val() == 0){
        $("#form_columbia :input").attr('readonly','readonly');
        $("#form_columbia :input").each(function(){
                if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
                    $(this).val('');
                }
            });
        $('select option:not(:selected)').each(function(){
                $(this).attr('disabled', 'disabled');
            });
        $("input[name=realizado]").removeAttr('readonly');

    }else{
        $("#form_columbia :input").removeAttr('readonly');
        $('select option:not(:selected)').each(function(){
            $(this).removeAttr('disabled', 'disabled');
        });
    }

    $("#query_para_campos").dialog({
        autoOpen: false,
        height: 340,
        width: 550
    });

    $(".query").click(function(){
        var campo = $(this).attr('id').split("_query");
        $.post("<?php echo base_url('query/query'); ?>",
            {
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', 
                "campo": campo[0], 
                "etapa": 0,
                "subject_id": $("input[name=subject_id]").val(),
                "form": "escala_de_columbia",
                "form_nombre" : "Escala de Columbia",
                "form_id" : '<?php echo $list[0]->id;?>',
                "tipo": $(this).attr('tipo')
            },
            function(d){
                
                $("#query_para_campos").html(d);
                $("#query_para_campos").dialog('open');
            }
        );
    });

});
</script>

<legend style='text-align:center;'>Escala de Columbia</legend>
<b>Sujeto Actual:</b>
<table class="table table-condensed table-bordered">
    <thead>
        <tr style='background-color: #C0C0C0;'>
            <th>Centro</th>
            <th>ID del Sujeto</th>
            <th>Iniciales</th>
            <th>Fecha de Ingreso</th>
            <th>Fecha de Randomizacion</th>
            <th>Kit Asignado</th>       
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $subject->center_name; ?></td>
            <td><?= anchor('subject/grid/'.$subject->id, $subject->code); ?></td>
            <td><?= $subject->initials; ?></td>     
            <td><?= ((isset($subject->screening_date) AND $subject->screening_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->screening_date)) : ""); ?></td>
            <td><?= ((isset($subject->randomization_date) AND $subject->randomization_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->randomization_date)) : ""); ?></td>
            <td><?= $subject->kit1; ?></td>         
        </tr>
    </tbody>
</table>
<br />
<!-- legend -->
<div style='display:none;'>
    <div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>
<?php
    if(isset($auditoria) AND !empty($auditoria)){
        echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
    }
?>
<?= form_open('subject/escala_de_columbia_update', array('class'=>'form-horizontal','id'=>'form_columbia')); ?>
    
    <?= my_validation_errors(validation_errors()); ?>
    <?= form_hidden('subject_id', $subject->id); ?>         
    <?= form_hidden('id', $list[0]->id); ?>
     
    <?php
            $data = array(
                'name'        => 'realizado',               
                'value'       => 1,         
                'checked'     => set_radio('realizado', 1, (($list[0]->realizado == 1) ? true : false))
            );
        $data2 = array(
            'name'        => 'realizado',               
            'value'       => 0,
            'checked'     => set_radio('realizado', 0, (($list[0]->realizado == 0) ? true : false))
            );
        ?>

    <table class="table table-bordered table-striper table-hover">
        <tr>
            <td>Realizado:</td>
            <td>
                <?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si
                <?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
            </td>
        </tr>
        <tr>
            <td>Fecha: </td>
            <td>
                <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>
                <?php
                    if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
                    {
                        
                        if(!in_array("fecha", $campos_query)) 
                        {
                            if(strpos($_SESSION['role_options']['subject'], 'escala_de_columbia_verify')){
                                echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";
                            }
                            else{
                                echo "<img src='". base_url('img/icon-check.png') ."'>";    
                            }
                        }else{
                            if(strpos($_SESSION['role_options']['subject'], 'escala_de_columbia_update')){
                                echo "<img src='". base_url('img/question.png') ."' id='fecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";    
                            }
                            else{
                                echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";      
                            }
                        }                       
                        
                    }
                ?>
            </td>
        </tr>       
        <tr id='mensaje_desviacion' style='display:none;'>
            <td colspan='2' id='td_mensaje_desviacion' class='alert alert-danger'></td>
        </tr>
        <tr>
            <td colspan='2' style='text-align:center;'>
                <?php
                    if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'tmt_a_insert')){
                ?>
                    <?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
                <?php } ?>
                <?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
            </td>
        </tr>
    </table>

<?= form_close(); ?>
<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created_at));?><br />&nbsp;</br>

<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
    <?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
        
        Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
    
    <?php
    }
    else{
    
        if(isset($_SESSION['role_options']['subject']) 
            AND strpos($_SESSION['role_options']['subject'], 'escala_de_columbia_verify') 
            AND $list[0]->status == 'Record Complete'
        ){
    ?>
        <?= form_open('subject/escala_de_columbia_verify', array('class'=>'form-horizontal')); ?>        
        <?= form_hidden('subject_id', $subject->id); ?>        
        <?= form_hidden('current_status', $list[0]->status); ?>
        <?= form_hidden('id', $list[0]->id); ?>
            
        <?= form_button(array('type'=>'submit', 'content'=>'Verificar', 'class'=>'btn btn-primary')); ?>

        <?= form_close(); ?>

<?php }else{
        echo "Pendiente de Aprobacion";
        }
    }
?>
<br />

<!--Signature/Lock-->
<br /><b>Cierre:</b><br />
    <?php if(!empty($list[0]->lock_user) AND !empty($list[0]->lock_date)){ ?>
        
        Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->lock_date));?>
    
    <?php
    }
    else{
    
        if(isset($_SESSION['role_options']['subject']) 
            AND strpos($_SESSION['role_options']['subject'], 'escala_de_columbia_lock')
            AND $list[0]->status == 'Form Approved by Monitor'){
    ?>
        <?= form_open('subject/escala_de_columbia_lock', array('class'=>'form-horizontal')); ?>      
        <?= form_hidden('subject_id', $subject->id); ?>        
        <?= form_hidden('current_status', $list[0]->status); ?>
        <?= form_hidden('id', $list[0]->id); ?>
            
        <?= form_button(array('type'=>'submit', 'content'=>'Cerrar', 'class'=>'btn btn-primary')); ?>

        <?= form_close(); ?>

<?php }else{
        echo "Pendiente de Cierre";
        }
    }
?>
<br />
<!--Signature-->
    <br /><b>Firma:</b><br />
    <?php if(!empty($list[0]->signature_user) AND !empty($list[0]->signature_date)){ ?>
        
        Formulario Firmado por <?= $list[0]->signature_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->signature_date));?>
    
    <?php
    }
    else{
    
        if(isset($_SESSION['role_options']['subject']) 
            AND strpos($_SESSION['role_options']['subject'], 'escala_de_columbia_signature')
            AND $list[0]->status == 'Form Approved and Locked'
        ){
    ?>
        <?= form_open('subject/escala_de_columbia_signature', array('class'=>'form-horizontal')); ?>     
        <?= form_hidden('subject_id', $subject->id); ?>        
        <?= form_hidden('current_status', $list[0]->status); ?>
        <?= form_hidden('id', $list[0]->id); ?>
            
        <?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

        <?= form_close(); ?>

<?php }else{
        echo "Pendiente de Firma";
        }
    }
?>
<br />