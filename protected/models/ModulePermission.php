<?php

/**
 * This is the model class for table "module_permission".
 *
 * The followings are the available columns in table 'module_permission':
 * @property integer $module_permission_id
 * @property integer $module_id
 * @property integer $user_role_type
 * @property integer $created_id
 * @property integer $updated_id
 * @property string $created_date
 * @property string $updated_date
 */
class ModulePermission extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'modulePermission';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('module_id, user_role_type, created_id,', 'required'),
            array('module_id, user_role_type, created_id, updated_id', 'numerical', 'integerOnly' => true),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('module_permission_id, module_id, user_role_type, created_id, updated_id, created_date, updated_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'module_permission_id' => 'Module Permission',
            'module_id' => 'Module',
            'user_role_type' => 'User Role Type',
            'created_id' => 'Created',
            'updated_id' => 'Updated',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('module_permission_id', $this->module_permission_id);
        $criteria->compare('module_id', $this->module_id);
        $criteria->compare('user_role_type', $this->user_role_type);
        $criteria->compare('created_id', $this->created_id);
        $criteria->compare('updated_id', $this->updated_id);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'module_permission_id asc'
            ),
        ));
    }

    public function getAllpermission() {
        $arr = array();
        $criteria = new CDbCriteria;
        $criteria->compare('module_permission_id', $this->module_permission_id);
        $criteria->compare('module_id', $this->module_id);
        $criteria->compare('user_role_type', $this->user_role_type);
        $criteria->compare('created_id', $this->created_id);
        $criteria->compare('updated_id', $this->updated_id);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->group = 'user_role_type';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'module_permission_id asc'
            ),
        ));
    }

    public function getAllmodule($userType) {

        $data = ModulePermission::model()->findAllByAttributes(array('user_role_type' => $userType));
        $list = array();
        foreach ($data as $row) {
            $list[] = SystemModules::model()->findByPk($row['module_id'])->module_name;
            ;
        }
        $str = implode(" , ", $list);
        return $str;
    }

    public function getAllmoduleList($userType) {
        if ($userType) {
            $data = ModulePermission::model()->findAllByAttributes(array('user_role_type' => $userType));
        }else{
             $data = ModulePermission::model()->findAllByAttributes();
        }
        $list = array();
        foreach ($data as $row) {
            $list[] = $row['module_id'];
        }
        return $list;
    }

    public function getUserRoleType() {
        $criteria = new CDbCriteria();
        $criteria->group = 'user_role_type';
        $criteria->select = 'user_role_type';
        $data = ModulePermission::model()->findAll($criteria);
        $list = array();
        foreach ($data as $d) {
            $list[] = $d->user_role_type;
        }

        $list = implode(" , ", $list);
        return $list;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ModulePermission the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function checkPermission($roleType) {
        $data = ModulePermission::model()->count('user_role_type=' . $roleType);
        return $data;
    }

}
