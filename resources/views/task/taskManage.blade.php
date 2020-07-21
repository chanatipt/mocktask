<!-- fbsg-signature-writeManageBlade:<begin> task -->
@extends('layouts.dashboard')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 text-center">{{ __('dictionary.task') }}</h1>

    <!-- DataTale -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="text-right">
                    @if(Auth::user()->can('addtask', 'App\task'))
						<button id="addtask-btn" type="button" class="add-task dt-button btn btn-primary" ><i class="fa fa-plus" aria-hidden="true"></i> {{ __('dictionary.add') }}</button>
                    @endif
                </div>
				@include('task.taskTable')
				@include('task.taskModal')
            </div>
        </div>
    </div>
@endsection
<!-- fbsg-signature-writeManageBlade:<end> task -->
