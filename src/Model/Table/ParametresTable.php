<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Parametres Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Reves
 *
 * @method \App\Model\Entity\Parametre get($primaryKey, $options = [])
 * @method \App\Model\Entity\Parametre newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Parametre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Parametre|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parametre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Parametre[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Parametre findOrCreate($search, callable $callback = null, $options = [])
 */
class ParametresTable extends Table
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

        $this->table('parametres');
        $this->displayField('id');
        $this->primaryKey('id');

      /*  $this->hasOne('Media', [
            'className' => 'Medias',
            'foreignKey' => 'ref_id',
            "conditions" => [
                "ref" => "Societes"
            ]
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

        $validator
            ->requirePresence('param_name', 'create')
            ->notEmpty('param_name');

        $validator
            ->allowEmpty('ref');

        return $validator;
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
