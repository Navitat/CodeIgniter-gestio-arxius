<?php

    /* MODEL */
    class ModelFinal extends CI_Model{
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function inserirUsuari(){

            $codiU = $_POST["codiU"];
            $correu = $_POST["mail"];
            $password = $_POST["password"];
            $telefon = $_POST["telefon"];

            $sql = "INSERT INTO usuaris(codiU,correu,password,telefon) VALUES('$codiU','$correu','$password',$telefon)";

            $this->db->query($sql);
            $num_files = $this->db->affected_rows();

            return $num_files;
        }

        public function can_login($username, $password){
            $this->db->where('codiU', $username);
            $this->db->where('password', $password);
            $query = $this->db->get('usuaris'); //SELECT * FROM usuaris WHERE codiU = '$username' AND password = '$password'

            if($query->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        //SELECT ARXIUS PROPIS GESTIO
        public function arxius_propis($username){
            $this->db->where('codiU', $username);

            $query = $this->db->get('fitxers');

            return $query;
        }

        //SELECT ARXIUS COMPARTITS AMB MI
        public function arxius_comp($username){

            $this->db->select('*')
            ->from('compartir')
            ->join('fitxers', 'fitxers.codiF = compartir.codiF') 
            ->where('codiUC', $username);

            $query = $this->db->get();

            return $query;
        }

        //PUJAR ARXIUS
        function store_pic_data($data, $username){

            $imgdata = file_get_contents($data['full_path']); //pillar la ruta de la imagen completa
            $imgname = $this->upload->data('file_name');
            $imgtype = $this->upload->data('file_type');
            $data = array(
                'nomF' => $imgname,
                'tipusF' => $imgtype,
                'data' => date("Y-m-d"),
                'contingut' => $imgdata,
                'codiU' => $username
            );
            $this->db->where('id', $username);
            $this->db->insert('fitxers', $data);
        }

        //ESBORRAR
        public function esborrar($codiF){
            $this->db->where('codiF', $codiF);

            $this->db->delete('fitxers');
        }

        ////COMPARTIR

        //SELECT USUARIS
        public function selUser($username){

            $query = $this->db->query('SELECT codiU FROM usuaris');


            return $query->result();
        }

        //INSERT COMPARTIR
        public function insertArxiuC($codiF, $codiUC){
            $data = array(
                'codiF' => $codiF,
                'codiUC' => $codiUC
            );

            $this->db->insert('compartir', $data);
        }

        //ESBORRAR COMPARTIT (NO PUC BORRAR ARXIUS COMPARTITS)
        public function esborrarCompartit($codiF){
            $this->db->where('codiF', $codiF);

            $this->db->delete('compartir');
        }
    }

?>