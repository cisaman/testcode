<?php

/**
 * This is the model class for table "ticketThread".
 *
 * The followings are the available columns in table 'ticketThread':
 * @property integer $thread_id
 * @property integer $ticket_id
 * @property integer $user_id
 * @property string $descriptions
 * @property string $attachments
 * @property integer $status
 * @property string $created_date
 * @property string $updated_date
 */
class TicketThread extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ticketThread';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ticket_id, user_id ,descriptions', 'required'),
            array('ticket_id, user_id, status', 'numerical', 'integerOnly' => true),
            array('attachments', 'length', 'max' => 255),
            array('descriptions, created_date, updated_date', 'safe'),
            array('created_date,updated_date', 'default',
                'value' => date("Y-m-d H:i:s"),
                'on' => 'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('thread_id, ticket_id, user_id, descriptions, attachments, status, created_date, updated_date', 'safe', 'on' => 'search'),
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
            'thread_id' => 'Thread',
            'ticket_id' => 'Ticket',
            'user_id' => 'User',
            'descriptions' => 'Descriptions',
            'attachments' => 'Attachments',
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

        $criteria->compare('thread_id', $this->thread_id);
        $criteria->compare('ticket_id', $this->ticket_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('descriptions', $this->descriptions, true);
        $criteria->compare('attachments', $this->attachments, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'thread_id ASC'
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TicketThread the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
