<?php
class BooksController extends AppController {
    public $helpers = array('Html', 'Form');
   	public $uses = array('Category');

    public function isAuthorized($user) {
	    if (in_array($this->action, array('add','edit', 'delete'))) {
	        // Admin can access every action
		    if (isset($user['role']) && $user['role'] === 'admin') {
		        return true;
		    }
	    }
    return parent::isAuthorized($user);
 }


    public function index() {
        $this->set('books', $this->Category->Book->find('all'));
    }
    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid book'));
        }

        $book = $this->Category->Book->findById($id);
        if (!$book) {
            throw new NotFoundException(__('Invalid Book'));
        }
        $views = $book['Book']['no_views'] + 1;
	    $this->Category->Book->id = $id;
	    $this->Category->Book->saveField('no_views', $views);
        $this->set('book', $book);
    }

    public function add() {
        if ($this->request->is('post')) {

        	// Initialize filename-variable
			$picture = null;

			if (
			    !empty($this->request->data['Book']['picture']['tmp_name'])
			    && is_uploaded_file($this->request->data['Book']['picture']['tmp_name'])
			) {
			    // Strip path information
			    $picture = basename($this->request->data['Book']['picture']['name']); 
			    move_uploaded_file(
			        $this->data['Book']['picture']['tmp_name'],
			        IMAGES . DS . 'documents' . DS . $picture
			    );
			}

			// Set the file-name only to save in the database
			$this->request->data['Book']['picture'] = $picture;
			// Initialize filename-variable
			$download = null;

			if (
			    !empty($this->request->data['Book']['download']['tmp_name'])
			    && is_uploaded_file($this->request->data['Book']['download']['tmp_name'])
			) {
			    // Strip path information
			    $download = basename($this->request->data['Book']['download']['name']); 
			    move_uploaded_file(
			        $this->request->data['Book']['download']['tmp_name'],
			        WWW_ROOT . DS . 'documents' . DS . $download
			    );
			}

			// Set the file-name only to save in the database
			$this->request->data['Book']['download'] = $download;


            $this->Category->Book->create();
            if ($this->Category->Book->save($this->request->data)) {
                $this->Flash->success(__('Your Book has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to add your Book.'));
        }
        $categories = $this->Category->find('list',array(
        'fields' => array('Category.id', 'Category.category_name')  ));
        $this->set('categories', $categories);
    }

    public function edit($id = null) {
	    if (!$id) {
	        throw new NotFoundException(__('Invalid post'));
	    }

	    $book = $this->Category->Book->findById($id);
	    if (!$book) {
	        throw new NotFoundException(__('Invalid post'));
	    }

	    if ($this->request->is(array('post', 'put'))) {
	        $this->Category->Book->id = $id;

	        if (
			    !empty($this->request->data['Book']['picture']['tmp_name'])
			    && is_uploaded_file($this->request->data['Book']['picture']['tmp_name'])
			) {
			    // Strip path information
			    $picture = basename($this->request->data['Book']['picture']['name']); 
			    move_uploaded_file(
			        $this->data['Book']['picture']['tmp_name'],
			        IMAGES . DS . 'documents' . DS . $picture
			    );
				$this->request->data['Book']['picture'] = $picture;
			} else
			  unset($this->request->data['Book']['picture']);
			 

			// Initialize filename-variable
			$download = null;

			if (
			    !empty($this->request->data['Book']['download']['tmp_name'])
			    && is_uploaded_file($this->request->data['Book']['download']['tmp_name'])
			) {
			    // Strip path information
			    $download = basename($this->request->data['Book']['download']['name']); 
			    move_uploaded_file(
			        $this->request->data['Book']['download']['tmp_name'],
			        WWW_ROOT . DS . 'documents' . DS . $download
			    );
				$this->request->data['Book']['download'] = $download;
			} else 
			unset($this->request->data['Book']['download']);


	        if ($this->Category->Book->save($this->request->data)) {
	            $this->Flash->success(__('Your post has been updated.'));
	            return $this->redirect(array('action' => 'index'));
	        }
	        $this->Flash->error(__('Unable to update your post.'));
	    }

	    if (!$this->request->data) {
	        $this->request->data = $book;
	        $categories = $this->Category->find('list',array(
		        'fields' => array('Category.id', 'Category.category_name') ));
		        $this->set('categories', $categories);
	    }

	}
    public function delete($id) {
	    if ($this->request->is('get')) {
	        throw new MethodNotAllowedException();
	    }

	    if ($this->Category->Book->delete($id)) {
	        $this->Flash->success(
	            __('The book with id: %s has been deleted.', h($id))
	        );
	    } else {
	        $this->Flash->error(
	            __('The book with id: %s could not be deleted.', h($id))
	        );
	    }

	    return $this->redirect(array('action' => 'index'));
	}
	public function download($id) {
		if (!$id) {
	        throw new NotFoundException(__('Invalid book'));
	    }

	    $book = $this->Category->Book->findById($id);
	    if (!$book) {
	        throw new NotFoundException(__('Invalid post'));
	    }
	    $download = $book['Book']['no_downloads'] + 1;
	    $this->Category->Book->id = $id;
	    $this->Category->Book->saveField('no_downloads', $download);
		$this->autoRender = false; // tell CakePHP that we don't need any view rendering in this case
		$this->response->file(WWW_ROOT . DS . 'documents' . DS .$book['Book']['download'], array('download' => true, 'name' => $book['Book']['download']));
	}

}

?>