<?php

/**
 * This is the model class for table "ticketAssign".
 *
 * The followings are the available columns in table 'ticketAssign':
 * @property integer $id
 * @property integer $ticket_id
 * @property integer $fwd_by
 * @property integer $fwd_to 
 * @property integer $status
 * @property integer $user_role_type
 * @property string $created_date
 * @property string $updated_date
 */
class TicketAssign extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ticketAssign';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ticket_id, fwd_by, fwd_to ,user_role_type', 'required'),
            array('ticket_id, fwd_by, fwd_to,  status', 'numerical', 'integerOnly' => true),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, ticket_id, fwd_by, fwd_to,  status, user_role_type, created_date, updated_date', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'ticket_id' => 'Ticket',
            'fwd_by' => 'Fwd By',
            'fwd_to' => 'Fwd To',
            'user_role_type' => 'User Role Type',
            'status' => 'Status',
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
        $criteria->compare('fwd_by', $this->fwd_by);
        $criteria->compare('fwd_to', $this->fwd_to);
        $criteria->compare('user_role_type', $this->user_role_type);
        $criteria->compare('ticket_status', $this->ticket_status);
        $criteria->compare('status', $this->status);
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
     * @return TicketAssign the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getAssignee($id) {
        $result = TicketAssign::model()->findAllByAttributes(array('ticket_id' => $id));
        return $result;
    }

    public function getTicketbyUser($user_id) {
        if (isset($_GET['user_id'])) {
            $fwd_by = base64_decode($_GET['user_id']);
            $result = TicketAssign::model()->findAllByAttributes(array('fwd_to' => $fwd_by, 'status' => 1));
        } else {            
            $result = TicketAssign::model()->findAllByAttributes(array('fwd_to' => $user_id, 'status' => 1));
        }

        return $result;
    }

}
