$(function(){
	$("input[name*=fecha_diagnostico]").datepicker({ dateFormat: 'dd/mm/yy' });


	$("input[name=hipertension]").change(function(){
		if($(this).val() == 0){			
			$('select[name*=hipertension]').val('');
			$('select[name*=hipertension] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=hipertension] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=ulcera]").change(function(){
		if($(this).val() == 0){
			$('select[name*=ulcera]').val('');			
			$('select[name*=ulcera] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=ulcera] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=diabetes]").change(function(){
		if($(this).val() == 0){
			$('select[name*=diabetes]').val('');
			$('select[name*=diabetes] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=diabetes] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=hipo_hipertiroidismo]").change(function(){
		if($(this).val() == 0){		
			$('select[name*=hipo_hipertiroidismo]').val('');	
			$('select[name*=hipo_hipertiroidismo] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=hipo_hipertiroidismo] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=hiperlipidemia]").change(function(){
		if($(this).val() == 0){		
			$('select[name*=hiperlipidemia]').val('');	
			$('select[name*=hiperlipidemia] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=hiperlipidemia] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=epoc]").change(function(){
		if($(this).val() == 0){			
			$('select[name*=epoc]').val('');
			$('select[name*=epoc] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=epoc] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=coronaria]").change(function(){
		if($(this).val() == 0){		
			$('select[name*=coronaria]').val('');	
			$('select[name*=coronaria] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=coronaria] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=rinitis]").change(function(){
		if($(this).val() == 0){			
			$('select[name*=rinitis]').val('');
			$('select[name*=rinitis] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=rinitis] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=acc_vascular]").change(function(){
		if($(this).val() == 0){			
			$('select[name*=acc_vascular]').val('');
			$('select[name*=acc_vascular] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=acc_vascular] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=asma]").change(function(){
		if($(this).val() == 0){	
			$('select[name*=asma]').val('');		
			$('select[name*=asma] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=asma] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=gastritis]").change(function(){
		if($(this).val() == 0){	
			$('select[name*=gastritis]').val('');		
			$('select[name*=gastritis] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=gastritis] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	$("input[name=cefaleas]").change(function(){
		if($(this).val() == 0){			
			$('select[name*=cefaleas]').val('');
			$('select[name*=cefaleas] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		}
		else{
			$('select[name*=cefaleas] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	/*---------*/
	$("input[name=alergia]").change(function(){
		if($(this).val() == 0){
			$("#alergia_desc").val('');
			$("#alergia_desc").attr('readonly','readonly');			
		}
		else{
			$("#alergia_desc").removeAttr('readonly');			
		}
	});

	$("input[name=tabaquismo]").change(function(){
		if($(this).val() == 0){
			$("#tabaquismo_desc").val('');
			$("#tabaquismo_desc").attr('readonly','readonly');			
		}
		else{
			$("#tabaquismo_desc").removeAttr('readonly');			
		}
	});
	$("input[name=ingesta_alcohol]").change(function(){
		if($(this).val() == 0){
			$("#ingesta_alcohol_desc").val('');
			$("#ingesta_alcohol_desc").attr('readonly','readonly');			
		}
		else{
			$("#ingesta_alcohol_desc").removeAttr('readonly');			
		}
	});
	$("input[name=drogas]").change(function(){
		if($(this).val() == 0){
			$("#drogas_desc").val('');
			$("#drogas_desc").attr('readonly','readonly');			
		}
		else{
			$("#drogas_desc").removeAttr('readonly');			
		}
	});
	$("input[name=cirugia]").change(function(){
		if($(this).val() == 0){
			$("#cirugia_desc").val('');
			$("#cirugia_desc").attr('readonly','readonly');			
		}
		else{
			$("#cirugia_desc").removeAttr('readonly');			
		}
	});
	$("input[name=donado_sangre]").change(function(){
		if($(this).val() == 0){
			$("#donado_sangre_desc").val('');
			$("#donado_sangre_desc").attr('readonly','readonly');			
		}
		else{
			$("#donado_sangre_desc").removeAttr('readonly');			
		}
	});
	$("input[name=tratamiento_farma]").change(function(){
		if($(this).val() == 0){
			$("#tratamiento_farma_desc").val('');
			$("#tratamiento_farma_desc").attr('readonly','readonly');			
		}
		else{
			$("#tratamiento_farma_desc").removeAttr('readonly');			
		}
	});
	$("input[name=suplemento_dietetico]").change(function(){
		if($(this).val() == 0){
			$("#suplemento_dietetico_desc").val('');
			$("#suplemento_dietetico_desc").attr('readonly','readonly');			
		}
		else{
			$("#suplemento_dietetico_desc").removeAttr('readonly');			
		}
	});
	$("input[name=alzheimer]").change(function(){
		if($(this).val() == 0){
			$("#alzheimer_desc").val('');
			$("#alzheimer_desc").attr('readonly','readonly');			
		}
		else{
			$("#alzheimer_desc").removeAttr('readonly');			
		}
	});
	$("input[name=morbido]").change(function(){
		if($(this).val() == 0){
			$("#morbido_desc").val('');
			$("#morbido_desc").attr('readonly','readonly');			
		}
		else{
			$("#morbido_desc").removeAttr('readonly');			
		}
	});
	
	/*--------------------------------------------------*/
	
	if($("input[name=hipertension]:checked").val() == 0){
		$('select[name*=hipertension] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=hipertension] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}
	
	if($("input[name=ulcera]:checked").val() == 0){
		$('select[name*=ulcera] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=ulcera] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=diabetes]:checked").val() == 0){
		$('select[name*=diabetes] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=diabetes] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=hipo_hipertiroidismo]:checked").val() == 0){
		$('select[name*=hipo_hipertiroidismo] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=hipo_hipertiroidismo] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=hiperlipidemia]:checked").val() == 0){
		$('select[name*=hiperlipidemia] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=hiperlipidemia] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=epoc]:checked").val() == 0){
		$('select[name*=epoc] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=epoc] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=coronaria]:checked").val() == 0){
		$('select[name*=coronaria] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=coronaria] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=rinitis]:checked").val() == 0){
		$('select[name*=rinitis] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=rinitis] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=acc_vascular]:checked").val() == 0){
		$('select[name*=acc_vascular] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=acc_vascular] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=asma]:checked").val() == 0){
		$('select[name*=asma] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=asma] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=gastritis]:checked").val() == 0){
		$('select[name*=gastritis] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=gastritis] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	if($("input[name=cefaleas]:checked").val() == 0){
		$('select[name*=cefaleas] option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	}
	else{
		$('select[name*=cefaleas] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	/*-----*/

	if($("input[name=alergia]").val() == 0){
		$("#alergia_desc").attr('readonly','readonly');		
	}
	else{
		$("#alergia_desc").removeAttr('readonly');		
	}

	if($("input[name=tabaquismo]").val() == 0){
		$("#tabaquismo_desc").attr('readonly','readonly');		
	}
	else{
		$("#tabaquismo_desc").removeAttr('readonly');		
	}

	if($("input[name=ingesta_alcohol]").val() == 0){
		$("#ingesta_alcohol_desc").attr('readonly','readonly');		
	}
	else{
		$("#ingesta_alcohol_desc").removeAttr('readonly');		
	}

	if($("input[name=drogas]").val() == 0){
		$("#drogas_desc").attr('readonly','readonly');		
	}
	else{
		$("#drogas_desc").removeAttr('readonly');		
	}

	if($("input[name=cirugia]").val() == 0){
		$("#cirugia_desc").attr('readonly','readonly');		
	}
	else{
		$("#cirugia_desc").removeAttr('readonly');		
	}

	if($("input[name=donado_sangre]").val() == 0){
		$("#donado_sangre_desc").attr('readonly','readonly');		
	}
	else{
		$("#donado_sangre_desc").removeAttr('readonly');		
	}

	if($("input[name=tratamiento_farma]").val() == 0){
		$("#tratamiento_farma_desc").attr('readonly','readonly');		
	}
	else{
		$("#tratamiento_farma_desc").removeAttr('readonly');		
	}

	if($("input[name=suplemento_dietetico]").val() == 0){
		$("#suplemento_dietetico_desc").attr('readonly','readonly');		
	}
	else{
		$("#suplemento_dietetico_desc").removeAttr('readonly');		
	}

	if($("input[name=alzheimer]").val() == 0){
		$("#alzheimer_desc").attr('readonly','readonly');		
	}
	else{
		$("#alzheimer_desc").removeAttr('readonly');		
	}

	if($("input[name=morbido]").val() == 0){
		$("#morbido_desc").attr('readonly','readonly');		
	}
	else{
		$("#morbido_desc").removeAttr('readonly');		
	}
	

});