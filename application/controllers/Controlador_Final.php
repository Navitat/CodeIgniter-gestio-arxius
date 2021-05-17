<?php

class Controlador_Final extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        public function _output($dades){
                echo $dades;
            }

        
        //VISTA LOGIN-REGISTRE
        public function index()
        {
                $this->load->view('Login');
        }

        //GESTIO DADES REGISTRE - LOGIN
        public function validation(){
                $this->load->library('form_validation');
                $this->load->database();

                if(isset($_POST['register'])){
                        
                        $this->form_validation->run();
                        $this->form_validation->set_rules('codiU', 'CodiU', 'required|max_length[20]|is_unique[usuaris.codiU]',array('required' => 'Obligatori omplir el camp %s', 'max_length' => 'Mida màxima de %s és 20.', 'is_unique' => 'Aquest codi ja existeix.'));
                        $this->form_validation->set_rules('mail', 'Mail', 'required|valid_email|is_unique[usuaris.correu]',array('required' => 'Obligatori omplir el camp %s', 'valid_email' => 'El correu introduït ha de tenir un format vàlid.', 'is_unique' => 'Aquest correu ja existeix.'));
                        $this->form_validation->set_rules('telefon', 'Telefon', 'required|Numeric',array('required' => 'Obligatori omplir el camp %s', 'Numeric' => 'El camp ha de ser numéric.'));
                        $this->form_validation->set_rules('password', 'Password', 'required',array('required' => 'Obligatori omplir el camp %s', 'max_length' => 'Mida màxima de %s és 20.'));
                        $this->form_validation->set_rules('password2', 'Password', 'Matches[password]',array('Matches' => 'Les contrasenyes no coincideixen.'));
                        
                        $dades=$this->input->post();

                        if ($this->form_validation->run() == FALSE){
                                $this->load->view('login',$dades);
                        }else{
                                $this->load->model('ModelFinal');
                                $res['resultat'] = $this->ModelFinal->inserirUsuari($_POST);

                                echo '<script language="javascript">';
                                echo 'alert("Usuari registrat correctament. Ja pots loguejar-te")';
                                echo '</script>';
                                
                                $this->load->view('login', $res);
                        }

                }else if(isset($_POST['login'])){
                        $this->form_validation->run();
                        $this->form_validation->set_rules('codiU2', 'CodiU', 'required|max_length[20]',array('required' => 'Obligatori omplir el camp %s', 'max_length' => 'Mida màxima de %s és 20.'));
                        $this->form_validation->set_rules('password3', 'Password', 'required',array('required' => 'Obligatori omplir el camp %s', 'max_length' => 'Mida màxima de %s és 20.'));
                        
                        $dades=$this->input->post();
                        
                        if ($this->form_validation->run() == FALSE){
                                $this->load->view('login',$dades);
                        }else{
                                $username = $this->input->post('codiU2');
                                $password = $this->input->post('password3');

                                //funcion modelo
                                $this->load->model('ModelFinal');
                                if($this->ModelFinal->can_login($username, $password)){
                                        $session_data = array(
                                                'username' => $username
                                        );
                                        $this->session->set_userdata($session_data);
                                        redirect(base_url() . 'index.php/Controlador_Final/gestio');
                                        //$this->load->view('Gestio');
                                }else{
                                        $this->session->set_flashdata('error', 'Invalid Username and/or Password');  
                                        redirect(base_url() . 'index.php/Controlador_Final'); 
                                        //$this->load->view('login'); 
                                }

                        }
                }

                
        }


        //VISTA GESTIO D'ARXIUS
        public function Gestio(){
                if($this->session->userdata('username') != ''){
                        //$this->load->view('Gestio');

                        $username = $this->session->userdata('username');

                        $this->load->model('ModelFinal');

                        //SELECT ARXIUS PROPIS PUJATS
                        $dades['arxiusP'] = $this->ModelFinal->arxius_propis($username);

                        //SELECT ARXIUS COMPARTITS AMB MI
                        $dades['arxiusC'] = $this->ModelFinal->arxius_comp($username);

                        $this->load->view('Gestio', $dades);

                        //PUJAR ARXIU
                        if(isset($_POST['pujar'])){
                                
                                $config['upload_path']          = './uploads/';
                                $config['allowed_types']        = 'gif|jpg|png';
                                $config['max_size']             = 100;
                                $config['max_width']            = 1024;
                                $config['max_height']           = 768;

                                $this->load->library('upload', $config);

                                if ( ! $this->upload->do_upload('userfile'))
                                {
                                        $error = array('error' => $this->upload->display_errors());

                                        echo '<script language="javascript">';
                                        echo 'alert('.$error.')';
                                        echo '</script>';

                                        header("Refresh:0");
                                }
                                else
                                {
                                        $this->ModelFinal->store_pic_data($this->upload->data(), $username);

                                        echo '<script language="javascript">';
                                        echo 'alert("Arxiu pujat correctament")';
                                        echo '</script>';

                                        header("Refresh:0");
                                }
                        }

                }else{
                        redirect(base_url() . 'index.php/Controlador_Final'); 
                }
                

        }
        //LOG OUT
        public function logout(){  
           $this->session->unset_userdata('username');  
           redirect(base_url() . 'index.php/Controlador_Final');  
        } 

        //ESBORRAR
        public function esborrar($codiF){

                $this->load->model('ModelFinal');

                //DELETE ARXIU COMPARTIT
                $this->ModelFinal->esborrarCompartit($codiF);
                
                //DELETE ARXIU PROPI
                $this->ModelFinal->esborrar($codiF);

                

                redirect(base_url() . 'index.php/Controlador_Final/gestio');
        }

        //COMPARTIR
        public function compartir($codiF){
                $this->load->model('ModelFinal');

                $username = $this->session->userdata('username');

                $dades['codiF'] = $codiF;

                //sel users
                $dades['result'] = $this->ModelFinal->selUser($username);

                $this->load->view('compartir', $dades);

                if(isset($_POST['compartir'])){
                        $dades=$this->input->post();
                        
                        $codiUC = $this->input->post('compartir');

                        $this->ModelFinal->insertArxiuC($codiF, $codiUC);

                        echo '<script language="javascript">';
                        echo 'alert("Arxiu compartit correctament")';
                        echo '</script>';

                }
        }
}
?>