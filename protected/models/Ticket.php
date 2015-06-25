<?php

/**
 * This is the model class for table "ticket".
 *
 * The followings are the available columns in table 'ticket':
 * @property integer $ticket_id
 * @property string $candidate_key
 * @property string $ticket_title
 * @property integer $order_id
 * @property string $description
 * @property integer $department_id
 * @property string $ticket_resolve_date
 * @property integer $ticket_status
 * @property string $closed_at
 * @property integer $closed_by
 * @property string $close_reason
 * @property string $created_date
 * @property string $updated_date
 * @property string $read
 * @property string $read_by
 */
class Ticket extends CActiveRecord {

    public $clientname;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ticket';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('candidate_key , ticket_title, order_id', 'required'),
            array('order_id, department_id, ticket_status, closed_by', 'numerical', 'integerOnly' => true),
            array('candidate_key, ticket_title, close_reason', 'length', 'max' => 255),
            array('description, ticket_resolve_date, closed_at, created_date, updated_date', 'safe'),
            array('created_date,updated_date', 'default',
                'value' => date("Y-m-d H:i:s"),
                'on' => 'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ticket_id, candidate_key, ticket_title, order_id, description, department_id, ticket_resolve_date, ticket_status, closed_at, closed_by, close_reason , created_date, updated_date ,read,read_by', 'safe', 'on' => 'search'),
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
            'ticket_id' => 'Ticket ID',
            'candidate_key' => 'Candidate Key',
            'ticket_title' => 'Ticket Title',
            'order_id' => 'Order ID',
            'description' => 'Description',
            'department_id' => 'Department',
            'ticket_resolve_date' => 'Ticket Resolve Date',
            'ticket_status' => 'Ticket Status',
            'closed_at' => 'Closed At',
            'closed_by' => 'Closed By',
            'close_reason' => 'Close Reason',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'read_by' => "Read By",
            'read' => "Read",
            'clientname' => 'Client Name'
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

        $client_name = isset($_GET['Ticket']['clientname']) ? $_GET['Ticket']['clientname'] : '';


        $criteria->compare('ticket_id', trim($this->ticket_id), true);
        $criteria->compare('candidate_key', trim($this->candidate_key), true);
        $criteria->compare('ticket_title', trim($this->ticket_title), true);

        if (!empty($client_name)) {
            $clients = Users::model()->getAllClients($client_name);
            //print_r($clients);
             $clientsList =  implode(",", $clients);
             $ordlists = Orders::model()->findAllByAttributes(array(), 'client_id in ('.$clientsList.')');
             $ordlist=array();
             foreach ($ordlists as $single)  {
                 $ordlist[]=$single->order_id;
             } 
               $criteria->AddInCondition('order_id', $ordlist);
             
        } else {
            $criteria->compare('order_id', trim($this->order_id));
        }

        $criteria->compare('description', trim($this->description), true);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('ticket_resolve_date', $this->ticket_resolve_date, true);
        $criteria->compare('ticket_status', $this->ticket_status);
        $criteria->compare('closed_at', $this->closed_at, true);
        $criteria->compare('closed_by', $this->closed_by);
        $criteria->compare('read_by', $this->read_by, true);
        $criteria->compare('read', $this->read, true);
        $criteria->compare('close_reason', $this->close_reason, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        if (!in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {

            $ticketList = TicketAssign::model()->getTicketbyUser(Yii::app()->session['user_data']['user_id']);

            $ticket_ids = array();
            foreach ($ticketList as $ticket) {
                $ticket_ids[] = $ticket['ticket_id'];
            }
            if (!empty($ticket_ids)) {

                $criteria->AddInCondition('ticket_id', $ticket_ids);
            } else {
                if (!isset($_GET['clientsTicket'])) {
                    $criteria->addCondition('ticket_id==0');
                }
            }
//             if (!isset($_GET['clientsTicket'])) {
//               $criteria->AddCondition('ticket_status !=1');
//             }
        } else {

            if (isset($_GET['user_id'])) {
                $ticketList = TicketAssign::model()->getTicketbyUser(Yii::app()->session['user_data']['user_id']);
                $ticket_ids = array();
                foreach ($ticketList as $ticket) {
                    $ticket_ids[] = $ticket['ticket_id'];
                }
                if (!empty($ticket_ids)) {
                    $criteria->AddInCondition('ticket_id', $ticket_ids);
                } else {

                    $criteria->Addcondition('ticket_id==0');
                }
            }
        }
        if (isset($_GET['ts'])) {
            if (isset($_GET['Ticket']['ticket_status'])) {
                $_GET['ts'] = $_GET['Ticket']['ticket_status'];
            }
            $ts = $_GET['ts'];

            if ($ts) {
                $criteria->AddCondition('ticket_status ==' . $ts);
            }
        }
        if (isset($_GET['client'])) {
            $client_id = base64_decode($_GET['client']);
            $order_ids = Ticket::Orderlistbyclients($client_id);
            if (!empty($order_ids)) {
                $criteria->AddInCondition('order_id', $order_ids);
            } else {
                $criteria->Addcondition('order_id==0');
            }
        }
        if (isset($_GET['clientsTicket'])) {
            $client_id = base64_decode($_GET['clientsTicket']);
            $order_ids = Ticket::Orderlistbyclients($client_id);
            if (!empty($order_ids)) {
                $criteria->AddInCondition('order_id', $order_ids);
            } else {
                $criteria->Addcondition('order_id==0');
            }
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'ticket_id DESC'
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Ticket the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function checkStatus($id) {
        $data = Ticket::model()->count('ticket_status=' . $id);
        return $data;
    }

    public static function getTicketread($val) {
        if ($val) {
            return "Read";
        } else {
            return "Unread";
        }
    }

    public static function Orderlistbyclients($client_id) {

        $orderList = Orders::model()->findAllByAttributes(array("client_id" => $client_id));
        $order_ids = array();
        foreach ($orderList as $order) {
            $order_ids[] = $order['order_id'];
        }
        return $order_ids;
    }

    public static function GETticketListbyorder($order_ids) {

        $ticketList = ticket::model()->findAllByAttributes(array("order_id" => $order_ids));
        return $ticketList;
    }

}
