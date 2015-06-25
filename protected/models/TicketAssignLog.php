<?php

/**
 * This is the model class for table "ticketAssignLog".
 *
 * The followings are the available columns in table 'ticketAssignLog':
 * @property integer $id
 * @property integer $ticket_id
 * @property integer $fwd_by
 * @property integer $fwd_to
 * @property integer $status
 * @property string $created_date
 * @property string $updated_date
 */
class TicketAssignLog extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ticketAssignLog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ticket_id, fwd_by, fwd_to', 'required'),
            array('ticket_id, fwd_by, fwd_to, status', 'numerical', 'integerOnly' => true),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, ticket_id, fwd_by, fwd_to, status, created_date, updated_date', 'safe', 'on' => 'search'),
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
     * @return TicketAssignLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
