<!-- fbsg-signature-writeViewEditBlade:<begin> task -->
@extends('layouts.dashboard')

@section('content')
<div class="messages"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-lg-9 col-6">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('dictionary.task') }}</h6>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="view-mode btn-group float-right" role="group">
							<button id="edit-taskbtn" class="btn btn-primary"><i class="fa fa-edit"></i> {{ __('dictionary.edit') }}</button>
							<button id="back-taskbtn" class="btn btn-secondary"><i class="fa fa-caret-left"></i> {{ __('dictionary.back') }}</button>
                        </div>
                        <div style="display:none" class="edit-mode btn-group float-right" role="group">
                            <button id="save-taskbtn" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('dictionary.save') }}</button>
                            <button id="cancel-taskbtn" class="btn btn-secondary"><i class="fa fa-times"></i> {{ __('dictionary.cancel') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
				<input type="hidden" id="updatetask-body-task_id" value="{{ $task->id}}">

                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('tasktitle', __('dictionary.tasktitle'), array('class' => 'label-required')) }}
                        <input type="text" disabled  id="updatetask-body-tasktitle" class="form-control value-updatetask" name="tasktitle" value="{{ $task->tasktitle}}">
                        <div style="display:none" id="error-updatetask-tasktitle" class="error-message error-updatetask"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('taskcode', __('dictionary.taskcode'), array('class' => 'label-required')) }}
                        <input type="text" disabled  id="updatetask-body-taskcode" class="form-control value-updatetask" name="taskcode" value="{{ $task->taskcode}}">
                        <div style="display:none" id="error-updatetask-taskcode" class="error-message error-updatetask"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('duedate', __('dictionary.duedate')) }}
                        <input type="datetime-local" disabled  id="updatetask-body-duedate" class="form-control value-updatetask" name="duedate" value="{{ $task->duedate}}">
                        <div style="display:none" id="error-updatetask-duedate" class="error-message error-updatetask"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('remark', __('dictionary.remark')) }}
                        <input type="text" disabled  id="updatetask-body-remark" class="form-control value-updatetask" name="remark" value="{{ $task->remark}}">
                        <div style="display:none" id="error-updatetask-remark" class="error-message error-updatetask"></div><p></p>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('status_id', __('dictionary.status_id'), array('class' => 'label-required')) }}
                        <input type="text" disabled  id="updatetask-body-status_id" class="form-control value-status_id" name="status_id" value="{{ $task->taskStatus->name}}">
                        <div style="display:none" id="error-updatetask-status_id" class="error-message error-updatetask"></div><p></p>
                    </div>
                </div>
                <div class="row">
                    <div id="viewtask-btn-group" class="form-group col-12 text-center">
                        @if(Auth::user()->can('activateapprovetaskdrafttask', $task))
                            <button id="viewactivateapprovetaskdrafttask-btn{{ $task->id }}" class="btn btn-primary viewtask-activate-approvetask-task"><i class="fa fa-check" aria-hidden="true"></i> {{ __('dictionary.approvetask') }}</button>
                        @endif
                        @if(Auth::user()->can('deletedrafttask', $task))
                            <button id="viewdeletedrafttask-btn{{ $task->id }}" class="btn btn-danger viewtask-delete-task"><i class="fa fa-trash" aria-hidden="true"></i> {{ __('dictionary.delete') }}</button>
                        @endif
                        @if(Auth::user()->can('canceldrafttask', $task))
                            <button id="viewcanceldrafttask-btn{{ $task->id }}" class="btn btn-warning viewtask-cancel-task"><i class="fa fa-times" aria-hidden="true"></i> {{ __('dictionary.cancel') }}</button>
                        @endif
                        @if(Auth::user()->can('deleteactivetask', $task))
                            <button id="viewdeleteactivetask-btn{{ $task->id }}" class="btn btn-danger viewtask-delete-task"><i class="fa fa-trash" aria-hidden="true"></i> {{ __('dictionary.delete') }}</button>
                        @endif
                        @if(Auth::user()->can('cancelactivetask', $task))
                            <button id="viewcancelactivetask-btn{{ $task->id }}" class="btn btn-warning viewtask-cancel-task"><i class="fa fa-times" aria-hidden="true"></i> {{ __('dictionary.cancel') }}</button>
                        @endif
                        @if(Auth::user()->can('deleteinactivetask', $task))
                            <button id="viewdeleteinactivetask-btn{{ $task->id }}" class="btn btn-danger viewtask-delete-task"><i class="fa fa-trash" aria-hidden="true"></i> {{ __('dictionary.delete') }}</button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
	@include('task.taskModal')
	
	<!-- relation tables (if available) --> 
	@if($showAll == 1)
	@endif
</div>
@endsection
<!-- fbsg-signature-writeViewEditBlade:<end> task -->