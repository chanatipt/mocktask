<?php

namespace App\Repositories;
/* fbsg-signature-addRepositoryUse:<begin> task */
use Auth;
use App\task;
use App\taskStatus;
/* fbsg-signature-addRepositoryUse:<end> task */
use Illuminate\Support\Facades\Storage;

class taskRepository implements taskRepositoryInterface
{
	/* fbsg-signature-createRepositories:<begin> */
	/* fbsg-signature-addRepositoryFuncGet:<begin> task  */
	/***************************************************************/
	/* get function                                                */
	/* ============                                                */
	/*                                                             */
	/* This function looks up and returns found objects.           */
	/* The returned value is an array of two entities.             */
	/*                                                             */
	/* Note: when $id = NULL => get all                            */
	/*       when $notinactive = TRUE => all including 'inactive'  */
	/*                                   status, otherwise no      */
	/*                                   'inactive' status         */
	/*       when $searchVal = '' => no extra filtered keywords    */
	/***************************************************************/
	public function get($id = NULL, $notinactive = FALSE, $protected = TRUE, $searchVal = '') {

		$task = NULL;
		$recordsTotal = 0;

		/* protect resources from non-logged in users when protected */
		if(!(Auth::guest() and $protected)) {
			if(Auth::user()->isPrivilegedUser()) {
				$notinactive = TRUE;
				if($notinactive) {
					if($id) {
						$task = task::where('id',$id)->whereIn('status_id', \App\taskStatus::where('name', '!=', 'inactive')->pluck('id'));
					} else {
						$task = task::whereIn('status_id', \App\taskStatus::where('name', '!=', 'inactive')->pluck('id'));
					}
				} else {
					if($id) {
						$task = task::where('id',$id);
					} else {
						$task = task::where('id', '>', 0);
					}
				}
			} else {
				if($id) {
					$task = task::where([['user_id', Auth::user()->id],['id', $id],
												 ['status_id', '!=' , taskStatus::where('name','inactive')->first()->id]]);
				} else {
					$task = task::where([['user_id', Auth::user()->id],
												['status_id', '!=' , taskStatus::where('name','inactive')->first()->id]]);
				}
			}

			$recordsTotal = $task->count();
			$keywords = explode(",", $searchVal);

			foreach($keywords as $keyword) {
				$keyword = trim($keyword);
				if(!empty($keyword)) 
				{
					$task->where(function($query) use ($keyword) {
                      $query->where('tasktitle', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('taskcode', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('duedate', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('remark', 'LIKE', '%'.$keyword.'%')
                            ->orWhereHas('taskStatus', function($query) use($keyword) {
                              $query->where('task_statuses.name','like', '%'.$keyword.'%');
                            });
					});
				}
			}
			$task = $task->get();
		}
		return array('task' => $task, 'recordsTotal' => $recordsTotal);
	}
	/* fbsg-signature-addRepositoryFuncGet:<end> task  */
	/* fbsg-signature-addRepositoryFuncCreate:<begin> task  */
	/***************************************************************/
	/* create function                                             */
	/* ===============                                             */
	/*                                                             */
	/* This function creates new object with the supplied inputs.  */
	/*                                                             */
	/***************************************************************/
	public function create($user_id, $status_id, $tasktitle, $taskcode, $duedate, $remark)
	{
		// create new task 
        $task = new task;

        // update attributes
        if($tasktitle != NULL) {
           $task->tasktitle = $tasktitle;
        }
        if($taskcode != NULL) {
           $task->taskcode = $taskcode;
        }
        if($duedate != NULL) {
           $task->duedate = $duedate;
        }
        if($remark != NULL) {
		   $task->remark = $remark->store('files');	   
        }
		$task->user_id = $user_id;
        $task->status_id = $status_id;

        if($task->save()) {
	        return $task;
        }

        return NULL;
	}
	/* fbsg-signature-addRepositoryFuncCreate:<end> task  */
	/* fbsg-signature-addRepositoryFuncUpdate:<begin> task  */
	/***************************************************************/
	/* Update function                                             */
	/* ===============                                             */
	/*                                                             */
	/* This function update the object id = $id with the supplied  */
	/* inputs.                                                     */
	/*                                                             */
	/***************************************************************/
	public function update($id, $tasktitle, $taskcode, $duedate, $remark)
	{
		// get the task with id = $id 
        $task = $this->get($id)['task']->first();
        if(!$task) return NULL;
		
		// update attributes
        if($tasktitle != NULL) {
           $task->tasktitle = $tasktitle;
        }
        if($taskcode != NULL) {
           $task->taskcode = $taskcode;
        }
        if($duedate != NULL) {
           $task->duedate = $duedate;
        }
        if($remark != NULL) {
           $task->remark = $remark;
        }

		if($task->save()) {
	        return $task;
        }

        return NULL;
	}
	/* fbsg-signature-addRepositoryFuncUpdate:<end> task  */
	/* fbsg-signature-addRepositoryFuncDelete:<begin> task  */
	/***************************************************************/
	/* Delete function                                             */
	/* ===============                                             */
	/*                                                             */
	/* This function deletes the object id = $id.                  */
	/*                                                             */
	/***************************************************************/
	public function delete($id)
	{
		// get the task with id = $id 
        $task = $this->get($id)['task']->first();
        if(!$task) return array('success' => FALSE, 'message' => 'Unable to find task with id =' . $id);
		
		// delete
		if($task->delete()) {
	        return array('success' => TRUE, 'message' => 'The requested task (id='. $id . ') has been successfully deleted.');
        }

        return array('success' => FALSE, 'message' => 'Unable to delete task with id =' . $id);
	}
	/* fbsg-signature-addRepositoryFuncDelete:<end> task  */
	/* fbsg-signature-addRepositoryFuncCancel:<begin> task  */
	/***************************************************************/
	/* Cancel function                                             */
	/* ===============                                             */
	/*                                                             */
	/* This function cancels the object id = $id. to 'inactive'    */
	/* status.                                                    */
	/*                                                             */
	/***************************************************************/
	public function cancel($id)
	{
		// get the task with id = $id 
        $task = $this->get($id)['task']->first();
        if(!$task) return array('success' => FALSE, 'message' => 'Unable to find task with id =' . $id);
		
		// cancel
		$task->status_id = taskStatus::where('name','inactive')->first()->id;
		if($task->save()) {
			$cascade_success = TRUE;
			$err_msg = array();

			if($cascade_success) {
				return array('success' => TRUE, 'message' => 'The requested task (id='. $id . ') has been successfully cancelled.');
			} else {
				$all_err_msg = '';
				foreach($err_msg as $msg) {
					$all_err_msg = $all_err_msg . $err;
				}
				return array('success' => FALSE, 'message' => 'The requested task (id='. $id . ') has been successfully cancelled but ' . $all_err_msg);
			}	

        }

        return array('success' => FALSE, 'message' => 'Unable to cancel task with id =' . $id);
	}
	/* fbsg-signature-addRepositoryFuncCancel:<end> task  */
	/* fbsg-signature-addRepositoryFuncUncancel:<begin> task  */
	/***************************************************************/
	/* Uncancel function                                           */
	/* =================                                           */
	/*                                                             */
	/* This function uncancels the object id = $id. to status_id   */
	/* status.                                                     */
	/*                                                             */
	/***************************************************************/
	public function uncancel($id, $status_id)
	{
		// get the task with id = $id 
        $task = $this->get($id)['task']->first();
        if(!$task) return array('success' => FALSE, 'message' => 'Unable to find task with id =' . $id);
		
		// uncancel
		$task->status_id = $status_id;
		if($task->save()) {
	        return array('success' => TRUE, 'message' => 'The requested task (id='. $id . ') has been successfully uncancelled.');;
        }

        return array('success' => FALSE, 'message' => 'Unable to uncancel task with id =' . $id);
	}
	/* fbsg-signature-addRepositoryFuncUncancel:<end> task  */
	/* fbsg-signature-addRepositoryFuncActivate:<begin> task, approvetask */
	/***************************************************************/
	/* Activate function                                           */
	/* =================                                           */
	/*                                                             */
	/* This function activates the object id = $id. to status_id   */
	/* status.                                                     */
	/*                                                             */
	/***************************************************************/
	public function approvetask($id, $status_id)
	{
		// get the task with id = $id 
        $task = $this->get($id)['task']->first();
        if(!$task) return array('success' => FALSE, 'message' => 'Unable to find task with id =' . $id);
		
		// activating
		$task->status_id = $status_id;
		if($task->save()) {
	        return array('success' => TRUE, 'message' => 'The requested task (id='. $id . ') has been successfully activated.');;
        }

        return array('success' => FALSE, 'message' => 'Unable to activate task with id =' . $id);
	}
	/* fbsg-signature-addRepositoryFuncActivate:<end> task, approvetask */
	/* fbsg-signature-createRepositories:<end> */
}
