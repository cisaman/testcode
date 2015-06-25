<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $department_id
 * @property string $department_name
 * @property string $department_desc
 * @property integer $department_created_by
 * @property integer $department_updated_by
 * @property integer $department_status
 * @property string $created_date
 * @property string $updated_date
 */
class Department extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'department';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('department_name, department_desc, department_created_by', 'required'),
            array('department_created_by, department_updated_by, department_status', 'numerical', 'integerOnly' => true),
            array('department_name, department_desc', 'length', 'max' => 255),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('department_id, department_name, department_desc, department_created_by, department_updated_by, department_status, created_date, updated_date', 'safe', 'on' => 'search'),
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
            'department_id' => 'Department',
            'department_name' => 'Department Name',
            'department_desc' => 'Department Description',
            'department_created_by' => 'Department Created By',
            'department_updated_by' => 'Department Updated By',
            'department_status' => 'Department Status',
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

        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('department_name', trim($this->department_name), true);
        $criteria->compare('department_desc', trim($this->department_desc), true);
        $criteria->compare('department_created_by', $this->department_created_by);
        $criteria->compare('department_updated_by', $this->department_updated_by);
        $criteria->compare('department_status', $this->department_status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'department_id asc'
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Department the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getDepartmentName($ID) {
        if ($ID == 0) {
            $result = 'Adminstrator';
        } else {
            $result = Department::model()->findByPk($ID)->department_name;
        }
        return $result;
    }

    public static function getDepartmentList() {
        if (in_array(Yii::app()->session['user_data']['user_role_type'], array(2))) {
            $result = Department::model()->findAll('department_id !=1');
        } else {
            $result = Department::model()->findAll();
        }
        $list = array();
        foreach ($result as $row) {
            $list[$row->department_id] = $row->department_name;
        }
        return $list;
    }

    public static function getDepartmentFilter() {

        $result = Department::model()->findAll("department_id not in (1)");
        $list = array();
        foreach ($result as $row) {
            $list[$row->department_id] = $row->department_name;
        }
        return $list;
    }

}
