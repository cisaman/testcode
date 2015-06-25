<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $client_id
 * @property string $order_total
 * @property string $order_Date
 * @property string $data
 * @property integer $coupon_id
 * @property string $currency
 * @property string $host
 * @property string $status
 * @property string $order_payment
 */
class Orders extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('client_id, order_total', 'required'),
            array('product_id, client_id, coupon_id', 'numerical', 'integerOnly' => true),
            array('order_total', 'length', 'max' => 16),
            array('currency', 'length', 'max' => 3),
            array('host', 'length', 'max' => 255),
            array('order_date, data', 'safe'),
            array('order_date', 'default',
                'value' => date("Y-m-d H:i:s"),
                'on' => 'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('order_id, product_id, client_id, order_total, order_date, order_Data, coupon_id, currency,host,status,order_payment', 'safe', 'on' => 'search'),
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
            'order_id' => 'Order',
            'product_id' => 'Product',
            'client_id' => 'Client',
            'order_total' => 'Order Total',
            'order_date' => 'Order Date',
            'order_Data' => 'Data',
            'coupon_id' => 'Coupon',
            'currency' => 'Currency',
            'host' => 'Host',
            'status' => 'Status',
            'order_payment' => 'Order Payment',
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

        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('client_id', $this->client_id);
        $criteria->compare('order_total', $this->order_total, true);
        $criteria->compare('order_date', $this->order_date, true);
        $criteria->compare('order_Data', $this->data, true);
        $criteria->compare('coupon_id', $this->coupon_id);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('host', $this->host, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('order_payment', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Orders the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCountOrderbyClient($id) {
        $data = Orders::model()->count('client_id=' . $id);
        return $data;
    }

    public function getClientName($order_id) {
        $user_id = Orders::model()->getClientId($order_id);
        $data = Users::model()->getUserName($user_id);
        return $data;
    }

    public function getClientId($order_id) {
        $result = Orders::model()->findByPk($order_id)->client_id;
        return $result;
    }

}
