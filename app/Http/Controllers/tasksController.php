<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* fbsg-signature-addControllerUseModels:<begin> task */
use App\task;
use App\taskStatus;
use App\Repositories\taskRepositoryInterface;
use App\Role;
use App\Http\Resources\taskResource;
use Auth;
use Validator;
use Yajra\Datatables\Datatables;
/* fbsg-signature-addControllerUseModels:<end> task */
use Illuminate\Support\Facades\Storage;

class tasksController extends Controller
{
    //
	/* fbsg-signature-writeBasicFunc:<begin> task */
	/***********************/
	/* (0) Basic Functions */
	/***********************/
	protected $task;

	public function __construct(taskRepositoryInterface $task)
    {
        $this->task = $task;
    }

	public function getAuthorization($Tag, $task)
	{
		if ($task === NULL) {
			return $this->authorize($Tag.'task', 'App\task');
		} else {
			return $this->authorize($Tag . $task->taskStatus->name . 'task', $task);
		}
	}

	public function gettaskDataTableSubmit(Request $request) 
	{
		$searchVal = '';
		if($request->input('search')['value'] !== NULL) {
			$searchVal = $request->input('search')['value'];
		}

		$buffer = $this->task->get(NULL, FALSE, TRUE, $searchVal);
		$task = $buffer['task'];
		$recordsTotal = $buffer['recordsTotal'];

		$btnType = 0;
		if($request->input('btnType') !== NULL) {
			$btnType = (int) $request->input('btnType');
		}

		return Datatables::of($task)
							->filter(function($query) {
								return true; // disable global search
							})
							->editColumn('remark', function(task $obj)
							{ 
								$txt = '';
								if($obj->remark) {
									$txt = '<a href="'. Storage::url($obj->remark) . '"><i class="fa fa-file"></i></a>';
								}
								return $txt;
							})
							->editColumn('status_id', function(task $obj)
							{ 
								return $obj->taskStatus->name;
							})
							->editColumn('duedate', function(task $obj)
							{ 
								return date('d M Y', strtotime($obj->duedate));
							})
							->addColumn('managecol', function(task $obj) use($btnType){
								$txt = '';
								/*
                				if((Auth::user()->can('viewdrafttask', $obj)   ||
								   Auth::user()->can('viewactivetask', $obj)   ||
								   Auth::user()->can('viewinactivetask', $obj))  && (True)) {
									$txt = $txt . '                    <span data-toggle="tooltip" title="' . __("dictionary.view") . '">' . 
												  '                        <button id="viewtask-btn' . $obj->id . '" class="dt-button view-task btn btn-success " ><i class="fa fa-eye" aria-hidden="true"></i> '. __("dictionary.view") . ' </button>' .
												  '                    </span>';
								}
								*/
                				if((Auth::user()->can('activateapprovetaskdrafttask', $obj))  && ($btnType === 0)) {
									$txt = $txt . '                    <span data-toggle="tooltip" title="' . __("dictionary.approvetask") . '">' . 
												  '                        <button id="activate-approvetask-task-btn' . $obj->id . '" class="dt-button activate-approvetask-task btn btn-primary " ><i class="fa fa-check" aria-hidden="true"></i> '. __("dictionary.approvetask") . ' </button>' .
												  '                    </span>';
								}
                				if((Auth::user()->can('canceldrafttask', $obj)   ||
								   Auth::user()->can('cancelactivetask', $obj))  && ($btnType === 0)) {
									$txt = $txt . '                    <span data-toggle="tooltip" title="' . __("dictionary.delete") . '">' . 
												  '                        <button id="canceltask-btn' . $obj->id . '" class="dt-button cancel-task btn btn-danger " ><i class="fa fa-trash" aria-hidden="true"></i> '. __("dictionary.delete") . ' </button>' .
												  '                    </span>';
								}
								/*
                				if((Auth::user()->can('deletedrafttask', $obj)   ||
								   Auth::user()->can('deleteactivetask', $obj)   ||
								   Auth::user()->can('deleteinactivetask', $obj))  && ($btnType === 0)) {
									$txt = $txt . '                    <span data-toggle="tooltip" title="' . __("dictionary.purge") . '">' . 
												  '                        <button id="deletetask-btn' . $obj->id . '" class="dt-button delete-task btn btn-warning " ><i class="fa fa-eraser" aria-hidden="true"></i> '. __("dictionary.purge") . ' </button>' .
												  '                    </span>';
								}
								*/
                				if((Auth::user()->can('uncancelinactivetask', $obj)  && ($obj->taskStatus->name ==="inactive"))  && ($btnType === 0)) {
									$txt = $txt . '                    <span data-toggle="tooltip" title="' . __("dictionary.undelete") . '">' . 
												  '                        <button id="uncanceltask-btn' . $obj->id . '" class="dt-button uncancel-task btn btn-info " ><i class="fa fa-undo" aria-hidden="true"></i> '. __("dictionary.undelete") . ' </button>' .
												  '                    </span>';
								}

								return $txt;
							})
							->rawColumns(['managecol', 'remark'])
							->with([
								'recordsTotal' => $recordsTotal,
							])->make(true);
	}
	/* fbsg-signature-writeBasicFunc:<end> task */

