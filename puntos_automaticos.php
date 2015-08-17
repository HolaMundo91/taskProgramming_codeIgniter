<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjobs extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();

    }
    
    public function index() {
        
        redirect( site_url() );
    
    }
    
    /*
     * Da puntos de forma automatica
     * a todos aquellos usuarios que
     * han pagado o han ganado el logro
     * 'puntos automaticos'. Ademas,
     * se acumula con el x2.
     */
    public function mensualidad() {
        
        $this->load->library('session');
        $this->load->model( 'bonuses' );
        $this->load->model( 'users' );
        $this->load->model( 'bonificaciones_granted' );
        $this->load->model( 'bonuses' );
        $this->load->model( 'achievement_bonificaciones' );
        $this->load->helper('date');
        
        $this->load->view('header');
        
        $usuarios = $this->users->todas_las_id_user();
        $id_x2 = $this->bonuses->buscar_bonificacion( array('nombre' => 'x2') );
        $id_puntos_automaticos = $this->bonuses->buscar_bonificacion( array('nombre' => 'puntos_automaticos') );
        
        foreach($usuarios->result() as $usuario){
            $mensualidad_logro = $this->achievement_bonificaciones->bonificacion_usuario( array(
                    'id_user'           => $usuario->id,
                    'id_bonificacion'   => $id_puntos_automaticos->row(0)->id,
            ));
            $mensualidad_pago = $this->bonificaciones_granted->bonificacion_usuario( array(
                    'id_user'           => $usuario->id,
                    'id_bonificacion'   => $id_puntos_automaticos->row(0)->id,
            ));
            
            //si tiene activada la bonificacion de puntos_automaticos
            if( $mensualidad_logro || $mensualidad_pago ){
                $bono_logro_x2 = $this->achievement_bonificaciones->bonificacion_usuario( array(
                    'id_user'           => $usuario->id,
                    'id_bonificacion'   => $id_x2->row(0)->id,
                ));
                $bono_pago_x2 = $this->bonificaciones_granted->bonificacion_usuario( array(
                    'id_user'           => $usuario->id,
                    'id_bonificacion'   => $id_x2->row(0)->id,
                ));

                //si tiene bonificaciones de pago y ganadas por logros
                if( $bono_logro_x2 && $bono_pago_x2 ){
                    $bono_logro_x2 = $bono_logro_x2->row(0);
                    $bono_pago_x2 = $bono_pago_x2->row(0);

                    if( $bono_logro_x2->estado > $bono_pago_x2->estado ){
                        $this->users->update( array('unused_points' => intval($bono_logro_x2->estado) + $usuario->unused_points ), $usuario->id );
                    }else{
                        $this->users->update( array('unused_points' => intval($bono_pago_x2->estado) + $usuario->unused_points ), $usuario->id );
                    }

                //si solo posee un tipo de bonificacion
                }else{

                    if( $bono_logro_x2 ){
                        $bono_logro_x2 = $bono_logro_x2->row(0);
                        $this->users->update( array('unused_points' => intval($bono_logro_x2->estado) + $usuario->unused_points ), $usuario->id );
                    }

                    if( $bono_pago_x2 ){
                        $bono_pago_x2 = $bono_pago_x2->row(0);
                        $this->users->update( array('unused_points' => intval($bono_pago_x2->estado) + $usuario->unused_points ), $usuario->id );
                    }
                    
                    if( ! $bono_pago_x2 && ! $bono_pago_x2 )
                        $this->users->update( array('unused_points' => 1 + $usuario->unused_points ), $usuario->id );
                }
            }
        }
        
        $this->load->view('footer');
    
    }

}