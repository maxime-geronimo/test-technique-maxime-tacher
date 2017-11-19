<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Parametres Controller
 *
 * @property \App\Model\Table\ParametresTable $Parametres
 */
class ParametresController extends AppController
{


    public function index(){

        $parametres = $this->Parametres->find('all');

        $this->set([
            'parametres'=>$parametres,
            '_serialize'=>['parametres']
        ]);

    }

    public function edit()
    {
        $success = ['success'=>false, 'msg'=>'Erreur lors de la mise à jour du paramètre'];
        if ($this->request->is(['put'])) {
            $datas = $this->request->data;
            $ref_id = (isset($datas['ref_id']) ? intval($datas['ref_id']) : 0);
            if(isset($datas['param_name'])){
                $param_name = $datas['param_name'];
                if($this->Parametres->query()->update()
                    ->set(['ref_id' => $ref_id ])
                    ->where(['param_name' => $param_name])
                    ->execute()){
                    $success = ['success'=>true, 'msg'=>'Paramètre correctement mis à jour'];
                }
            }else{
                $success = ['success'=>false, 'msg'=>'"param_name" manquant'];
            }
        }
        $this->autoRender = false;
        $this->response->body(json_encode($success));
    }
}