	/* fbsg-signature-writeIndexShowFunc:<begin> task */
	/**********************/
	/* (1) Index Function */
	/**********************/
    public function index(Request $request)
    {
		// Authorization 
        $this->getAuthorization('index', NULL);
		
		$notinactiveFlag = FALSE;
		if($request->input('notinactiveFlag')) {
			$notinactiveFlag = $request->input('notinactiveFlag');
		}
		
        $task = $this->task->get(NULL, $notinactiveFlag = $notinactiveFlag, TRUE)['task'];
		$passdata = array(
		   'task' => $task,
        );

        // direct to JSON output, if requested so.
        if($request->wantsJson()) {
            return (taskResource::collection($task))
					->additional(['success' => 'true', 'Locale' => \App::getLocale()]);
        }
		
		// otherwise, direct to view
        return view('task.taskManage')->with($passdata);
    }
	/* fbsg-signature-writeIndexShowFunc:<end> task */

	/* fbsg-signature-addStateFunc-branchcreate:<begin> addtask,task */
	/********************/
	/* (2) Add Function */
	/********************/
    public function addtaskShow() 
    {
		// Authorization 
        $this->getAuthorization('add', NULL);
		$passdata = array(
		);

		// direct to view
		// addtask does not exist, create one if needed
        return view('task.addtask')->with($passdata);
    }

