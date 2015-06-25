<?php

/**
 * This is the model class for table "ticket_status".
 *
 * The followings are the available columns in table 'ticket_status':
 * @property integer $status_id
 * @property string $status_name
 * @property string $color
 * @property string $created_date
 * @property string $updated_date
 */
class TicketStatus extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ticket_status';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('status_name, color', 'required'),
            array('status_name', 'length', 'max' => 250),
            array('color', 'length'),
            array('created_date, updated_date', 'safe'),
            array('created_date, updated_date', 'default',
                'value' => date("Y-m-d H:i:s"),
                'on' => 'insert'),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('status_id, status_name, color, created_date, updated_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'status_id' => 'Status',
            'status_name' => 'Status Name',
            'color' => 'Color',
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

        $criteria->compare('status_id', trim($this->status_id), true);
        $criteria->compare('status_name', trim($this->status_name), true);
        $criteria->compare('color', trim($this->color), true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'status_id ASC'
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TicketStatus the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getTicketStatus($id = null) {

        if (!empty($id)) {
            $model = TicketStatus::model()->findByPk($id);
            return '<label style="background: ' . $model->color . ';border-color: ' . $model->color . ';" class="forall">' . $model->status_name . '</label>';
        } else {
            $model = TicketStatus::model()->findAll();
            $list = array();
            foreach ($model as $m) {
                $list[$m->status_id] = $m->status_name;
            }
            return $list;
        }
    }

    public static function getTicketColor($id = null) {

        if (!empty($id)) {
            $model = TicketStatus::model()->findByPk($id);
            return '<label style="background: ' . $model->color . ';border-color: ' . $model->color . ';" class="forall">' . $model->color . '</label>';
        }
    }

    public static function getTicketColorName($id = null) {

        if (!empty($id)) {
            $model = TicketStatus::model()->findByPk($id);
            return $model->color;
        }
    }

    public static function getStatusName($ID) {
        if ($ID) {
            $result = TicketStatus::model()->findByPk($ID)->status_name;
        }

        return $result;
    }

    public function getStatusbyfilter() {

        if (in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1))) {
            $result = TicketStatus::model()->findAll("status_id !=6");
        } else {
            if (in_array(Yii::app()->session['user_data']['user_role_type'], array(2, 3))) {
                $result = TicketStatus::model()->findAllByAttributes(array(), array(
                    'condition' => 'status_id >:s_id and status_id !=6',
                    'params' => array('s_id' => 1),
                ));
            } else {
                $result = TicketStatus::model()->findAllByAttributes(array(), array(
                    'condition' => 'status_id >:s_id and status_id !=6',
                    'params' => array('s_id' => 2),
                ));
            }
        }
        return $result;
    }

}
