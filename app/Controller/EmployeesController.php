<?php
App::uses('AppController', 'Controller');

class EmployeesController extends AppController {
	public $helpers = array('Html', 'Form', 'Js', 'Session', 'Paginator');

	public $components = array('Session', 'Paginator');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'newlayout';
	}

	public function index() {
		$this->layout = "newlayout";

		$this->Paginator->settings = array(
	      'paramType' => 'querystring',
	      'limit' => 10
	    );
	    $lists = $this->Paginator->paginate('Employee');

		$this->set(compact('lists'));
	}

	public function search() {
		if($this->params->query['name']) {
			$keyword=$this->params->query['name'];
			$conditions=array("Employee.name LIKE '%$keyword%'", );

			$this->Paginator->settings = array(
		      'paramType' => 'querystring',
		      'limit' => 10,
		      'conditions' => $conditions
		    );
		    $lists = $this->Paginator->paginate('Employee');

			$this->set(compact('lists'));
		}
	}

	public function add() {
		Configure::write('debug', 2);
		$this->layout = "newlayout";

		if($this->request->is('post')) {
			// check email
			$getemail = $this->Employee->findByEmail($this->request->data['Employee']['email']);

			if(!empty($getemail)) {
				$this->Flash->error(__('Email already exists.'));
			} else {
				if (!empty($this->request->data['Employee']['pic']['name'])) {
					$file = $this->request->data['Employee']['pic'];
					$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
					
					$allow_ext = array('jpg', 'jpeg', 'png');
					

					if(in_array($extension, $allow_ext)){
						$newfilename = round(microtime(true)) . '.' . $extension;
						move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/emp/' . $newfilename);
						$this->request->data['Employee']['image'] = $newfilename;
					} else{
						$this->Session->setFlash('File extension not supported!', 'flash_message');
					}
				}
				unset($this->request->data['Employee']['pic']);
				$this->request->data['Employee']['pic'] = $this->request->data['Employee']['image'];
				$this->Employee->create();
				if($this->Employee->save($this->request->data)) {
					$this->Flash->success(__('Employee has been saved.'));
					return $this->redirect(array('action' => 'index'));
				}
			}
		}
	}

	public function edit($id=null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid employee id'));
		}

		$emp = $this->Employee->findById($id);
		if (!$emp) {
			throw new NotFoundException(__('Invalid employee'));
		}

		if ($this->request->is(array('post', 'put'))) {
	      	$upload = array();

		    // PHOTO Upload
		    if(isset($this->request->data['Employee']['pic']) && ($this->request->data['Employee']['pic']['error'] == 0)) {
		        $file = $this->request->data['Employee']['pic'];
				$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
				
				$allow_ext = array('jpg', 'jpeg', 'png');
				

				if(in_array($extension, $allow_ext)){
					$newfilename = round(microtime(true)) . '.' . $extension;
					move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/emp/' . $newfilename);
					$image = $newfilename;
				} else{
					$this->Session->setFlash('File extension not supported!', 'flash_message');
				}
		    }

		    unset($this->request->data['Employee']['pic']);
			$this->request->data['Employee']['pic'] = $image;

			// pr($this->request->data);
			// die;

			$this->Employee->id = $id;
			if ($this->Employee->save($this->request->data)) {
				$this->Flash->success(__('Employee has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('employee not updated.'));
		}

		if (!$this->request->data) {
			$this->request->data = $emp;
		}
	}

	public function delete($id) {
	    $this->request->onlyAllow('post', 'delete');

	    if ($this->request->is('get')) {
	      throw new MethodNotAllowedException();
	    }

	    $options = array('conditions' => array('Employee.id' => $id));
	    $emp = $this->Employee->find('first', $options);

	    if (!$emp) {
	      throw new NotFoundException(__('Invalid employee'));
	    }

	    if($this->Employee->delete($id, true)) {
	      $this->Flash->success(__('Employee has been deleted!'));
	      return $this->redirect(array('action' => 'index'));
	    }
	    $this->Flash->error(__('Employee not deleted'));
	}
}