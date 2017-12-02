<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
class Get_data extends REST_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }    
    
    public function user_get(){
       $r = $this->api_model->read();
       $this->response($r); 
    }
    
    public function user_put(){
        $id = $this->uri->segment(3);

        $data = array('name' => $this->input->get('name'),
            'pass' => $this->input->get('pass'),
            'type' => $this->input->get('type')
        );

        $r = $this->api_model->update($id,$data);
        $this->response($r); 
    }

    public function user_post(){
        $data = array('name' => $this->input->post('name'),
            'pass' => $this->input->post('pass'),
            'type' => $this->input->post('type')
        );
        $r = $this->api_model->insert($data);
        $this->response($r); 
    }
    public function user_delete(){
        $id = $this->uri->segment(3);
        $r = $this->api_model->delete($id);
        $this->response($r); 
    }
}