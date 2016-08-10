<script type="text/javascript">
$(function(){
    $("input[name^=seguro]").change(function(){
        
        if($(this).val() == 0) {            
            $(".buttons_form").hide();

        }else{                        
            $(".buttons_form").show();            
        }

    });
    
});
</script>
<?= form_open('subject/insert', array('class'=>'form-horizontal')); ?>
    <legend style='text-align:center;'> Nuevo Sujeto (Selección)</legend>

    <?= my_validation_errors(validation_errors()); ?>
     <?php
            $data = array(
                'name'        => 'seguro',                
                'value'       => '1',            
                'checked'     => set_radio('sign_consent', 1),
                );
            $data2 = array(
                'name'        => 'seguro',                  
                'value'       => '0',
                'checked'     => set_radio('sign_consent', 0),           
                );           
              
        ?>
    <table class="table table-condensed table-bordered">        
        <tr>
            <td>¿Esta seguro que quiere agregar un nuevo sujeto?: </td>
            <td><?= form_radio($data); ?> Si <?= form_radio($data2); ?> No</td>
        </tr>        

        <?php
            $centro = $this->session->userdata('center_id');
            if($centro == 'Todos'){
            ?>
                <tr><td>Centro: </td><td><?= form_dropdown('center', $centros, set_value('center')); ?></td></tr>

            <?php
            }
            else{
                echo form_hidden('center', $centro);
            }
        ?>

        <tr class='buttons_form' style='display:none'>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
            <?= anchor('subject/index', 'Cancelar', array('class'=>'btn')); ?></td>
        </tr>
    </table>
<?= form_close(); ?>