<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Medias Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Reves
 *
 * @method \App\Model\Entity\Media get($primaryKey, $options = [])
 * @method \App\Model\Entity\Media newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Media[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Media|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Media patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Media[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Media findOrCreate($search, callable $callback = null, $options = [])
 */
class MediasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('medias');
        $this->displayField('id');
        $this->primaryKey('id');

        /*$this->belongsTo('Reves', [
            'foreignKey' => 'ref_id'
        ]);*/
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

       /* $validator
            ->allowEmpty('ref');

        $validator
            ->allowEmpty('name');

        $validator
            ->integer('size')
            ->requirePresence('size', 'create')
            ->notEmpty('size');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('url');

        $validator
            ->integer('position')
            ->requirePresence('position', 'create')
            ->notEmpty('position');*/

        return $validator;
    }

    //Sauvegarde d'UN Media
    public function saveMedia($file,$ref= '',$ref_id=null, $position = 0){
        $success = ['success'=> true, 'msg'=>''];
        $media = "";
        if(!is_array($file)){
            $file = json_decode($file, true);
        }

        if(isset($file['id'])){
            $media = $this->get($file['id']);
        }

        if(empty($media)){
            $media = $this->newEntity();
        }

        $datas = [
            'ref'=>$ref,
            'ref_id'=>$ref_id,
            'name'=>$file['name'],
            'size'=>$file['size'],
            'type'=>$file['type'],
            'url'=>$file['url'],
            'created'=>date('Y-m-d H:i:s'),
            'position'=>$position
        ];

        $patchMedia = $this->patchEntity($media,$datas);
        $save_media = $this->save($patchMedia);
        if($save_media){
            $success['media'] = $save_media;
        }else{
            $success = ['success'=>false, 'msg'=> 'Le fichier "'.$datas['name'].'" n\'a pas pu être sauvegardé. '];
        }
        return $success;
    }

    //Supprime UN Media
    public function removeMedia($file){
        $file = json_decode($file, true);
        $file['url'] =  urldecode ($file['url']);
        if(DS =="\\"){
            $full_path = substr(WWW_ROOT, 0, -1).str_replace('/', '\\',$file['url']);
        }else{
            $full_path = substr(WWW_ROOT, 0, -1).$file['url'];
        }

        try {
            //On supprime le fichier du serveur
            if(!unlink($full_path)){
                /* die();*/
            }
        } catch (\Exception $e) {

        }


    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
       /* $rules->add($rules->existsIn(['ref_id'], 'Reves'));*/

        return $rules;
    }
}
