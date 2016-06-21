$(function(){
	$("#fecha").datepicker();	

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("input[name*=frecuencia], input[name*=severidad], input[name*=angustia], input[name=fecha]").attr('readonly','readonly');								
			$('select option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});

		}else{
			$("input[name*=frecuencia], input[name*=severidad], input[name*=angustia], input[name=fecha]").removeAttr('readonly');
			$("input[name=puntaje_total_para_angustia]").attr('readonly','readonly');
			$('select option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("input[name*=frecuencia], input[name*=severidad], input[name*=angustia], input[name=fecha]").attr('readonly','readonly');		
		
		$('select option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});

	}else{
		$("input[name*=frecuencia], input[name*=severidad], input[name*=angustia], input[name=fecha]").removeAttr('readonly');
		$("input[name=puntaje_total_para_angustia]").attr('readonly','readonly');		
		$('select option:not()').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	$("input[name*=delirio]").change(function(){
		if($("input[name=delirio_frecuencia]").val() != '' && $("input[name=delirio_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=delirio_frecuencia]").val()) * parseInt($("input[name=delirio_severidad]").val());

			$("input[name=delirio_puntaje]").val(puntaje);
				
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	$("input[name*=alucinaciones]").change(function(){
		if($("input[name=alucinaciones_frecuencia]").val() != '' && $("input[name=alucinaciones_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=alucinaciones_frecuencia]").val()) * parseInt($("input[name=alucinaciones_severidad]").val());

			$("input[name=alucinaciones_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	$("input[name*=agitacion]").change(function(){
		if($("input[name=agitacion_frecuencia]").val() != '' && $("input[name=agitacion_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=agitacion_frecuencia]").val()) * parseInt($("input[name=agitacion_severidad]").val());

			$("input[name=agitacion_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	
	$("input[name*=depresion]").change(function(){
		if($("input[name=depresion_frecuencia]").val() != '' && $("input[name=depresion_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=depresion_frecuencia]").val()) * parseInt($("input[name=depresion_severidad]").val());

			$("input[name=depresion_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	
	$("input[name*=ansiedad]").change(function(){
		if($("input[name=ansiedad_frecuencia]").val() != '' && $("input[name=ansiedad_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=ansiedad_frecuencia]").val()) * parseInt($("input[name=ansiedad_severidad]").val());

			$("input[name=ansiedad_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	
	$("input[name*=elacion]").change(function(){
		if($("input[name=elacion_frecuencia]").val() != '' && $("input[name=elacion_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=elacion_frecuencia]").val()) * parseInt($("input[name=elacion_severidad]").val());

			$("input[name=elacion_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	
	$("input[name*=apatia]").change(function(){
		if($("input[name=apatia_frecuencia]").val() != '' && $("input[name=apatia_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=apatia_frecuencia]").val()) * parseInt($("input[name=apatia_severidad]").val());

			$("input[name=apatia_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	
	$("input[name*=deshinibicion]").change(function(){
		if($("input[name=deshinibicion_frecuencia]").val() != '' && $("input[name=deshinibicion_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=deshinibicion_frecuencia]").val()) * parseInt($("input[name=deshinibicion_severidad]").val());

			$("input[name=deshinibicion_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	
	$("input[name*=irritabilidad]").change(function(){
		if($("input[name=irritabilidad_frecuencia]").val() != '' && $("input[name=irritabilidad_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=irritabilidad_frecuencia]").val()) * parseInt($("input[name=irritabilidad_severidad]").val());

			$("input[name=irritabilidad_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	
	$("input[name*=conducta]").change(function(){
		if($("input[name=conducta_frecuencia]").val() != '' && $("input[name=conducta_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=conducta_frecuencia]").val()) * parseInt($("input[name=conducta_severidad]").val());

			$("input[name=conducta_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);
			
		}
	});
	
	$("input[name*=trastornos_sueno]").change(function(){
		if($("input[name=trastornos_sueno_frecuencia]").val() != '' && $("input[name=trastornos_sueno_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=trastornos_sueno_frecuencia]").val()) * parseInt($("input[name=trastornos_sueno_severidad]").val());

			$("input[name=trastornos_sueno_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
	});
	
	$("input[name*=trastornos_apetito]").change(function(){
		if($("input[name=trastornos_apetito_frecuencia]").val() != '' && $("input[name=trastornos_apetito_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=trastornos_apetito_frecuencia]").val()) * parseInt($("input[name=trastornos_apetito_severidad]").val());

			$("input[name=trastornos_apetito_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				total = parseInt(total) + parseInt($(this).val());								
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("input[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		}
	});
	
	/*Puntaje Total*/
	$("input[name*=_puntaje]").change(function(){
		var total = 0;
		$("input[name^=puntaje]").each(function(){						
			total = parseInt(total) + parseInt($(this).val());						
		});
		$('#puntaje_total_npi').val(total);
	});	
	/*Angustia Total*/
	$("input[name*=_angustia]").change(function(){
		var total2 = 0;
		$("input[name*=angustia]").each(function(){	
			if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != ''){					
				total2 = parseInt(total2) + parseInt($(this).val());							
			}
		});
		$('#puntaje_total_para_angustia').val(total2);
	});

	/*Campos disponibles*/
	$("select[name=delirio_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=delirio_frecuencia]").attr('readonly','readonly');
			$("input[name=delirio_severidad]").attr('readonly','readonly');
			$("input[name=delirio_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=delirio_frecuencia]").removeAttr('readonly');
			$("input[name=delirio_severidad]").removeAttr('readonly');
			$("input[name=delirio_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=delirio_status]").val() == 0){
		$("input[name=delirio_frecuencia]").attr('readonly','readonly');
		$("input[name=delirio_severidad]").attr('readonly','readonly');
		$("input[name=delirio_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=delirio_frecuencia]").removeAttr('readonly');
		$("input[name=delirio_severidad]").removeAttr('readonly');
		$("input[name=delirio_angustia]").removeAttr('readonly');
	}

	$("select[name=alucinaciones_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=alucinaciones_frecuencia]").attr('readonly','readonly');
			$("input[name=alucinaciones_severidad]").attr('readonly','readonly');
			$("input[name=alucinaciones_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=alucinaciones_frecuencia]").removeAttr('readonly');
			$("input[name=alucinaciones_severidad]").removeAttr('readonly');
			$("input[name=alucinaciones_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=alucinaciones_status]").val() == 0){
		$("input[name=alucinaciones_frecuencia]").attr('readonly','readonly');
		$("input[name=alucinaciones_severidad]").attr('readonly','readonly');
		$("input[name=alucinaciones_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=alucinaciones_frecuencia]").removeAttr('readonly');
		$("input[name=alucinaciones_severidad]").removeAttr('readonly');
		$("input[name=alucinaciones_angustia]").removeAttr('readonly');
	}

	$("select[name=agitacion_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=agitacion_frecuencia]").attr('readonly','readonly');
			$("input[name=agitacion_severidad]").attr('readonly','readonly');
			$("input[name=agitacion_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=agitacion_frecuencia]").removeAttr('readonly');
			$("input[name=agitacion_severidad]").removeAttr('readonly');
			$("input[name=agitacion_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=agitacion_status]").val() == 0){
		$("input[name=agitacion_frecuencia]").attr('readonly','readonly');
		$("input[name=agitacion_severidad]").attr('readonly','readonly');
		$("input[name=agitacion_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=agitacion_frecuencia]").removeAttr('readonly');
		$("input[name=agitacion_severidad]").removeAttr('readonly');
		$("input[name=agitacion_angustia]").removeAttr('readonly');
	}

	$("select[name=depresion_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=depresion_frecuencia]").attr('readonly','readonly');
			$("input[name=depresion_severidad]").attr('readonly','readonly');
			$("input[name=depresion_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=depresion_frecuencia]").removeAttr('readonly');
			$("input[name=depresion_severidad]").removeAttr('readonly');
			$("input[name=depresion_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=depresion_status]").val() == 0){
		$("input[name=depresion_frecuencia]").attr('readonly','readonly');
		$("input[name=depresion_severidad]").attr('readonly','readonly');
		$("input[name=depresion_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=depresion_frecuencia]").removeAttr('readonly');
		$("input[name=depresion_severidad]").removeAttr('readonly');
		$("input[name=depresion_angustia]").removeAttr('readonly');
	}
	$("select[name=ansiedad_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=ansiedad_frecuencia]").attr('readonly','readonly');
			$("input[name=ansiedad_severidad]").attr('readonly','readonly');
			$("input[name=ansiedad_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=ansiedad_frecuencia]").removeAttr('readonly');
			$("input[name=ansiedad_severidad]").removeAttr('readonly');
			$("input[name=ansiedad_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=ansiedad_status]").val() == 0){
		$("input[name=ansiedad_frecuencia]").attr('readonly','readonly');
		$("input[name=ansiedad_severidad]").attr('readonly','readonly');
		$("input[name=ansiedad_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=ansiedad_frecuencia]").removeAttr('readonly');
		$("input[name=ansiedad_severidad]").removeAttr('readonly');
		$("input[name=ansiedad_angustia]").removeAttr('readonly');
	}

	$("select[name=elacion_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=elacion_frecuencia]").attr('readonly','readonly');
			$("input[name=elacion_severidad]").attr('readonly','readonly');
			$("input[name=elacion_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=elacion_frecuencia]").removeAttr('readonly');
			$("input[name=elacion_severidad]").removeAttr('readonly');
			$("input[name=elacion_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=elacion_status]").val() == 0){
		$("input[name=elacion_frecuencia]").attr('readonly','readonly');
		$("input[name=elacion_severidad]").attr('readonly','readonly');
		$("input[name=elacion_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=elacion_frecuencia]").removeAttr('readonly');
		$("input[name=elacion_severidad]").removeAttr('readonly');
		$("input[name=elacion_angustia]").removeAttr('readonly');
	}

	$("select[name=apatia_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=apatia_frecuencia]").attr('readonly','readonly');
			$("input[name=apatia_severidad]").attr('readonly','readonly');
			$("input[name=apatia_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=apatia_frecuencia]").removeAttr('readonly');
			$("input[name=apatia_severidad]").removeAttr('readonly');
			$("input[name=apatia_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=apatia_status]").val() == 0){
		$("input[name=apatia_frecuencia]").attr('readonly','readonly');
		$("input[name=apatia_severidad]").attr('readonly','readonly');
		$("input[name=apatia_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=apatia_frecuencia]").removeAttr('readonly');
		$("input[name=apatia_severidad]").removeAttr('readonly');
		$("input[name=apatia_angustia]").removeAttr('readonly');
	}

	$("select[name=deshinibicion_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=deshinibicion_frecuencia]").attr('readonly','readonly');
			$("input[name=deshinibicion_severidad]").attr('readonly','readonly');
			$("input[name=deshinibicion_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=deshinibicion_frecuencia]").removeAttr('readonly');
			$("input[name=deshinibicion_severidad]").removeAttr('readonly');
			$("input[name=deshinibicion_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=deshinibicion_status]").val() == 0){
		$("input[name=deshinibicion_frecuencia]").attr('readonly','readonly');
		$("input[name=deshinibicion_severidad]").attr('readonly','readonly');
		$("input[name=deshinibicion_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=deshinibicion_frecuencia]").removeAttr('readonly');
		$("input[name=deshinibicion_severidad]").removeAttr('readonly');
		$("input[name=deshinibicion_angustia]").removeAttr('readonly');
	}

	$("select[name=irritabilidad_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=irritabilidad_frecuencia]").attr('readonly','readonly');
			$("input[name=irritabilidad_severidad]").attr('readonly','readonly');
			$("input[name=irritabilidad_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=irritabilidad_frecuencia]").removeAttr('readonly');
			$("input[name=irritabilidad_severidad]").removeAttr('readonly');
			$("input[name=irritabilidad_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=irritabilidad_status]").val() == 0){
		$("input[name=irritabilidad_frecuencia]").attr('readonly','readonly');
		$("input[name=irritabilidad_severidad]").attr('readonly','readonly');
		$("input[name=irritabilidad_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=irritabilidad_frecuencia]").removeAttr('readonly');
		$("input[name=irritabilidad_severidad]").removeAttr('readonly');
		$("input[name=irritabilidad_angustia]").removeAttr('readonly');
	}

	$("select[name=conducta_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=conducta_frecuencia]").attr('readonly','readonly');
			$("input[name=conducta_severidad]").attr('readonly','readonly');
			$("input[name=conducta_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=conducta_frecuencia]").removeAttr('readonly');
			$("input[name=conducta_severidad]").removeAttr('readonly');
			$("input[name=conducta_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=conducta_status]").val() == 0){
		$("input[name=conducta_frecuencia]").attr('readonly','readonly');
		$("input[name=conducta_severidad]").attr('readonly','readonly');
		$("input[name=conducta_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=conducta_frecuencia]").removeAttr('readonly');
		$("input[name=conducta_severidad]").removeAttr('readonly');
		$("input[name=conducta_angustia]").removeAttr('readonly');
	}

	$("select[name=trastornos_sueno_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=trastornos_sueno_frecuencia]").attr('readonly','readonly');
			$("input[name=trastornos_sueno_severidad]").attr('readonly','readonly');
			$("input[name=trastornos_sueno_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=trastornos_sueno_frecuencia]").removeAttr('readonly');
			$("input[name=trastornos_sueno_severidad]").removeAttr('readonly');
			$("input[name=trastornos_sueno_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=trastornos_sueno_status]").val() == 0){
		$("input[name=trastornos_sueno_frecuencia]").attr('readonly','readonly');
		$("input[name=trastornos_sueno_severidad]").attr('readonly','readonly');
		$("input[name=trastornos_sueno_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=trastornos_sueno_frecuencia]").removeAttr('readonly');
		$("input[name=trastornos_sueno_severidad]").removeAttr('readonly');
		$("input[name=trastornos_sueno_angustia]").removeAttr('readonly');
	}

	$("select[name=trastornos_apetito_status]").change(function(){
		if($(this).val() == 0){
			$("input[name=trastornos_apetito_frecuencia]").attr('readonly','readonly');
			$("input[name=trastornos_apetito_severidad]").attr('readonly','readonly');
			$("input[name=trastornos_apetito_angustia]").attr('readonly','readonly');
		}
		else{
			$("input[name=trastornos_apetito_frecuencia]").removeAttr('readonly');
			$("input[name=trastornos_apetito_severidad]").removeAttr('readonly');
			$("input[name=trastornos_apetito_angustia]").removeAttr('readonly');
		}
	});
	if($("select[name=trastornos_apetito_status]").val() == 0){
		$("input[name=trastornos_apetito_frecuencia]").attr('readonly','readonly');
		$("input[name=trastornos_apetito_severidad]").attr('readonly','readonly');
		$("input[name=trastornos_apetito_angustia]").attr('readonly','readonly');
	}
	else{
		$("input[name=trastornos_apetito_frecuencia]").removeAttr('readonly');
		$("input[name=trastornos_apetito_severidad]").removeAttr('readonly');
		$("input[name=trastornos_apetito_angustia]").removeAttr('readonly');
	}



});