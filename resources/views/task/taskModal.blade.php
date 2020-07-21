<!-- fbsg-signature-writeAddModalBlade:<begin> task -->
<!-- addtask Modal -->
<div id="addtask-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="addtask-modal-header" class="modal-title"> {{ __('dictionary.addtask') }}</h4>
				<button id="addtask-modal-header-close" style="float:right; margin-right:0px; margin-top:0px; font-size:1.5rem; padding-top:0px;" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="addtask-modal-body" class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('tasktitle', __('dictionary.tasktitle'), array('class' => 'label-required')) }}
                        <input type="text" id="addtask-modal-body-tasktitle" class="form-control value-addtask-modal">
                        <div style="display:none" id="error-addtask-tasktitle" class="error-message error-addtask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('taskcode', __('dictionary.taskcode'), array('class' => 'label-required')) }}
                        <input type="text" id="addtask-modal-body-taskcode" class="form-control value-addtask-modal">
                        <div style="display:none" id="error-addtask-taskcode" class="error-message error-addtask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('duedate', __('dictionary.duedate')) }}
                        <input type="datetime-local" id="addtask-modal-body-duedate" class="form-control value-addtask-modal">
                        <div style="display:none" id="error-addtask-duedate" class="error-message error-addtask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('remark', __('dictionary.remark')) }}
                        <input type="file" id="addtask-modal-body-remark" class="form-control value-addtask-modal">
                        <div style="display:none" id="error-addtask-remark" class="error-message error-addtask-modal"></div><p></p>
                    </div>
                </div>
			</div>
            <div class="modal-footer">
                <button id="addtask-modal-confirm" type="button" class="btn btn-primary"> {{ __('dictionary.add') }}</button>
                <button id="addtask-modal-close" type="button" class="btn btn-danger" data-dismiss="modal">{{ __('dictionary.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- fbsg-signature-writeAddModalBlade:<end> task -->

<!-- fbsg-signature-writeViewModalBlade:<begin> task -->
<!-- viewtask Modal -->
<div id="viewtask-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="viewtask-modal-header" class="modal-title">{{ __('dictionary.viewtask') }}</h4>
				<button id="viewtask-modal-header-close" style="float:right; margin-right:0px; margin-top:0px; font-size:1.5rem; padding-top:0px;" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="viewtask-modal-body" class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('tasktitle', __('dictionary.tasktitle'), array('class' => 'label-required')) }}
                        <input type="text" disabled  id="viewtask-modal-body-tasktitle" class="form-control value-viewtask-modal">
                        <div style="display:none" id="error-viewtask-tasktitle" class="error-message error-viewtask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('taskcode', __('dictionary.taskcode'), array('class' => 'label-required')) }}
                        <input type="text" disabled  id="viewtask-modal-body-taskcode" class="form-control value-viewtask-modal">
                        <div style="display:none" id="error-viewtask-taskcode" class="error-message error-viewtask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('duedate', __('dictionary.duedate')) }}
                        <input type="datetime-local" disabled  id="viewtask-modal-body-duedate" class="form-control value-viewtask-modal">
                        <div style="display:none" id="error-viewtask-duedate" class="error-message error-viewtask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('remark', __('dictionary.remark')) }}
                        <input type="text" disabled  id="viewtask-modal-body-remark" class="form-control value-viewtask-modal">
                        <div style="display:none" id="error-viewtask-remark" class="error-message error-viewtask-modal"></div><p></p>
                    </div>
                </div>
                <input type="hidden" id="viewtask-modal-body-task_id" value="">
            </div>
            <div class="modal-footer">
                <button id="viewtask-modal-close" type="button" class="btn btn-success" data-dismiss="modal">{{ __('dictionary.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- fbsg-signature-writeViewModalBlade:<end> task -->

<!-- fbsg-signature-writeUpdateModalBlade:<begin> task -->
<!-- updatetask Modal -->
<div id="updatetask-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="updatetask-modal-header" class="modal-title">{{ __('dictionary.updatetask') }}</h4>
				<button id="updatetask-modal-header-close" style="float:right; margin-right:0px; margin-top:0px; font-size:1.5rem; padding-top:0px;" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="updatetask-modal-body" class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('tasktitle', __('dictionary.tasktitle'), array('class' => 'label-required')) }}
                        <input type="text" id="updatetask-modal-body-tasktitle" class="form-control value-updatetask-modal">
                        <div style="display:none" id="error-updatetask-tasktitle" class="error-message error-updatetask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('taskcode', __('dictionary.taskcode'), array('class' => 'label-required')) }}
                        <input type="text" id="updatetask-modal-body-taskcode" class="form-control value-updatetask-modal">
                        <div style="display:none" id="error-updatetask-taskcode" class="error-message error-updatetask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('duedate', __('dictionary.duedate')) }}
                        <input type="datetime-local" id="updatetask-modal-body-duedate" class="form-control value-updatetask-modal">
                        <div style="display:none" id="error-updatetask-duedate" class="error-message error-updatetask-modal"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('remark', __('dictionary.remark')) }}
                        <input type="text" id="updatetask-modal-body-remark" class="form-control value-updatetask-modal">
                        <div style="display:none" id="error-updatetask-remark" class="error-message error-updatetask-modal"></div><p></p>
                    </div>
                </div>
                <input type="hidden" id="updatetask-modal-body-task_id" value="">
            </div>
            <div class="modal-footer">
                <button id="updatetask-modal-confirm" type="button" class="btn btn-primary">{{ __('dictionary.confirm') }}</button>
                <button id="updatetask-modal-close" type="button" class="btn btn-danger" data-dismiss="modal">{{ __('dictionary.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- fbsg-signature-writeUpdateModalBlade:<end> task -->

<!-- fbsg-signature-writeActivateModalBlade:<begin> approvetask,task -->
<!-- activate-approvetask-task Modal -->
<div id="activate-approvetask-task-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="activate-approvetask-task-modal-header" class="modal-title"> {{ __('dictionary.approvetask') }}</h4>
				<button style="float:right; margin-right:0px; margin-top:0px; font-size:1.5rem; padding-top:0px;" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="activate-approvetask-task-modal-body" class="modal-body">
                <p id="activate-approvetask-task-modal-body-tasktitle">Do you want to approvetask?</p>
                <input type="hidden" id="activate-approvetask-task-modal-body-task_id" value="">
            </div>
            <div class="modal-footer">
                <button id="activate-approvetask-task-modal-confirm" type="button" class="btn btn-primary">{{ __('dictionary.approvetask') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('dictionary.close') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- fbsg-signature-writeActivateModalBlade:<end> approvetask,task -->

<!-- fbsg-signature-writeDeleteModalBlade:<begin> task -->
<!-- deletetask Modal -->
<div id="deletetask-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="deletetask-modal-header" class="modal-title"> {{ __('dictionary.deletetask') }}</h4>
				<button style="float:right; margin-right:0px; margin-top:0px; font-size:1.5rem; padding-top:0px;" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="deletetask-modal-body" class="modal-body">
                <p id="deletetask-modal-body-tasktitle">Do you want to delete?</p>
                <input type="hidden" id="deletetask-modal-body-task_id" value="">
            </div>
            <div class="modal-footer">
                <button id="deletetask-modal-confirm" type="button" class="btn btn-primary">{{ __('dictionary.delete') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('dictionary.close') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- fbsg-signature-writeDeleteModalBlade:<end> task -->

<!-- fbsg-signature-writeCancelModalBlade:<begin> task -->
<!-- canceltask Modal -->
<div id="canceltask-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('dictionary.canceltask') }}</h4>
				<button style="float:right; margin-right:0px; margin-top:0px; font-size:1.5rem; padding-top:0px;" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="canceltask-modal-body" class="modal-body">
                <p id="canceltask-modal-body-tasktitle">Do you want to cancel?</p>
                <input type="hidden" id="canceltask-modal-body-task_id" value="">
            </div>
            <div class="modal-footer">
                <button id="canceltask-modal-confirm" type="button" class="btn btn-primary">{{ __('dictionary.confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('dictionary.close') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- fbsg-signature-writeCancelModalBlade:<end> task -->

<!-- fbsg-signature-writeUncancelModalBlade:<begin> task -->
<!-- uncanceltask Modal -->
<div id="uncanceltask-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="uncanceltask-modal-header" class="modal-title"> {{ __('dictionary.uncanceltask') }}</h4>
				<button style="float:right; margin-right:0px; margin-top:0px; font-size:1.5rem; padding-top:0px;" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="uncanceltask-modal-body" class="modal-body">
                <p id="uncanceltask-modal-body-tasktitle">Do you want to uncancel?</p>
                <input type="hidden" id="uncanceltask-modal-body-task_id" value="">
            </div>
            <div class="modal-footer">
                <button id="uncanceltask-modal-confirm" type="button" class="btn btn-primary">{{ __('dictionary.uncancel') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('dictionary.close') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- fbsg-signature-writeUncancelModalBlade:<end> task -->
<!-- fbsg-signature-writeErrorModalBlade:<begin> task -->
<!-- errortask Modal -->
<div id="errortask-modal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="errortask-modal-header" class="modal-title"> {{ __('dictionary.errorheader') }}</h4>
				<button style="float:right; margin-right:0px; margin-top:0px; font-size:1.5rem; padding-top:0px;" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="errortask-modal-body" class="modal-body">
                <p id="errortask-modal-body-errormsg"></p>
                <input type="hidden" id="errortask-modal-body-task_id" value="">
            </div>
            <div class="modal-footer">
                <button href="/task" id="errortask-modal-login" type="button" class="btn btn-primary">{{ __('dictionary.login') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('dictionary.close') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- fbsg-signature-writeErrorModalBlade:<end> task -->
