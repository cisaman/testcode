<?php

/**
 * This is the model class for table "system_modules".
 *
 * The followings are the available columns in table 'system_modules':
 * @property integer $module_id
 * @property string $module_name
 * @property string $module_key
 * @property string $created_date
 * @property string $updated_date
 */
class SystemModules extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'systemModules';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('module_name, module_key', 'required'),
            array('module_name, module_key', 'unique'),
            array('module_name, module_key', 'length', 'max' => 255),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('module_id, module_name, module_key, created_date, updated_date', 'safe', 'on' => 'search'),
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
            'module_id' => 'ID',
            'module_name' => 'Name',
            'module_key' => 'Key',
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

        $criteria->compare('module_id', $this->module_id);
        $criteria->compare('module_name', trim($this->module_name), true);
        $criteria->compare('module_key', $this->module_key, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'module_id ASC'
            ),
            'Pagination' => array(
                'PageSize' => 20
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SystemModules the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public static function getModuleIdBykey($key) {
        $result = SystemModules::model()->findByAttributes(array('module_key' => ucfirst($key)))->module_id;
        return $result;
    }

}
