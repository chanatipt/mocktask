<?php

namespace App\Repositories;

interface taskRepositoryInterface
{
	/* fbsg-signature-createRepositories:<begin> */
	/* fbsg-signature-addRepositoryInterface:<begin> task */
	public function get($id, $notinactive, $protected, $searchVal);
	public function create($user_id, $status_id, $tasktitle, $taskcode, $duedate, $remark);
	public function update($id, $tasktitle, $taskcode, $duedate, $remark);
	public function delete($id);
	public function cancel($id);
	public function uncancel($id, $status_id);
   public function approvetask($id, $status_id);

	/* fbsg-signature-addRepositoryInterface:<end> task */
	/* fbsg-signature-createRepositories:<end> */
}
