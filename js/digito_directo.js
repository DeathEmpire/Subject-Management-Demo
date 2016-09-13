$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });		

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_digito_directo :input").attr('readonly','readonly');
			$("#form_digito_directo :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).attr('type') == 'select')){
					$(this).val('');
				}
			});
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_digito_directo :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_digito_directo :input").attr('readonly','readonly');
		$("#form_digito_directo :input").each(function(){
			if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).attr('type') == 'select')){
				$(this).val('');
			}
		});
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_digito_directo :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}

	$("#puntaje_intento_1a, #puntaje_intento_1b").change(function(){
		$('select[name=puntaje_item_1a] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
		var puntaje = (parseInt($("#puntaje_intento_1a").val()) || 0) + (parseInt($("#puntaje_intento_1b").val()) || 0);		
		$("#puntaje_item_1a option[value="+puntaje+"]").prop('selected',true);
		$('select[name=puntaje_item_1a] option:not(:selected)').each(function(){
			$(this).attr('disabled','disabled');
		});		
		var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});

	$("#puntaje_intento_2a, #puntaje_intento_2b").change(function(){
		$('select[name=puntaje_item_2a] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
		var puntaje = (parseInt($("#puntaje_intento_2a").val()) || 0) + (parseInt($("#puntaje_intento_2b").val()) || 0);		
		$("#puntaje_item_2a option[value="+puntaje+"]").prop('selected',true);
		$('select[name=puntaje_item_2a] option:not(:selected)').each(function(){
			$(this).attr('disabled','disabled');
		});
		var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});

	$("#puntaje_intento_3a, #puntaje_intento_3b").change(function(){
		$('select[name=puntaje_item_3a] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
		var puntaje = (parseInt($("#puntaje_intento_3a").val()) || 0) + (parseInt($("#puntaje_intento_3b").val()) || 0);		
		$("#puntaje_item_3a option[value="+puntaje+"]").prop('selected',true);
		$('select[name=puntaje_item_3a] option:not(:selected)').each(function(){
			$(this).attr('disabled','disabled');
		});		
		var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});

	$("#puntaje_intento_4a, #puntaje_intento_4b").change(function(){
		$('select[name=puntaje_item_4a] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
		var puntaje = (parseInt($("#puntaje_intento_4a").val()) || 0) + (parseInt($("#puntaje_intento_4b").val()) || 0);		
		$("#puntaje_item_4a option[value="+puntaje+"]").prop('selected',true);	
		$('select[name=puntaje_item_4a] option:not(:selected)').each(function(){
			$(this).attr('disabled','disabled');
		});	
		var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});

	$("#puntaje_intento_5a, #puntaje_intento_5b").change(function(){
		$('select[name=puntaje_item_5a] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
		var puntaje = (parseInt($("#puntaje_intento_5a").val()) || 0) + (parseInt($("#puntaje_intento_5b").val()) || 0);		
		$("#puntaje_item_5a option[value="+puntaje+"]").prop('selected',true);
		$('select[name=puntaje_item_5a] option:not(:selected)').each(function(){
			$(this).attr('disabled','disabled');
		});		
		var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});

	$("#puntaje_intento_6a, #puntaje_intento_6b").change(function(){
		$('select[name=puntaje_item_6a] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
		var puntaje = (parseInt($("#puntaje_intento_6a").val()) || 0) + (parseInt($("#puntaje_intento_6b").val()) || 0);		
		$("#puntaje_item_6a option[value="+puntaje+"]").prop('selected',true);	
		$('select[name=puntaje_item_6a] option:not(:selected)').each(function(){
			$(this).attr('disabled','disabled');
		});	
		var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});

	$("#puntaje_intento_7a, #puntaje_intento_7b").change(function(){
		$('select[name=puntaje_item_7a] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
		var puntaje = (parseInt($("#puntaje_intento_7a").val()) || 0) + (parseInt($("#puntaje_intento_7b").val()) || 0);		
		$("#puntaje_item_7a option[value="+puntaje+"]").prop('selected',true);	
		$('select[name=puntaje_item_7a] option:not(:selected)').each(function(){
			$(this).attr('disabled','disabled');
		});	
		var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});

	$("#puntaje_intento_8a, #puntaje_intento_8b").change(function(){
		$('select[name=puntaje_item_8a] option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
		var puntaje = (parseInt($("#puntaje_intento_8a").val()) || 0) + (parseInt($("#puntaje_intento_8b").val()) || 0);		
		$("#puntaje_item_8a option[value="+puntaje+"]").prop('selected',true);	
		$('select[name=puntaje_item_8a] option:not(:selected)').each(function(){
			$(this).attr('disabled','disabled');
		});	
		
		var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});

	$("select[name^=puntaje_item_]").change(function(){
	 	var puntaje_bruto = 0;
		$("select[name^=puntaje_item_]").each(function(){
			if($(this).val() != ''){
				puntaje_bruto = puntaje_bruto + parseInt($(this).val());
			}
		});
		$("#puntaje_bruto").val(puntaje_bruto);
	});	

});