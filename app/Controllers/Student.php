<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\StudentModel;
 
class Student extends ResourceController
{
	use ResponseTrait;
	//get all Student data
    public function index()
    {    
        $model = new StudentModel();
 
        $data['students'] = $model->orderBy('id', 'DESC')->findAll();
        
        return $this->respond($data);
    } 
	//get single student data
	public function show($id = null)
    {
      
		$model = new StudentModel();
		
		$data = $model->where('id', $id)->first();
	 
		if($data){
			return $this->respond($data);
		}else{
			return $this->failNotFound('No Data found');
		}
	}	

	//create student data
    public function create()
    {  
         
        $model = new StudentModel();
		
        $data = [
            'first_name' => $this->request->getVar('first_name'),
            'last_name'  => $this->request->getVar('last_name'),
            'address'  => $this->request->getVar('address'),
            'email'  => $this->request->getVar('email'),
            'mobile'  => $this->request->getVar('mobile'),
        ];
        $model->insert_data($data);
		
		
		$response = [
          'status'   => 201,
          'error'    => null,
          'messages' => [
              'success' => 'Student Created successfully'
          ]
      ];
      return $this->respondCreated($response);
    }
 
   
	//update student data
    public function update($id = null)
    {  
 		 
		$model = new StudentModel();

		$data = [
            'first_name' => $this->request->getVar('first_name'),
            'last_name'  => $this->request->getVar('last_name'),
            'address'  => $this->request->getVar('address'),
            'email'  => $this->request->getVar('email'),
            'mobile'  => $this->request->getVar('mobile'),
        ];

		$update = $model->update($id,$data);
		$response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Student Updated successfully'
            ]
        ];
        return $this->respond($response);
    }
	
	//delete student data
    public function delete($id = null){
		$model = new StudentModel();
		$data = $model->find($id);
        if($data){
            $model->where('id', $id)->delete();
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Student Deleted successfully'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No Data Found');
        }
    }
}

?>