<?php

/**
 * This is the model class for table "ticketChangeLog".
 *
 * The followings are the available columns in table 'ticketChangeLog':
 * @property integer $id
 * @property integer $ticket_id
 * @property integer $status_id
 * @property integer $user_id
 * @property string $remark
 * @property string $created_date
 * @property string $updated_date
 */
class TicketChangeLog extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ticketChangeLog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('ticket_id, status_id, user_id', 'required'),
            array('ticket_id, status_id, user_id', 'numerical', 'integerOnly' => true),
            array('remark, created_date, updated_date', 'safe'),
            array('created_date, updated_date', 'default',
                'value' => date("Y-m-d H:i:s"),
                'on' => 'insert'),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('id, ticket_id, status_id, user_id, remark, created_date, updated_date', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'ticket_id' => 'Ticket',
            'status_id' => 'Status',
            'user_id' => 'User',
            'remark' => 'Remark',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('ticket_id', $this->ticket_id);
        $criteria->compare('status_id', $this->status_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id ASC'
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TicketChangeLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function getRemarkList($ticket_id, $id = 0) {
//$connection = Yii::app()->db;
//$command = $connection->createCommand('SELECT * FROM  ticketChangeLog where ticket_id=' . $ticket_id . ' AND  id  > ' . $id);
//$results = $command->queryAll();
        $results = TicketChangeLog::model()->findAllByAttributes(array("ticket_id" => $ticket_id), array(
        'condition' => 'id > :id',
        'params' => array('id' => $id),
        'order' => 'id DESC'
        ));
        return $results;
    }

}
