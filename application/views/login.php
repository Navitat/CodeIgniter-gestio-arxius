<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/custom.css">
    <title>Activitat Final - Login</title>
</head>

<style>
    .form-group p{
        color: red;
    }
    /* width */
    ::-webkit-scrollbar {
    width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
    background: #f1f1f1; 
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: #888; 
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    background: #555; 
    }
</style>

<body class="bg-secondary">

<div id="wrapper">

<!-- Sidebar -->
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <?php echo anchor('Controlador_Final', 'Log-in', 'class="h1"'); ?>
        </li>
        <!--<li>
            <?php echo anchor('Controlador_Final', 'Log-in'); ?>
        </li>
        <li>
            <?php echo anchor('Controlador_Final/Gestio', 'Gestió'); ?>
        </li>-->
    </ul>
</div>
<!-- /#sidebar-wrapper -->

<!-- Page Content -->
<div id="page-content-wrapper">
    <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
    <div class="container-fluid">
        <header class="container text-center p-2">
            <h2>Validació d'usuaris</h2>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div id="registre" class="marco">
                        <h3>Registre</h3>
                        <?php
                            echo form_open('Controlador_Final/validation');

                                //CodiU
                                echo '<div class="form-group">';
                                echo form_label('Codi Usuari ', 'codi usuari');
                                $valueCodi=(!empty($codiU))?$codiU:'';
                                $dataCodi = array(
                                    'name' => 'codiU',
                                    'value' => $valueCodi,
                                    'class' => 'form-control'
                                );
                                echo form_input($dataCodi);
                                echo form_error('codiU');
                                echo '</div>';

                                //EMAIL
                                echo '<div class="form-group">';
                                echo form_label('Email ', 'mail');
                                $valueMail=(!empty($mail))?$mail:'';
                                $dataMail = array(
                                    'name' => 'mail',
                                    'value' => $valueMail,
                                    'class' => 'form-control'
                                );
                                echo form_input($dataMail);
                                echo form_error('mail');
                                echo '</div>';

                                //TELEFON
                                echo '<div class="form-group">';
                                echo form_label('Telefon ', 'telefon');
                                $valueTel=(!empty($tel))?$tel:'';
                                $dataTel = array(
                                    'name' => 'telefon',
                                    'value' => $valueTel,
                                    'class' => 'form-control'
                                );
                                echo form_input($dataTel);
                                echo form_error('telefon');
                                echo '</div>';

                                //PASSWORD
                                echo '<div class="form-group">';
                                echo form_label('Contrasenya ', 'password');
                                $valuePass=(!empty($password))?$password:'';
                                $dataPass = array(
                                    'name' => 'password',
                                    'type' => 'password',
                                    'value' => $valuePass,
                                    'class' => 'form-control'
                                );
                                echo form_input($dataPass);
                                echo form_error('password');
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo form_label('Torna a introduïr la contrasenya ', 'password2');
                                $valuePass2=(!empty($password2))?$password2:'';
                                $dataPass2 = array(
                                    'name' => 'password2',
                                    'type' => 'password',
                                    'value' => $valuePass2,
                                    'class' => 'form-control'
                                );
                                echo form_input($dataPass2);
                                echo form_error('password2');
                                echo '</div>';

                                //SUBMIT
                                $dataButton = array(
                                    'name' => 'register',
                                    'value' => 'Registrar-se',
                                    'class' => 'btn btn-primary'
                                );
                                echo '<div class="form-group text-center">';
                                echo form_submit($dataButton);
                                echo '</div>';


                            echo form_close();
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div id="login" class="marco">
                        <h3>Log-in</h3>
                        <?php
                            echo form_open('Controlador_Final/validation');

                                //CodiU
                                echo '<div class="form-group">';
                                echo form_label('Codi Usuari ', 'codi usuari');
                                $valueCodi=(!empty($codiU))?$codiU:'';
                                $dataCodi = array(
                                    'name' => 'codiU2',
                                    'value' => $valueCodi,
                                    'class' => 'form-control'
                                );
                                echo form_input($dataCodi);
                                echo form_error('codiU2');
                                echo '</div>';

                                //PASSWORD
                                echo '<div class="form-group">';
                                echo form_label('Contrasenya ', 'password');
                                $valuePass=(!empty($password))?$password:'';
                                $dataPass = array(
                                    'name' => 'password3',
                                    'type' => 'password',
                                    'value' => $valuePass,
                                    'class' => 'form-control'
                                );
                                echo form_input($dataPass);
                                echo form_error('password3');
                                echo '</div>';

                                //SUBMIT
                                $dataButton = array(
                                    'name' => 'login',
                                    'value' => 'Log-in',
                                    'class' => 'btn btn-primary'
                                );
                                echo '<div class="form-group text-center">';
                                echo form_submit($dataButton);
                                echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';  
                                echo '</div>';


                            echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
</div>


<!-- /#page-content-wrapper -->

</div>

    <!--Scripts-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
        $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
</html>