$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("select[name*=frecuencia], select[name*=severidad], select[name*=angustia], input[name=fecha]").attr('readonly','readonly');
			$("#form_npi :input").each(function(){
				
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$('select option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});

		}else{
			$("select[name*=frecuencia], select[name*=severidad], select[name*=angustia], input[name=fecha]").removeAttr('readonly');
			$("input[name=puntaje_total_para_angustia]").attr('readonly','readonly');
			$('select option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() != 1){
		$("select[name*=frecuencia], select[name*=severidad], select[name*=angustia], input[name=fecha]").attr('readonly','readonly');		
		$("#form_npi :input").each(function(){
			if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
				$(this).val('');
			}
		});
		$('select option:not()').each(function(){
			$(this).attr('disabled', 'disabled');
		});

	}else{
		$("select[name*=frecuencia], select[name*=severidad], select[name*=angustia], input[name=fecha]").removeAttr('readonly');
		$("input[name=puntaje_total_para_angustia]").attr('readonly','readonly');		
		$('select option:not()').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	$("select[name*=delirio]").change(function(){		
		if($("#delirio_frecuencia option:selected").text() != '' && $("#delirio_severidad option:selected").text() != ''){
			
			var puntaje = parseInt($("#delirio_frecuencia option:selected").text()) * parseInt($("#delirio_severidad option:selected").text());

			$("input[name=delirio_puntaje]").val(puntaje);
				
			var total = 0;
			$("input[name*=_puntaje]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected', this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);			
		}
		else{
			$("input[name=delirio_puntaje]").val('');
		}
	});
	$("select[name*=alucinaciones]").change(function(){
		if($("#alucinaciones_frecuencia option:selected").text() != '' && $("#alucinaciones_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#alucinaciones_frecuencia option:selected").text()) * parseInt($("#alucinaciones_severidad option:selected").text());

			$("input[name=alucinaciones_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}else{
			$("input[name=alucinaciones_puntaje]").val('');
		}
	});
	$("select[name*=agitacion]").change(function(){
		if($("#agitacion_frecuencia option:selected").text() != '' && $("#agitacion_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#agitacion_frecuencia option:selected").text()) * parseInt($("#agitacion_severidad option:selected").text());

			$("input[name=agitacion_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}else{
			$("input[name=agitacion_puntaje]").val('');
		}
	});
	
	$("select[name*=depresion]").change(function(){
		if($("#depresion_frecuencia option:selected").text() != '' && $("#depresion_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#depresion_frecuencia option:selected").text()) * parseInt($("#depresion_severidad option:selected").text());

			$("input[name=depresion_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}else{
			$("input[name=depresion_puntaje]").val('');
		}
	});
	
	$("select[name*=ansiedad]").change(function(){
		if($("#ansiedad_frecuencia option:selected").text() != '' && $("#ansiedad_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#ansiedad_frecuencia option:selected").text()) * parseInt($("#ansiedad_severidad option:selected").text());

			$("input[name=ansiedad_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}else{
			$("input[name=ansiedad_puntaje]").val('');
		}
	});
	
	$("select[name*=elacion]").change(function(){
		if($("#elacion_frecuencia option:selected").text() != '' && $("#elacion_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#elacion_frecuencia option:selected").text()) * parseInt($("#elacion_severidad option:selected").text());

			$("input[name=elacion_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}else{
			$("input[name=elacion_puntaje]").val('');
		}
	});
	
	$("select[name*=apatia]").change(function(){
		if($("#apatia_frecuencia option:selected").text() != '' && $("#apatia_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#apatia_frecuencia option:selected").text()) * parseInt($("#apatia_severidad option:selected").text());

			$("input[name=apatia_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}
		else{
			$("input[name=apatia_puntaje]").val('');	
		}
	});
	
	$("select[name*=deshinibicion]").change(function(){
		if($("#deshinibicion_frecuencia option:selected").text() != '' && $("#deshinibicion_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#deshinibicion_frecuencia option:selected").text()) * parseInt($("#deshinibicion_severidad option:selected").text());

			$("input[name=deshinibicion_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}else{
			$("input[name=deshinibicion_puntaje]").val('');
		}
	});
	
	$("select[name*=irritabilidad]").change(function(){
		if($("#irritabilidad_frecuencia option:selected").text() != '' && $("#irritabilidad_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#irritabilidad_frecuencia option:selected").text()) * parseInt($("#irritabilidad_severidad option:selected").text());

			$("input[name=irritabilidad_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}else{
			$("input[name=irritabilidad_puntaje]").val('');
		}
	});
	
	$("select[name*=conducta]").change(function(){
		if($("#conducta_frecuencia option:selected").text() != '' && $("#conducta_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#conducta_frecuencia option:selected").text()) * parseInt($("#conducta_severidad option:selected").text());

			$("input[name=conducta_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);
			
		}else{
			$("input[name=conducta_puntaje]").val('');
		}
	});
	
	$("select[name*=trastornos_sueno]").change(function(){
		if($("#trastornos_sueno_frecuencia option:selected").text() != '' && $("#trastornos_sueno_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#trastornos_sueno_frecuencia option:selected").text()) * parseInt($("#trastornos_sueno_severidad option:selected").text());

			$("input[name=trastornos_sueno_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			
		}else{
			$("input[name=trastornos_sueno_puntaje]").val('');
		}
	});
	
	$("select[name*=trastornos_apetito]").change(function(){
		if($("#trastornos_apetito_frecuencia option:selected").text() != '' && $("#trastornos_apetito_severidad option:selected").text() != ''){

			var puntaje = parseInt($("#trastornos_apetito_frecuencia option:selected").text()) * parseInt($("#trastornos_apetito_severidad option:selected").text());

			$("input[name=trastornos_apetito_puntaje]").val(puntaje);
			var total = 0;
			$("input[name*=_puntaje]").each(function(){				
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $('option:selected',this).text() != ''){					
					total2 = parseInt(total2) + parseInt($('option:selected',this).text());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		}else{
			$("input[name=trastornos_apetito_puntaje]").val('');
		}
	});
	
	/*Puntaje Total*/
	$("input[name*=_puntaje]").change(function(){
		var total = 0;
		$("input[name*=_puntaje]").each(function(){						
			if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
				total = parseInt(total) + parseInt($(this).val());								
			}
		});
		$('#puntaje_total_npi').val(total);
	});	
	/*Angustia Total*/
	$("input[name*=_angustia]").change(function(){
		var total2 = 0;
		$("select[name*=angustia]").each(function(){	
			if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
				total2 = parseInt(total2) + parseInt($(this).val());							
			}
		});
		$('#puntaje_total_para_angustia').val(total2);
	});

	/*Campos disponibles*/
	$("select[name=delirio_status]").change(function(){
		if($(this).val() == 0){
			$("#delirio_frecuencia").attr('readonly','readonly');			
			$("#delirio_severidad").attr('readonly','readonly');
			$("#delirio_angustia").attr('readonly','readonly');

			$("#delirio_frecuencia").val('');
			$("#delirio_severidad").val('');
			$("#delirio_angustia").val('');			
			$("#delirio_puntaje").val('');
			
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){					
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);

			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){						
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#delirio_frecuencia option:not(), #delirio_severidad option:not(), #delirio_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#delirio_frecuencia").removeAttr('readonly');
			$("#delirio_severidad").removeAttr('readonly');
			$("#delirio_angustia").removeAttr('readonly');
			$('#delirio_frecuencia option:not(), #delirio_severidad option:not(), #delirio_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=delirio_status]").val() == 0){
		$("#delirio_frecuencia").attr('readonly','readonly');
		$("#delirio_severidad").attr('readonly','readonly');
		$("#delirio_angustia").attr('readonly','readonly');

		$("#delirio_frecuencia").val('');
		$("#delirio_severidad").val('');
		$("#delirio_angustia").val('');		
		$("#delirio_puntaje").val('');
		var total = 0;
		$("input[name*=_puntaje]").each(function(){						
			if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
				total = parseInt(total) + parseInt($(this).val());								
			}
		});
		$('#puntaje_total_npi').val(total);
		var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#delirio_frecuencia option:not(), #delirio_severidad option:not(), #delirio_angustia option:not()').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$("#delirio_frecuencia").removeAttr('readonly');
		$("#delirio_severidad").removeAttr('readonly');
		$("#delirio_angustia").removeAttr('readonly');
		$('#delirio_frecuencia option:not(), #delirio_severidad option:not(), #delirio_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=alucinaciones_status]").change(function(){
		if($(this).val() == 0){
			$("#alucinaciones_frecuencia").attr('readonly','readonly');
			$("#alucinaciones_severidad").attr('readonly','readonly');
			$("#alucinaciones_angustia").attr('readonly','readonly');
			
			$("#alucinaciones_frecuencia").val('');
			$("#alucinaciones_severidad").val('');
			$("#alucinaciones_angustia").val('');			
			$("#alucinaciones_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#alucinaciones_frecuencia option:not(), #alucinaciones_severidad option:not(), #alucinaciones_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#alucinaciones_frecuencia").removeAttr('readonly');
			$("#alucinaciones_severidad").removeAttr('readonly');
			$("#alucinaciones_angustia").removeAttr('readonly');
			$('#alucinaciones_frecuencia option:not(), #alucinaciones_severidad option:not(), #alucinaciones_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=alucinaciones_status]").val() == 0){
		$("#alucinaciones_frecuencia").attr('readonly','readonly');
		$("#alucinaciones_severidad").attr('readonly','readonly');
		$("#alucinaciones_angustia").attr('readonly','readonly');
		
			$("#alucinaciones_frecuencia").val('');
			$("#alucinaciones_severidad").val('');
			$("#alucinaciones_angustia").val('');			
			$("#alucinaciones_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#alucinaciones_frecuencia option:not(), #alucinaciones_severidad option:not(), #alucinaciones_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#alucinaciones_frecuencia").removeAttr('readonly');
		$("#alucinaciones_severidad").removeAttr('readonly');
		$("#alucinaciones_angustia").removeAttr('readonly');
		$('#alucinaciones_frecuencia option:not(), #alucinaciones_severidad option:not(), #alucinaciones_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=agitacion_status]").change(function(){
		if($(this).val() == 0){
			$("#agitacion_frecuencia").attr('readonly','readonly');
			$("#agitacion_severidad").attr('readonly','readonly');
			$("#agitacion_angustia").attr('readonly','readonly');

			$("#agitacion_frecuencia").val('');
			$("#agitacion_severidad").val('');
			$("#agitacion_angustia").val('');			
			$("#agitacion_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#agitacion_frecuencia option:not(), #agitacion_frecuencia option:not(), #agitacion_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#agitacion_frecuencia").removeAttr('readonly');
			$("#agitacion_severidad").removeAttr('readonly');
			$("#agitacion_angustia").removeAttr('readonly');
			$('#agitacion_frecuencia option:not(), #agitacion_severidad option:not(), #agitacion_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=agitacion_status]").val() == 0){
		$("#agitacion_frecuencia").attr('readonly','readonly');
		$("#agitacion_severidad").attr('readonly','readonly');
		$("#agitacion_angustia").attr('readonly','readonly');

			$("#agitacion_frecuencia").val('');
			$("#agitacion_severidad").val('');
			$("#agitacion_angustia").val('');			
			$("#agitacion_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#agitacion_frecuencia option:not(), #agitacion_frecuencia option:not(), #agitacion_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#agitacion_frecuencia").removeAttr('readonly');
		$("#agitacion_severidad").removeAttr('readonly');
		$("#agitacion_angustia").removeAttr('readonly');
		$('#agitacion_frecuencia option:not(), #agitacion_severidad option:not(), #agitacion_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=depresion_status]").change(function(){
		if($(this).val() == 0){
			$("#depresion_frecuencia").attr('readonly','readonly');
			$("#depresion_severidad").attr('readonly','readonly');
			$("#depresion_angustia").attr('readonly','readonly');

			$("#depresion_frecuencia").val('');
			$("#depresion_severidad").val('');
			$("#depresion_angustia").val('');			
			$("#depresion_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#depresion_frecuencia option:not(), #depresion_severidad option:not(), #depresion_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#depresion_frecuencia").removeAttr('readonly');
			$("#depresion_severidad").removeAttr('readonly');
			$("#depresion_angustia").removeAttr('readonly');
			$('#depresion_frecuencia option:not(), #depresion_severidad option:not(), #depresion_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=depresion_status]").val() == 0){
		$("#depresion_frecuencia").attr('readonly','readonly');
		$("#depresion_severidad").attr('readonly','readonly');
		$("#depresion_angustia").attr('readonly','readonly');

			$("#depresion_frecuencia").val('');
			$("#depresion_severidad").val('');
			$("#depresion_angustia").val('');			
			$("#depresion_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#depresion_frecuencia option:not(), #depresion_severidad option:not(), #depresion_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#depresion_frecuencia").removeAttr('readonly');
		$("#depresion_severidad").removeAttr('readonly');
		$("#depresion_angustia").removeAttr('readonly');
		$('#depresion_frecuencia option:not(), #depresion_severidad option:not(), #depresion_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}
	$("select[name=ansiedad_status]").change(function(){
		if($(this).val() == 0){
			$("#ansiedad_frecuencia").attr('readonly','readonly');
			$("#ansiedad_severidad").attr('readonly','readonly');
			$("#ansiedad_angustia").attr('readonly','readonly');

			$("#ansiedad_frecuencia").val('');
			$("#ansiedad_severidad").val('');
			$("#ansiedad_angustia").val('');			
			$("#ansiedad_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#ansiedad_frecuencia option:not(), #ansiedad_severidad option:not(), #ansiedad_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#ansiedad_frecuencia").removeAttr('readonly');
			$("#ansiedad_severidad").removeAttr('readonly');
			$("#ansiedad_angustia").removeAttr('readonly');
			$('#ansiedad_frecuencia option:not(), #ansiedad_severidad option:not(), #ansiedad_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=ansiedad_status]").val() == 0){
		$("#ansiedad_frecuencia").attr('readonly','readonly');
		$("#ansiedad_severidad").attr('readonly','readonly');
		$("#ansiedad_angustia").attr('readonly','readonly');

			$("#ansiedad_frecuencia").val('');
			$("#ansiedad_severidad").val('');
			$("#ansiedad_angustia").val('');			
			$("#ansiedad_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#ansiedad_frecuencia option:not(), #ansiedad_severidad option:not(), #ansiedad_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#ansiedad_frecuencia").removeAttr('readonly');
		$("#ansiedad_severidad").removeAttr('readonly');
		$("#ansiedad_angustia").removeAttr('readonly');
		$('#ansiedad_frecuencia option:not(), #ansiedad_severidad option:not(), #ansiedad_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=elacion_status]").change(function(){
		if($(this).val() == 0){
			$("#elacion_frecuencia").attr('readonly','readonly');
			$("#elacion_severidad").attr('readonly','readonly');
			$("#elacion_angustia").attr('readonly','readonly');

			$("#elacion_frecuencia").val('');
			$("#elacion_severidad").val('');
			$("#elacion_angustia").val('');			
			$("#elacion_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#elacion_frecuencia option:not(), #elacion_severidad option:not(), #elacion_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#elacion_frecuencia").removeAttr('readonly');
			$("#elacion_severidad").removeAttr('readonly');
			$("#elacion_angustia").removeAttr('readonly');
			$('#elacion_frecuencia option:not(), #elacion_severidad option:not(), #elacion_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=elacion_status]").val() == 0){
		$("#elacion_frecuencia").attr('readonly','readonly');
		$("#elacion_severidad").attr('readonly','readonly');
		$("#elacion_angustia").attr('readonly','readonly');

			$("#elacion_frecuencia").val('');
			$("#elacion_severidad").val('');
			$("#elacion_angustia").val('');			
			$("#elacion_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#elacion_frecuencia option:not(), #elacion_severidad option:not(), #elacion_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#elacion_frecuencia").removeAttr('readonly');
		$("#elacion_severidad").removeAttr('readonly');
		$("#elacion_angustia").removeAttr('readonly');
		$('#elacion_frecuencia option:not(), #elacion_severidad option:not(), #elacion_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=apatia_status]").change(function(){
		if($(this).val() == 0){
			$("#apatia_frecuencia").attr('readonly','readonly');
			$("#apatia_severidad").attr('readonly','readonly');
			$("#apatia_angustia").attr('readonly','readonly');

			$("#apatia_frecuencia").val('');
			$("#apatia_severidad").val('');
			$("#apatia_angustia").val('');			
			$("#apatia_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#apatia_frecuencia option:not(), #apatia_severidad option:not(), #apatia_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#apatia_frecuencia").removeAttr('readonly');
			$("#apatia_severidad").removeAttr('readonly');
			$("#apatia_angustia").removeAttr('readonly');
			$('#apatia_frecuencia option:not(), #apatia_severidad option:not(), #apatia_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=apatia_status]").val() == 0){
		$("#apatia_frecuencia").attr('readonly','readonly');
		$("#apatia_severidad").attr('readonly','readonly');
		$("#apatia_angustia").attr('readonly','readonly');

			$("#apatia_frecuencia").val('');
			$("#apatia_severidad").val('');
			$("#apatia_angustia").val('');			
			$("#apatia_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#apatia_frecuencia option:not(), #apatia_severidad option:not(), #apatia_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#apatia_frecuencia").removeAttr('readonly');
		$("#apatia_severidad").removeAttr('readonly');
		$("#apatia_angustia").removeAttr('readonly');
		$('#apatia_frecuencia option:not(), #apatia_severidad option:not(), #apatia_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=deshinibicion_status]").change(function(){
		if($(this).val() == 0){
			$("#deshinibicion_frecuencia").attr('readonly','readonly');
			$("#deshinibicion_severidad").attr('readonly','readonly');
			$("#deshinibicion_angustia").attr('readonly','readonly');

			$("#deshinibicion_frecuencia").val('');
			$("#deshinibicion_severidad").val('');
			$("#deshinibicion_angustia").val('');			
			$("#deshinibicion_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#deshinibicion_frecuencia option:not(), #deshinibicion_severidad option:not(), #deshinibicion_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#deshinibicion_frecuencia").removeAttr('readonly');
			$("#deshinibicion_severidad").removeAttr('readonly');
			$("#deshinibicion_angustia").removeAttr('readonly');
			$('#deshinibicion_frecuencia option:not(), #deshinibicion_severidad option:not(), #deshinibicion_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=deshinibicion_status]").val() == 0){
		$("#deshinibicion_frecuencia").attr('readonly','readonly');
		$("#deshinibicion_severidad").attr('readonly','readonly');
		$("#deshinibicion_angustia").attr('readonly','readonly');

			$("#deshinibicion_frecuencia").val('');
			$("#deshinibicion_severidad").val('');
			$("#deshinibicion_angustia").val('');			
			$("#deshinibicion_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#deshinibicion_frecuencia option:not(), #deshinibicion_severidad option:not(), #deshinibicion_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#deshinibicion_frecuencia").removeAttr('readonly');
		$("#deshinibicion_severidad").removeAttr('readonly');
		$("#deshinibicion_angustia").removeAttr('readonly');
		$('#deshinibicion_frecuencia option:not(), #deshinibicion_severidad option:not(), #deshinibicion_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=irritabilidad_status]").change(function(){
		if($(this).val() == 0){
			$("#irritabilidad_frecuencia").attr('readonly','readonly');
			$("#irritabilidad_severidad").attr('readonly','readonly');
			$("#irritabilidad_angustia").attr('readonly','readonly');

			$("#irritabilidad_frecuencia").val('');
			$("#irritabilidad_severidad").val('');
			$("#irritabilidad_angustia").val('');			
			$("#irritabilidad_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#irritabilidad_frecuencia option:not(), #irritabilidad_severidad option:not(), #irritabilidad_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#irritabilidad_frecuencia").removeAttr('readonly');
			$("#irritabilidad_severidad").removeAttr('readonly');
			$("#irritabilidad_angustia").removeAttr('readonly');
			$('#irritabilidad_frecuencia option:not(), #irritabilidad_severidad option:not(), #irritabilidad_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=irritabilidad_status]").val() == 0){
		$("#irritabilidad_frecuencia").attr('readonly','readonly');
		$("#irritabilidad_severidad").attr('readonly','readonly');
		$("#irritabilidad_angustia").attr('readonly','readonly');

			$("#irritabilidad_frecuencia").val('');
			$("#irritabilidad_severidad").val('');
			$("#irritabilidad_angustia").val('');			
			$("#irritabilidad_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#irritabilidad_frecuencia option:not(), #irritabilidad_severidad option:not(), #irritabilidad_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#irritabilidad_frecuencia").removeAttr('readonly');
		$("#irritabilidad_severidad").removeAttr('readonly');
		$("#irritabilidad_angustia").removeAttr('readonly');
		$('#irritabilidad_frecuencia option:not(), #irritabilidad_severidad option:not(), #irritabilidad_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=conducta_status]").change(function(){
		if($(this).val() == 0){
			$("#conducta_frecuencia").attr('readonly','readonly');
			$("#conducta_severidad").attr('readonly','readonly');
			$("#conducta_angustia").attr('readonly','readonly');

			$("#conducta_frecuencia").val('');
			$("#conducta_severidad").val('');
			$("#conducta_angustia").val('');			
			$("#conducta_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#conducta_frecuencia option:not(), #conducta_severidad option:not(), #conducta_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#conducta_frecuencia").removeAttr('readonly');
			$("#conducta_severidad").removeAttr('readonly');
			$("#conducta_angustia").removeAttr('readonly');
			$('#conducta_frecuencia option:not(), #conducta_severidad option:not(), #conducta_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=conducta_status]").val() == 0){
		$("#conducta_frecuencia").attr('readonly','readonly');
		$("#conducta_severidad").attr('readonly','readonly');
		$("#conducta_angustia").attr('readonly','readonly');

			$("#conducta_frecuencia").val('');
			$("#conducta_severidad").val('');
			$("#conducta_angustia").val('');			
			$("#conducta_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#conducta_frecuencia option:not(), #conducta_severidad option:not(), #conducta_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#conducta_frecuencia").removeAttr('readonly');
		$("#conducta_severidad").removeAttr('readonly');
		$("#conducta_angustia").removeAttr('readonly');
		$('#conducta_frecuencia option:not(), #conducta_severidad option:not(), #conducta_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=trastornos_sueno_status]").change(function(){
		if($(this).val() == 0){
			$("#trastornos_sueno_frecuencia").attr('readonly','readonly');
			$("#trastornos_sueno_severidad").attr('readonly','readonly');
			$("#trastornos_sueno_angustia").attr('readonly','readonly');

			$("#trastornos_sueno_frecuencia").val('');
			$("#trastornos_sueno_severidad").val('');
			$("#trastornos_sueno_angustia").val('');			
			$("#trastornos_sueno_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#trastornos_sueno_status option:not(), #trastornos_sueno_severidad option:not(), #trastornos_sueno_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#trastornos_sueno_frecuencia").removeAttr('readonly');
			$("#trastornos_sueno_severidad").removeAttr('readonly');
			$("#trastornos_sueno_angustia").removeAttr('readonly');
			$('#trastornos_sueno_frecuencia option:not(), #trastornos_sueno_severidad option:not(), #trastornos_sueno_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=trastornos_sueno_status]").val() == 0){
		$("#trastornos_sueno_frecuencia").attr('readonly','readonly');
		$("#trastornos_sueno_severidad").attr('readonly','readonly');
		$("#trastornos_sueno_angustia").attr('readonly','readonly');

			$("#trastornos_sueno_frecuencia").val('');
			$("#trastornos_sueno_severidad").val('');
			$("#trastornos_sueno_angustia").val('');			
			$("#trastornos_sueno_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#trastornos_sueno_status option:not(), #trastornos_sueno_severidad option:not(), #trastornos_sueno_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#trastornos_sueno_frecuencia").removeAttr('readonly');
		$("#trastornos_sueno_severidad").removeAttr('readonly');
		$("#trastornos_sueno_angustia").removeAttr('readonly');
		$('#trastornos_sueno_frecuencia option:not(), #trastornos_sueno_severidad option:not(), #trastornos_sueno_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
	}

	$("select[name=trastornos_apetito_status]").change(function(){
		if($(this).val() == 0){
			$("#trastornos_apetito_frecuencia").attr('readonly','readonly');
			$("#trastornos_apetito_severidad").attr('readonly','readonly');
			$("#trastornos_apetito_angustia").attr('readonly','readonly');

			$("#trastornos_apetito_frecuencia").val('');
			$("#trastornos_apetito_severidad").val('');
			$("#trastornos_apetito_angustia").val('');			
			$("#trastornos_apetito_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

			$('#trastornos_apetito_frecuencia option:not(), #trastornos_apetito_severidad option:not(), #trastornos_apetito_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$("#trastornos_apetito_frecuencia").removeAttr('readonly');
			$("#trastornos_apetito_severidad").removeAttr('readonly');
			$("#trastornos_apetito_angustia").removeAttr('readonly');
			$('#trastornos_apetito_frecuencia option:not(), #trastornos_apetito_severidad option:not(), #trastornos_apetito_angustia option:not()').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("select[name=trastornos_apetito_status]").val() == 0){
		$("#trastornos_apetito_frecuencia").attr('readonly','readonly');
		$("#trastornos_apetito_severidad").attr('readonly','readonly');
		$("#trastornos_apetito_angustia").attr('readonly','readonly');

			$("#trastornos_apetito_frecuencia").val('');
			$("#trastornos_apetito_severidad").val('');
			$("#trastornos_apetito_angustia").val('');			
			$("#trastornos_apetito_puntaje").val('');
			var total = 0;
			$("input[name*=_puntaje]").each(function(){						
				if($(this).attr('id') != 'puntaje_total_npi' && $(this).val() != ''){
					total = parseInt(total) + parseInt($(this).val());								
				}
			});
			$('#puntaje_total_npi').val(total);
			var total2 = 0;
			$("select[name*=angustia]").each(function(){	
				if($(this).attr('id') != 'puntaje_total_para_angustia' && $(this).val() != '' && $(this).val() != null){					
					total2 = parseInt(total2) + parseInt($(this).val());							
				}
			});
			$('#puntaje_total_para_angustia').val(total2);

		$('#trastornos_apetito_frecuencia option:not(), #trastornos_apetito_severidad option:not(), #trastornos_apetito_angustia option:not()').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	}
	else{
		$("#trastornos_apetito_frecuencia").removeAttr('readonly');
		$("#trastornos_apetito_severidad").removeAttr('readonly');
		$("#trastornos_apetito_angustia").removeAttr('readonly');
		$('#trastornos_apetito_frecuencia option:not(), #trastornos_apetito_severidad option:not(), #trastornos_apetito_angustia option:not()').each(function(){
			$(this).removeAttr('disabled');
		});
	}



});