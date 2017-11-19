<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

/**
 * Medias Controller
 *
 * @property \App\Model\Table\MediasTable $Medias
 */
class MediasController extends AppController
{

    public function index(){
        $medias = $this->Medias->find('all');
        $this->set([
            'medias'=>$medias,
            '_serialize'=>['medias']
        ]);
    }


    //Upload d'un fichier
    public function upload()
    {

        $success = ['success'=>false, 'msg'=>'Une érreur s\'est produite lors du chargement du fichier.'];
        if ($this->request->is(['post'])) {
            $a = date('Y');//Année
            $m = date('n');//Mois
            $j = date('j');//Jour

            $uniqid = uniqid('f_');
            $upload_dir_url = '/files/uploads/medias/' . $a . '/' . $m . '/' . $j . '/';
            $extension = pathinfo($_FILES['files']['name'][0], PATHINFO_EXTENSION);
            $upload_file_url = $upload_dir_url . $uniqid . '.' . $extension;
            $file = (isset($this->request->data['files'][0]) && !empty($this->request->data['files'][0]) ? $this->request->data['files'][0] : false);
            $_FILES['files']['name'][0] = $uniqid . '.' . $extension;//On change le nom pour la sauvegarde physique


            $options = array(
                'max_file_size' => 5120000,
                'max_number_of_files' => 100,
                'access_control_allow_methods' => array(
                    'POST'
                ),
                'image_versions' => array(),//No thumbnails
                'access_control_allow_origin' => Router::fullBaseUrl(),
                'accept_file_types' => '/\.(gif|jpe?g|png)$/i',// Accept GIF, JPEG, PNG
                'upload_dir' => WWW_ROOT . 'files' . DS . 'uploads' . DS . 'medias' . DS . $a . DS . $m . DS . $j . DS,
                'upload_url' => $upload_dir_url,
                'print_response' => false
            );

            $upload = $this->JqueryFileUpload->upload($options);

            //Sauvegarde BDD si il n'y a pas d'erreurs à l'upload
            if ($file && !isset($upload['files'][0]->error)) {
                //On change l'url pour la sauvegarde en BDD
                $file['url'] = $upload_file_url;
                $success = $this->Medias->saveMedia($file, 'PicManager');
            } else {
                $success['msg'] = $upload['files'][0]->error;
            }

            $response = ['upload' => $upload, 'success' => $success];
        }else{
            $response = $success;
        }

        $this->autoRender = false;
        $this->response->body(json_encode($response));

    }

    public function edit($id = null){
        $success = ['success'=>false, 'msg'=>'Erreur lors de la mise à jour de l\'image.'];
        if ($this->request->is(['put']) && $id != null) {
            $datas = $this->request->data;
            $name = (isset($datas['name']) ? $datas['name'] : "");
            $description = (isset($datas['description']) ? $datas['description'] : "");
            $media = $this->Medias->find()->where(['id'=>$id])->first();
            if(!empty($media)){
                if($this->Medias->query()->update()
                    ->set([
                        'name' => $name,
                        'description'=>$description,
                        'updated'=> date('Y-m-d H:m:s')
                    ])
                    ->where(['id' => $id])
                    ->execute()){
                    $success = ['success'=>true, 'msg'=>'Image correctement mise à jour.'];
                }
            }else{
                $success['msg'] = 'Erreur : L\'image n\'existe plus. Veuillez recharger la page.';
            }
        }
        $this->autoRender = false;
        $this->response->body(json_encode($success));
    }

    public function delete($id = null){
        $success = ['success'=>false, 'msg'=>'Erreur lors de la suppression de l\'image.'];
        if ($this->request->is(['delete']) && $id != null) {
            $media = $this->Medias->find()->where(['id'=>$id])->first();
            if(!empty($media)){
                if ($this->Medias->delete($media)) {
                    //On supprime physiquement le fichier du serveur :
                    $this->Medias->removeMedia($media);

                    $success = ['success'=>true, 'msg'=>'Image correctement supprimée.'];
                }
            }else{
                $success['msg'] = 'Erreur : L\'image n\'existe plus. Veuillez recharger la page.';
            }

        }

        $this->autoRender = false;
        $this->response->body(json_encode($success));
    }
}