    public function addtaskSubmit(Request $request) 
    {
		// Authorization 
        $this->getAuthorization('add', NULL);

		// validate inputs
		$validator = Validator::make($request->all(), [
			// to be validated here
			'tasktitle' => 'required',
			'taskcode' => 'required',
			'remark' => 'required',

		]);
		if ($validator->fails()) {
			if($request->wantsJson()) {
                $response = array('errors' => $validator->errors(), 'success' => 'false');
                return $response;
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
		}
		
		// create new data object
		$task = $this->task->create(
						Auth::user()->id,
						taskStatus::where('name','draft')->first()->id,
						($request->input('tasktitle') ? $request->input('tasktitle') : NULL),
						($request->input('taskcode') ? $request->input('taskcode') : NULL),
						($request->input('duedate') ? date('Y-m-d H:i:s', strtotime($request->input('duedate'))) : NULL),
						($request->file('remark') ? $request->file('remark') : NULL),
        			);
        if($task) {
			
			$message = 'Creating new task is successful.';

			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return (new taskResource($task))
						->additional(['success' => 'true', 'Locale' => \App::getLocale()]);
			}

			// otherwise, direct to view
			return redirect('/task')->with('message',$message);
        } else {
		
			$message = 'Unable to create new task';
			
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'false', 'message' => $message]);
			}

			// otherwise, direct to view
            return redirect('/task')->with('message',$message);
        }
    }
	/* fbsg-signature-addStateFunc-branchcreate:<end> addtask,task */

	/* fbsg-signature-addStateFunc-view:<begin> viewtask,task */
	/*********************/
	/* (3) View Function */
	/*********************/
    public function viewtaskShow($id, Request $request) 
    {
		// get task from id= $id 
        $task = $this->task->get($id, TRUE, TRUE, '')['task']->first();
		$showAll = 1;
		if($request->input('showAll')) {
			$showAll = $request->input('showAll');
		}
		$passdata = array(
		   'task' => $task,
		   'showAll' => $showAll,
		);

		// Authorization 
        $this->getAuthorization('view', $task); 
		
        // direct to JSON output, if requested so.
        if($request->wantsJson()) {
            return (new taskResource($task))
						->additional(['success' => 'true']);
        }
		
		// otherwise, direct to view
        return view('task.viewtask')->with($passdata);
    }
	/* fbsg-signature-addStateFunc-view:<end> viewtask,task */
	/*******************************************/
	/* extra function to get task info by Code */
	/*******************************************/
	public function viewtaskByCodeShow($code, Request $request) {
		$task = task::where('taskcode', $code)->first();
		if($task) {
			$showAll = 1;
			if($request->input('showAll')) {
				$showAll = $request->input('showAll');
			}
			$passdata = array(
			   'task' => $task,
			   'showAll' => $showAll,
			);
	
			// Authorization 
			$this->getAuthorization('view', $task);	
		
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return (new taskResource($task))
							->additional(['success' => 'true']);
			}
			
			// otherwise, direct to view
			return view('task.viewtask')->with($passdata);
		} else {
			return (['success' => 'false', 'description' => 'no task found!']);
		}
	}
	/************************************/
	/* function to handle file download */
	/************************************/
	public function gettaskFileSubmit($filename)
	{
		$task = task::where('remark', 'files/' . $filename)->first();
		
		// Authorization 
		$this->getAuthorization('view', $task);
		
		return Storage::download('files/'.$filename);
	}
	
	/* fbsg-signature-addStateFunc-update:<begin> updatetask,task */
	/***********************/
	/* (4) Update Function */
	/***********************/
    public function updatetaskShow($id) 
    {
		// get task from id= $id 
        $task = $this->task->get($id, TRUE, TRUE, '')['task']->first();
		$passdata = array(
		   'task' => $task,
		);
		
		// Authorization
        $this->getAuthorization('update', $task);

		// direct to view
		// updatetask does not exist, create one if needed
        return view('task.updatetask')->with($passdata);
    }

    public function updatetaskSubmit($id, Request $request) 
    {
		// get task from id= $id 
        $task = $this->task->get($id, TRUE, TRUE, '')['task']->first();

		// Authorization
        $this->getAuthorization('update', $task);

		// validate inputs
		$validator = Validator::make($request->all(), [
			// to be validated here
			'tasktitle' => 'required',
			'taskcode' => 'required',

		]);
		if ($validator->fails()) {
			if($request->wantsJson()) {
                $response = array('errors' => $validator->errors(), 'success' => 'false');
                return $response;
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
		}

		// create new data object
		$task = $this->task->update(
						$id,
						($request->input('tasktitle') ? $request->input('tasktitle') : NULL),
						($request->input('taskcode') ? $request->input('taskcode') : NULL),
						($request->input('duedate') ? date('Y-m-d H:i:s', strtotime($request->input('duedate'))) : NULL),
						($request->input('remark') ? $request->input('remark') : NULL),
        			);
        			
		// save data and redirect
        if($task) {
			
			$message = 'The requested task (id='. $id . ') has been successfully updated.';
			
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return (new taskResource($task))
						->additional(['success' => 'true', 'Locale' => \App::getLocale()]);
			}

			// otherwise, direct to view
			return redirect('/task')->with('message',$message);
        } else {
		
			$message = 'Unable to update the requested item (id='. $id . ')';
			
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'false', 'message' => $message]);
			}

			// otherwise, direct to view
            return redirect('/task')->with('message',$message);
        }
    }
	/* fbsg-signature-addStateFunc-update:<end> updatetask,task */

	/* fbsg-signature-addStateFunc-delete:<begin> deletetask,task */
	/***********************/
	/* (5) Delete Function */
	/***********************/
    public function deletetaskSubmit($id, Request $request) 
    {
		// get task from id = $id 
        $task = $this->task->get($id, TRUE, TRUE, '')['task']->first();

		// Authorization 
        $this->getAuthorization('delete', $task);

		// validate inputs
		$validator = Validator::make($request->all(), [
			// to be validated here
		]);
		if ($validator->fails()) {
			if($request->wantsJson()) {
                $response = array('errors' => $validator->errors(), 'success' => 'false');
                return $response;
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
		}

		$ret_resp = $this->task->delete($id);
		$success = $ret_resp['success'];
		$message = $ret_resp['message'];
        if($success) {

			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'true', 'message' => $message]);
			}

			// otherwise, direct to view
			return redirect('/task')->with('message',$message);
        } else {
					
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'false', 'message' => $message]);
			}

			// otherwise, direct to view
            return redirect('/task')->with('message',$message);
        }
    }
	/* fbsg-signature-addStateFunc-delete:<end> deletetask,task */

	/* fbsg-signature-addStateFunc-cancel:<begin> canceltask,task */
	/***********************/
	/* (6) Cancel Function */
	/***********************/
    public function canceltaskSubmit($id, Request $request) 
    {
		// get task from id = $id 
        $task = $this->task->get($id, TRUE, TRUE, '')['task']->first();

		// Authorization 
        $this->getAuthorization('cancel', $task);

		// validate inputs
		$validator = Validator::make($request->all(), [
			// to be validated here
		]);
		if ($validator->fails()) {
			if($request->wantsJson()) {
                $response = array('errors' => $validator->errors(), 'success' => 'false');
                return $response;
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
		}

		$ret_resp = $this->task->cancel($id);
		$success = $ret_resp['success'];
		$message = $ret_resp['message'];

        if($success) {
			
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'true', 'message' => $message]);
			}

			// otherwise, direct to view
			return redirect('/task')->with('message',$message);
        } else {
		
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'false', 'message' => $message]);
			}

			// otherwise, direct to view
            return redirect('/task')->with('message',$message);
        }
    }
	/* fbsg-signature-addStateFunc-cancel:<end> canceltask,task */

	/* fbsg-signature-addStateFunc-uncancel:<begin> uncanceltask,task */
	/*************************/
	/* (7) Uncancel Function */
	/*************************/
    public function uncanceltaskSubmit($id, Request $request) 
    {
		// get task from id = $id 
        $task = $this->task->get($id, TRUE, TRUE, '')['task']->first();

		// Authorization 
        $this->getAuthorization('uncancel', $task);

		// validate inputs
		$validator = Validator::make($request->all(), [
			// to be validated here
		]);
		if ($validator->fails()) {
			if($request->wantsJson()) {
                $response = array('errors' => $validator->errors(), 'success' => 'false');
                return $response;
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
		}

		// uncancelling
		$ret_resp = $this->task->uncancel($id, taskStatus::where('name','active')->first()->id);
		$success = $ret_resp['success'];
		$message = $ret_resp['message'];

        if($success) {
						
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'true', 'message' => $message]);
			}

			// otherwise, direct to view
			return redirect('/task')->with('message',$message);
        } else {
					
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'false', 'message' => $message]);
			}

			// otherwise, direct to view
            return redirect('/task')->with('message',$message);
        }
    }
	/* fbsg-signature-addStateFunc-uncancel:<end> uncanceltask,task */

	/* fbsg-signature-addStateFunc-branchselect:<begin> approvetask,task */
	/*************************/
	/* (8) Activate Function */
	/*************************/
    public function approvetaskShow($id) 
    {
		// get task from id = $id 
        $task = $this->task->get($id, TRUE, TRUE, '')['task']->first();
		$passdata = array(
		   'task' => $task,
		);

		// Authorization 
        $this->getAuthorization('activateapprovetask', $task);

		// direct to view
        return view('task.approvetask')->with($passdata);
    }
	
    public function approvetaskSubmit($id, Request $request) 
    {
		// get task from id = $id
        $task = $this->task->get($id, TRUE, TRUE, '')['task']->first();

		// Authorization 
        $this->getAuthorization('activateapprovetask', $task);

		// validate inputs
		$validator = Validator::make($request->all(), [
			// to be validated here
		]);
		if ($validator->fails()) {
			if($request->wantsJson()) {
                $response = array('message' => $validator->messages(), 'success' => 'false');
                return $response;
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
		}
		
		// change status, save and redirect
        $ret_resp = $this->task->approvetask($id, taskStatus::where('name','active')->first()->id);
        $success = $ret_resp['success'];
        $message = $ret_resp['message'];

        if($success) {
						
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return (new taskResource($task))
						->additional(['success' => 'true', 'Locale' => \App::getLocale()]);
			}

			// otherwise, direct to view
			return redirect('/task')->with('message',$message);
        } else {
		
			// direct to JSON output, if requested so.
			if($request->wantsJson()) {
				return response()->json(['success' => 'false', 'message' => $message]);
			}

			// otherwise, direct to view
            return redirect('/task')->with('message',$message);
        }
    }
	/* fbsg-signature-addStateFunc-branchselect:<end> approvetask,task */

}
