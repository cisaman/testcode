<?php

/**
 * This is the model class for table "user_roles".
 *
 * The followings are the available columns in table 'user_roles':
 * @property integer $user_role_type
 * @property string $user_role_name
 * @property string $created_date
 * @property string $updated_date
 * @property integer $status
 */
class UserRoles extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'userRoles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_role_name', 'required'),
            array('user_role_name', 'unique'),
            array('status', 'numerical', 'integerOnly' => true),
            array('user_role_name', 'length', 'max' => 50),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_role_type, user_role_name, created_date, updated_date, status', 'safe', 'on' => 'search'),
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
            'user_role_type' => 'ID',
            'user_role_name' => 'Role Name',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status' => 'Status',
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

        $criteria->compare('user_role_type', $this->user_role_type);
        $criteria->compare('user_role_name', trim($this->user_role_name), true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'user_role_type ASC'
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserRoles the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getRoleName($roleID) {
        if ($roleID) {
            $result = UserRoles::model()->findByPk($roleID)->user_role_name;
        } else {
            $result = "Super Admin";
        }
        return $result;
    }
    
    public static function getUserTypeList() {

        $gettype = ModulePermission::getUserRoleType();
        $result = UserRoles::model()->findAll(array(
            'select' => '*', 'condition' => 'user_role_type NOT IN(' . $gettype . ')'
        ));
        $list = array();
        foreach ($result as $row) {
            $list[$row['user_role_type']] = $row['user_role_name'];
        }
        return $list;
    }

    public static function getUserType() {

        $gettype = ModulePermission::getUserRoleType();
        $result = UserRoles::model()->findAll(array(
            'select' => '*', 'condition' => 'user_role_type  IN(' . $gettype . ')'
        ));

        $list = array();
        foreach ($result as $row) {
            if (Yii::app()->session['user_data']['user_role_type'] < $row['user_role_type']) {
                $list[$row['user_role_type']] = $row['user_role_name'];
            }
        }

        return $list;
    }

}
