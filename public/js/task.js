$(document).ready(function(){	
	/* fbsg-signature-addJSModelFixed:<begin> */
	// set up table
	var dataTablestaskManange = $('#dataTables-taskManange').DataTable({
        serverSide: true,
        processing: true,
		responsive: true,
		fixedHeader: true,
        ajax: {"url": "/gettaskDataTable",
			  },
        dom: 'Bfrtip',
        buttons: [
        ],
        columns: [
                    { data: 'tasktitle',   name: 'tasktitle',   className: 'text-center'  },
                    { data: 'taskcode',   name: 'taskcode',   className: 'text-center'  },
                    { data: 'duedate',   name: 'duedate',   className: 'text-center'  },
                    { data: 'remark',   name: 'remark',   className: 'text-center'  },
                    { data: 'status_id',   name: 'status_id',   className: 'text-center'  },
                    { data: 'managecol',   name: 'managecol',   className: 'text-center', orderable: false  },        ],
	});
	dataTablestaskManange.columns('.colhide').visible(false);


    $('#edit-taskbtn').on('click', function() {
		EnabletaskViewEdit();
    });

    $('#cancel-taskbtn').on('click', function() {
        location.reload();
    });
	
	$('#back-taskbtn').on('click', function() {
		window.location.href = localStorage['last_visited'];
	});
	
	function EnabletaskViewEdit() {
        $('.view-mode').hide();
        $('.edit-mode').show();
        $('.value-updatetask').prop('disabled', false);
	}
	
	function DisabletaskViewEdit() {
        $('.view-mode').show();
        $('.edit-mode').hide();
		$('.error-updatetask').hide();
        $('.value-updatetask').prop('disabled', true);
	}
	
	$('#save-taskbtn').on('click', function() {
		confirmUpdatetask($('#updatetask-body-task_id').val(), 0);
	});	
		
	/* fbsg-signature-addJSModelFixed:<end> */
	
	/* fbsg-signature-addJSActionModel:<begin> */
	/* fbsg-signature-addJSModelAddModal:<begin> task */
	/**********************/
	/* (2) "add" Function */
	/**********************/

	// initialize 'empty' form when "add" button is clicked.
	$('.add-task').on('click', function() {
		$('.value-addtask-modal').val('');
		$('.error-addtask-modal').hide();
		$('#addtask-modal').modal('show');
		$('#addtask-modal-body-tasktitle').focus();
	});

	// clear error message when input element has been changed.
	$('#addtask-modal-body-tasktitle, #addtask-body-tasktitle').on('input', function(){
		$('#error-addtask-tasktitle').hide();
	});
	$('#addtask-modal-body-taskcode, #addtask-body-taskcode').on('input', function(){
		$('#error-addtask-taskcode').hide();
	});
	$('#addtask-modal-body-duedate, #addtask-body-duedate').on('input', function(){
		$('#error-addtask-duedate').hide();
	});
	$('#addtask-modal-body-remark, #addtask-body-remark').on('input', function(){
		$('#error-addtask-remark').hide();
	});

	// submit data to server when "confirm" is clicked and 
	// process accordingly then
    $('#addtask-modal-confirm').on('click',function() {
		confirmAddtask(1);
	});
	
	function confirmAddtask(modal = 1) {
		if(modal == 1) {
			modal_txt = '-modal';
		} else {
			modal_txt = '';
		}
		var form_data = new FormData();
		
		var tasktitle = $('#addtask' + modal_txt + '-body-tasktitle').val();
		form_data.append('tasktitle', tasktitle);
		var taskcode = $('#addtask' + modal_txt + '-body-taskcode').val();
		form_data.append('taskcode', taskcode);
		var duedate = $('#addtask' + modal_txt + '-body-duedate').val();
		form_data.append('duedate', duedate);
		var remark = $('#addtask' + modal_txt + '-body-remark').prop('files')[0];
		form_data.append('remark', remark);

        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				'Accept' : 'application/json'
			}
		});
		
        $.ajax({
            url: '/addtask',
            type: 'POST',
			cache : false,
			data: form_data,
			contentType: false,
			processData: false,
            success: function(results){
				/* validation fails, show error messages */
				if(results.success == 'false') 
				{
					if(results.errors) 
					{
						/* loop through all input elements with errors */
						var keys = Object.keys(results.errors);
						for(i=0;i<keys.length;i++) {
							var error_msg = results.errors[keys[i]];
							/* typically show only the first error */
							if(error_msg.length>1) {
								$('#error-addtask-'+keys[i]).text(error_msg[0]);
							} else {
								$('#error-addtask-'+keys[i]).text(error_msg);
							}
							$('#error-addtask-'+keys[i]).show();
						}
					}
				} 
				/* successful validation, close modal and insert the newly created row */
				else 
				{
					if(modal == 1) {
						clearAddtaskForm(modal);
						$('#addtask' + modal_txt).modal('hide');
						$('#dataTables-taskManange').DataTable().ajax.reload(null, false);
					} else {
						FlashMsg('Data saved successfully!', 'success', 1);
						location.reload(); // should do $('.error-addtask').hide() & redirect somewhere
					}
				}
            },
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					txtmsg = "Unsuccessful - You are not authorized!";
					if(modal == 1) {
						$('#errortask' + modal_txt + '-body-errormsg').text(txtmsg);
						$('#addtask' + modal_txt).modal('hide');
						$('#errortask' + modal_txt + '-login').hide();
						$('#errortask' + modal_txt).modal('show');
					} else {
						FlashMsg(txtmsg, 'danger', 0);				
					}
				}
				else if (jqXhr.status == 401) {
					txtmsg = "Unsuccessful - You are not logged in or Your session has expired!.";
					if(modal == 1) {
						$('#errortask' + modal_txt + '-body-errormsg').text(txtmsg);
						$('#addtask' + modal_txt).modal('hide');
						$('#errortask' + modal_txt + '-login').show();
						$('#errortask' + modal_txt).modal('show');
					} else {
						FlashMsg(txtmsg, 'danger', 0);				
					}
				}
				else {
					txtmsg = "Unsuccessful - " + errorThrown;
					if(modal == 1) {
						$('#errortask' + modal_txt + '-body-errormsg').text(txtmsg);
						$('#addtask' + modal_txt).modal('hide');
						$('#errortask' + modal_txt + '-login').hide();
						$('#errortask' + modal_txt).modal('show');
					} else {
						FlashMsg(txtmsg, 'danger', 0);						
					}
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
		});
	}
	
	$('#addtask-modal').on('hidden.bs.modal', function () {
		clearAddtaskForm(1);
	});
	
	function clearAddtaskForm(modal = 1){
		if(modal == 1) {
			modal_txt = '-modal';
		} else {
			modal_txt = '';
		}
		$('#addtask' + modal_txt + '-body-tasktitle').val('');
		$('#addtask' + modal_txt + '-body-taskcode').val('');
		$('#addtask' + modal_txt + '-body-duedate').val('');
		$('#addtask' + modal_txt + '-body-remark').val('');
	};
	/* fbsg-signature-addJSModelAddModal:<end> task */

	/* fbsg-signature-addJSModelViewModal:<begin> task */
	/*************************/
	/* (3) "view" Function   */
	/*************************/
	
	// initialize when "view" button is clicked
	$('#dataTables-taskManange').on('click', '.view-task' , function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		$('.error-viewtask-modal').hide();
		viewtaskForm(task_id);
	});
	
	// redirect to view form page
	function viewtaskForm(task_id) {
		localStorage['last_visited'] = window.location.href;
		var url = '/viewtask/' + task_id;

		window.location.href = url;
	}

	// acquire id & data to be updated
	function viewtask(task_id){
		$('#viewtask-modal-body-task_id').val(task_id);
		
		$.ajax({
            url: '/viewtask/' + task_id,
			dataType: "json",
            type: 'GET',
            data: { _token: CSRF_TOKEN},
            success: function(results){
				$('#viewtask-modal-body-tasktitle').val(results.data.tasktitle);
				$('#viewtask-modal-body-taskcode').val(results.data.taskcode);
				$('#viewtask-modal-body-duedate').val(results.data.duedate);
				$('#viewtask-modal-body-remark').val(results.data.remark);

				$('#viewtask-modal').modal('show');
			},
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#viewtask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#viewtask-modal').modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#viewtask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
		});		
	}

	$('#viewtask-modal').on('hidden.bs.modal', function () {
		clearViewtaskForm(1);
	});

	function clearViewtaskForm(modal = 1){
		if(modal == 1) {
			modal_txt = '-modal';
		} else {
			modal_txt = '';
		}
		$('#viewtask' + modal_txt + '-body-tasktitle').val('');
		$('#viewtask' + modal_txt + '-body-taskcode').val('');
		$('#viewtask' + modal_txt + '-body-duedate').val('');
		$('#viewtask' + modal_txt + '-body-remark').val('');
	};
	/* fbsg-signature-addJSModelViewModal:<end> task */

	/* fbsg-signature-addJSModelUpdateModal:<begin> task */
	/*************************/
	/* (4) "update" Function */
	/*************************/
	
	// initialize when "update" button is clicked
	$('#dataTables-taskManange').on('click', '.update-task', function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		$('.error-updatetask-modal').hide();
		updatetask(task_id);
	});

	// acquire id & data to be updated
	function updatetask(task_id){
		$('#updatetask-modal-body-task_id').val(task_id);
		
		$.ajax({
            url: '/viewtask/' + task_id,
			dataType: "json",
            type: 'GET',
            data: { _token: CSRF_TOKEN},
            success: function(results){
				$('#updatetask-modal-body-tasktitle').val(results.data.tasktitle);
				$('#updatetask-modal-body-taskcode').val(results.data.taskcode);
				$('#updatetask-modal-body-duedate').val(results.data.duedate);
				$('#updatetask-modal-body-remark').val(results.data.remark);

				$('#updatetask-modal').modal('show');
			},
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#updatetask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#updatetask-modal').modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#updatetask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
		});		
	}

	// clear error message when input element has been changed.
	$('#updatetask-modal-body-tasktitle, #updatetask-body-tasktitle').on('input', function(){
		$('#error-updatetask-tasktitle').hide();
	});
	$('#updatetask-modal-body-taskcode, #updatetask-body-taskcode').on('input', function(){
		$('#error-updatetask-taskcode').hide();
	});
	$('#updatetask-modal-body-duedate, #updatetask-body-duedate').on('input', function(){
		$('#error-updatetask-duedate').hide();
	});
	$('#updatetask-modal-body-remark, #updatetask-body-remark').on('input', function(){
		$('#error-updatetask-remark').hide();
	});

	// perform update on "confirm" click
    $('#updatetask-modal-confirm').on('click',function(){
		confirmUpdatetask($('#updatetask-modal-body-task_id').val(), 1);
    });
	
	function confirmUpdatetask(task_id, modal = 1){
		if(modal == 1) {
			modal_txt = '-modal';
		} else {
			modal_txt = '';
		}
		var form_data = new FormData();
		form_data.append('_method', 'PUT');
		var tasktitle = $('#updatetask' + modal_txt + '-body-tasktitle').val();
		form_data.append('tasktitle', tasktitle);
		var taskcode = $('#updatetask' + modal_txt + '-body-taskcode').val();
		form_data.append('taskcode', taskcode);
		var duedate = $('#updatetask' + modal_txt + '-body-duedate').val();
		form_data.append('duedate', duedate);
		var remark = $('#updatetask' + modal_txt + '-body-remark').val();
		form_data.append('remark', remark);


        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				'Accept' : 'application/json'
			}
		});
				
        $.ajax({
            url: '/updatetask/' + task_id,
			dataType: "json",
            type: 'POST',
			cache : false,
			data: form_data,
			contentType: false,
			processData: false,
            success: function(results){
				/* validation fails, show error messages */
				if(results.success == 'false') 
				{
					if(results.errors) 
					{
						/* loop through all input elements with errors */
						var keys = Object.keys(results.errors);
						for(i=0;i<keys.length;i++) {
							var error_msg = results.errors[keys[i]];
							/* typically show only the first error */
							if(error_msg.length>1) {
								$('#error-updatetask-'+keys[i]).text(error_msg[0]);
							} else {
								$('#error-updatetask-'+keys[i]).text(error_msg);
							}
							$('#error-updatetask-'+keys[i]).show();
						}
					}
				} 
				/* successful validation, close modal and refresh data */
				else 
				{
					if(modal == 1) {
						clearUpdatetaskForm(modal);
						$('#updatetask' + modal_txt).modal('hide');
						$('#dataTables-taskManange').DataTable().ajax.reload(null, false);
					} else {
						FlashMsg('Data saved successfully!', 'success', 1);
						DisabletaskViewEdit();
					}
				}
            },
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					txtmsg = "Unsuccessful - You are not authorized!";
					if(modal == 1) {
						$('#errortask-modal-body-errormsg').text(txtmsg);
						$('#updatetask' + modal_txt).modal('hide');
						$('#errortask-modal-login').hide();
						$('#errortask-modal').modal('show');
					} else {
						FlashMsg(txtmsg, 'danger', 0);								
					}
				}
				else if (jqXhr.status == 401) {
					txtmsg = "Unsuccessful - You are not logged in or Your session has expired!.";
					if(modal == 1) {
						$('#errortask-modal-body-errormsg').text(txtmsg);
						$('#updatetask' + modal_txt).modal('hide');
						$('#errortask-modal-login').show();
						$('#errortask-modal').modal('show');
					} else {
						FlashMsg(txtmsg, 'danger', 0);								
					}
				}
				else {
					txtmsg = "Unsuccessful - " + errorThrown;
					if(modal == 1) {
						$('#errortask-modal-body-errormsg').text(txtmsg);
						$('#updatetask' + modal_txt).modal('hide');
						$('#errortask-modal-login').hide();
						$('#errortask-modal').modal('show');
					} else {
						FlashMsg(txtmsg, 'danger', 0);								
					}
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
        });
	}

	$('#updatetask-modal').on('hidden.bs.modal', function () {
		clearUpdatetaskForm(1);
	});

	function clearUpdatetaskForm(modal = 1){
		if(modal == 1) {
			modal_txt = '-modal';
		} else {
			modal_txt = '';
		}
		$('#updatetask' + modal_txt + '-body-tasktitle').val('');
		$('#updatetask' + modal_txt + '-body-taskcode').val('');
		$('#updatetask' + modal_txt + '-body-duedate').val('');
		$('#updatetask' + modal_txt + '-body-remark').val('');
	};
	/* fbsg-signature-addJSModelUpdateModal:<end> task */

	/* fbsg-signature-addJSModelActivateModal:<begin> approvetask,task */	
	/***************************/
	/* (8) "activate" Function */
	/***************************/

	// initialize when "activate" button is clicked on DataTable
	$('#dataTables-taskManange').on('click', '.activate-approvetask-task', function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		activateapprovetasktask(task_id);
	});

	// initialize when "activate" button is clicked on ViewEdit page
	$('#viewtask-btn-group').on('click', '.viewtask-activate-approvetask-task' , function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		activateapprovetasktask(task_id);		
	});
	
	// acquire id & data to be updated
	function activateapprovetasktask(task_id){
		$('#activate-approvetask-task-modal-body-tasktitle').text("");
		$('#activate-approvetask-task-modal-body-task_id').val(task_id);
		
		$.ajax({
            url: '/viewtask/' + task_id,
			dataType: "json",
            type: 'GET',
            data: { _token: CSRF_TOKEN},
            success: function(results){
			    $('#activate-approvetask-task-modal-body-tasktitle').text("Are you sure to confirm status change of " + results.data.tasktitle +" ?");
				$('#activate-approvetask-task-modal').modal('show');
				
			},
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#activate-approvetask-task-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#activate-approvetask-task-modal').modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#activate-approvetask-task-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
		});		
	}

	// perform activation function on "confirm" click
    $('#activate-approvetask-task-modal-confirm').on('click',function(){
		var task_id = $('#activate-approvetask-task-modal-body-task_id').val();
		var update_status_element_id = null;
		var btngrp_elemen_id = null;
		
		if($('.viewtask-activate-approvetask-task').length) {
			update_status_element_id = 'updatetask-body-status_id';
			btngrp_elemen_id = 'viewtask-btn-group'
		}
		confirmactivateapprovetasktask(task_id, 1, update_status_element_id, btngrp_elemen_id);
	});
	
	function confirmactivateapprovetasktask(task_id, modal = 1, update_status_element_id = null, btngrp_elemen_id = null) {
		if(modal == 1) {
			modal_txt = '-modal';
		} else {
			modal_txt = '';
		}
        $.ajax({
            url: '/approvetask/' + task_id,
			dataType: "json",
            type: 'PUT',
            data: { _token: CSRF_TOKEN },
            success: function(results){
				/* if activated successfully, refresh data */
				if(modal == 1) {
					clearUpdatetaskForm(modal);
					// post-activity after calling ajax
					if(update_status_element_id) {
						// when the current page has "update_status_element"
						$.ajax({
							url: '/viewtask/' + task_id,
							type: 'GET',
							data: { _token: CSRF_TOKEN, showAll: 0 },
							success: function(results){
								/* extract data from response */
								var status_update = $(results).find('#' + update_status_element_id).val();
								var btn_html = $(results).find('#' + btngrp_elemen_id).html();
								
								/* update new data */
								$('#' + update_status_element_id).val(status_update);
								$('#'+ btngrp_elemen_id).html(btn_html);

								$('#activate-approvetask-task' + modal_txt).modal('hide');
								FlashMsg('Activating task successfully!', 'success', 1);
							},
							error: function( jqXhr, textStatus, errorThrown ){
								if (jqXhr.status == 403) {
									$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
									$('#activate-approvetask-task' + modal_txt).modal('hide');
									$('#errortask-modal-login').hide();
									$('#errortask-modal').modal('show');
								}
								else if (jqXhr.status == 401) {
									$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
									$('#activate-approvetask-task' + modal_txt).modal('hide');
									$('#errortask-modal-login').show();
									$('#errortask-modal').modal('show');
								}
								else {
									$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
									$('#activate-approvetask-task' + modal_txt).modal('hide');
									$('#errortask-modal-login').hide();
									$('#errortask-modal').modal('show');
									console.log(errorThrown);
									console.log(jqXhr.responseText);
								}
							}
						});
					} else {
						// when the current page has "DataTable"
						$('#activate-approvetask-task' + modal_txt).modal('hide');
						$('#dataTables-taskManange').DataTable().ajax.reload(null, false);
					}
				} else {
					FlashMsg('Data saved successfully!', 'success', 1);
					location.reload(); // should do $('.error-addtask').hide() & redirect somewhere
				}
            },
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#activate-approvetask-task-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#activate-approvetask-task-modal').modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#activate-approvetask-task-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
        });
    }
	/* fbsg-signature-addJSModelActivateModal:<end> approvetask,task */	
	/* fbsg-signature-addJSModelDeleteModal:<begin> task */	
	/*************************/
	/* (5) "delete" Function */
	/*************************/
	
	// initialize when "delete" button is clicked on DataTable
	$('#dataTables-taskManange').on('click', '.delete-task', function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		deletetask(task_id);
	});
	
	// initialize when "delete" button is clicked on ViewEdit page
	$('#viewtask-btn-group').on('click', '.viewtask-delete-task' , function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		deletetask(task_id);		
	});
	
	// acquire id & data to be deleted
	function deletetask(task_id) {
		$('#deletetask-modal-body-tasktitle').text("");
		$('#deletetask-modal-body-task_id').val(task_id);
		
		$.ajax({
            url: '/viewtask/' + task_id,
			dataType: "json",
            type: 'GET',
            data: { _token: CSRF_TOKEN},
            success: function(results){
				if (results.data.hasActiveLinkedModels) {
					$('#deletetask-modal-confirm').hide();
					$('#deletetask-modal-body-tasktitle').text("Unable to delete " + results.data.tasktitle +"  since it is being referenced by others");
				} else {
					$('#deletetask-modal-confirm').show();
					$('#deletetask-modal-body-tasktitle').text("Are you sure to delete " + results.data.tasktitle +" ?");
				}
				$('#deletetask-modal').modal('show');
			},
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#deletetask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#deletetask-modal').modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#deletetask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
		});				
	}

	// perform deletion on "confirm" click
    $('#deletetask-modal-confirm').on('click',function(){
		var task_id = $('#deletetask-modal-body-task_id').val();
		var update_status_element_id = null;
		var btngrp_elemen_id = null;
		
		if($('.viewtask-delete-task').length) {
			update_status_element_id = 'updatetask-body-status_id';
			btngrp_elemen_id = 'viewtask-btn-group'
		}
		confirmdeletetask(task_id, 1, update_status_element_id, btngrp_elemen_id);
	});
        
	function confirmdeletetask(task_id, modal = 1, update_status_element_id = null, btngrp_elemen_id = null) {
		if(modal == 1) {
			modal_txt = '-modal';
		} else {
			modal_txt = '';
		}				
		$.ajax({
            url: '/deletetask/' + task_id,
			dataType: "json",
            type: 'DELETE',
            data: { _token: CSRF_TOKEN },
            success: function(results){
				/* if deleted successfully, refresh data */
				if(modal == 1) {
					clearUpdatetaskForm(modal);
					// post-activity after calling ajax
					if(update_status_element_id) {
						// go back to DataTable when the current page has "update_status_element"
						$('#deletetask' + modal_txt).modal('hide');
						FlashMsg('Deleting task successfully!', 'success', 1);
						window.location.href = '/task'
					} else {
						// when the current page has "DataTable"
						$('#deletetask' + modal_txt).modal('hide');
						$('#dataTables-taskManange').DataTable().ajax.reload(null, false);
					}
				} else {
					FlashMsg('Data saved successfully!', 'success', 1);
					location.reload(); // should do $('.error-addtask').hide() & redirect somewhere
				}
				$('#deletetask-modal').modal('hide');
				$('#dataTables-taskManange').DataTable().draw(true);
			},
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#deletetask' + modal_txt).modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#deletetask' + modal_txt).modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#deletetask' + modal_txt).modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
        });
	}
	/* fbsg-signature-addJSModelDeleteModal:<end> task */	

	/* fbsg-signature-addJSModelCancelModal:<begin> task */	
	/*************************/
	/* (6) "cancel" Function */
	/*************************/
	
	// initialize when "cancel" button is clicked
	$('#dataTables-taskManange').on('click', '.cancel-task', function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		canceltask(task_id);
	});
	
	// initialize when "cancel" button is clicked on ViewEdit page
	$('#viewtask-btn-group').on('click', '.viewtask-cancel-task' , function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		canceltask(task_id);		
	});

	// acquire id & data to be updated
	function canceltask(task_id){
		$('#canceltask-modal-body-tasktitle').text('');
		$('#canceltask-modal-body-task_id').val(task_id);
		
		$.ajax({
            url: '/viewtask/' + task_id,
			dataType: "json",
            type: 'GET',
            data: { _token: CSRF_TOKEN},
            success: function(results){
				if (results.data.hasActiveLinkedModels) {
					$('#canceltask-modal-body-tasktitle').text(results.data.tasktitle +" is being referenced by others. They will also be cancelled. Are you sure to cancel?");
				} else {
					$('#canceltask-modal-body-tasktitle').text("Are you sure to cancel " + results.data.tasktitle +" ?");
				}
				$('#canceltask-modal').modal('show');
			},
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
				console.log( jqXhr.responseText);
            }
		});		
	}

	// perform cancellation on "confirm" click
    $('#canceltask-modal-confirm').on('click',function(){
		var task_id = $('#canceltask-modal-body-task_id').val()
		var update_status_element_id = null;
		var btngrp_elemen_id = null;
		
		if($('.viewtask-cancel-task').length) {
			update_status_element_id = 'updatetask-body-status_id';
			btngrp_elemen_id = 'viewtask-btn-group'
		}
		confirmcanceltask(task_id, 1, update_status_element_id, btngrp_elemen_id);
	});
	
	function confirmcanceltask(task_id, modal = 1, update_status_element_id = null, btngrp_elemen_id = null) {
		if(modal == 1) {
			modal_txt = '-modal';
		} else {
			modal_txt = '';
		}				
        $.ajax({
            url: '/canceltask/' + task_id,
			dataType: "json",
            type: 'GET',
            data: { _token: CSRF_TOKEN },
            success: function(results){
				/* if canceled successfully, refresh data */
				if(modal == 1) {
					clearUpdatetaskForm(modal);
					// post-activity after calling ajax
					if(update_status_element_id) {
						// go back to DataTable when the current page has "update_status_element"
						$('#canceltask' + modal_txt).modal('hide');
						FlashMsg('Cancelling task successfully!', 'success', 1);
						window.location.href = '/task'
					} else {
						// when the current page has "DataTable"
						$('#canceltask' + modal_txt).modal('hide');
						$('#dataTables-taskManange').DataTable().ajax.reload(null, false);
					}
				} else {
					FlashMsg('Data saved successfully!', 'success', 1);
					location.reload(); // should do $('.error-addtask').hide() & redirect somewhere
				}
            },
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#canceltask' + modal_txt).modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#canceltask' + modal_txt).modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#canceltask' + modal_txt).modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
        });
    }
	/* fbsg-signature-addJSModelCancelModal:<end> task */

	/* fbsg-signature-addJSModelUncancelModal:<begin> task */	
	/***************************/
	/* (7) "uncancel" Function */
	/***************************/
	
	// initialize when "uncancel" button is clicked
	$('#dataTables-taskManange').on('click', '.uncancel-task', function(){
		var id_str = this.id;
		var res = id_str.split("-btn");
		var task_id = res[1];

		uncanceltask(task_id)
	});

	// acquire id & data to be updated
	function uncanceltask(task_id){
		$('#uncanceltask-modal-body-tasktitle').text("");
		$('#uncanceltask-modal-body-task_id').val(task_id);
		
		$.ajax({
            url: '/viewtask/' + task_id,
			dataType: "json",
            type: 'GET',
            data: { _token: CSRF_TOKEN},
            success: function(results){
			    $('#uncanceltask-modal-body-tasktitle').text("Are you sure to uncancel " + results.data.tasktitle +" ?");
				$('#uncanceltask-modal').modal('show');
				
			},
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#uncanceltask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#uncanceltask-modal').modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#uncanceltask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
		});		
	}

	// perform uncancellation on "confirm" click
    $('#uncanceltask-modal-confirm').on('click',function(){
		var task_id = $('#uncanceltask-modal-body-task_id').val();
				
        $.ajax({
            url: '/uncanceltask/' + task_id,
			dataType: "json",
            type: 'PUT',
            data: { _token: CSRF_TOKEN },
            success: function(results){
				/* if uncanceled successfully, refresh data */
				$('#uncanceltask-modal').modal('hide');
				$('#dataTables-taskManange').DataTable().ajax.reload(null, false);
            },
            error: function( jqXhr, textStatus, errorThrown ){
				if (jqXhr.status == 403) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not authorized!")
					$('#uncanceltask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
				}
				else if (jqXhr.status == 401) {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - You are not logged in or Your session has expired!.")
					$('#uncanceltask-modal').modal('hide');
					$('#errortask-modal-login').show();
					$('#errortask-modal').modal('show');
				}
				else {
					$('#errortask-modal-body-errormsg').text("Unsuccessful - " + errorThrown)
					$('#uncanceltask-modal').modal('hide');
					$('#errortask-modal-login').hide();
					$('#errortask-modal').modal('show');
					console.log(errorThrown);
					console.log(jqXhr.responseText);
				}
            }
        });
    });
	/* fbsg-signature-addJSModelUncancelModal:<end> task */	

	/* fbsg-signature-addJSActionModel:<end> */

	/* fbsg-signature-addJSPopulateList:<begin> */
	/* fbsg-signature-addJSPopulateList:<end> */
});
