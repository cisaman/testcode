<?php

/**
 * This is the model class for table "coupons".
 *
 * The followings are the available columns in table 'coupons':
 * @property integer $id
 * @property string $coupon_code
 * @property integer $discount
 * @property integer $no_of_used
 * @property string $validate_to
 * @property string $validate_from
 * @property integer $min_amt
 * @property string $desc
 * @property integer $coupon_type
 * @property string $valid_for
 * @property integer $apply_on
 * @property integer $count
 * @property string $created_date
 * @property string $updated_date
 * @property integer $status
 */
class Coupons extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'coupons';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('coupon_code,min_amt,no_of_used, discount,validate_to ,validate_from ,coupon_type,desc', 'required'),
            array('coupon_code', 'unique'),
            array('no_of_used, min_amt, coupon_type, apply_on, count, status', 'numerical', 'integerOnly' => true),
            array('coupon_code', 'length', 'min' => 6),
            array('discount', 'length', 'max' => 8),
            array('min_amt', 'length', 'max' => 8),
            array('desc', 'length', 'max' => 256),
            array('validate_to, validate_from, valid_for, created_date, updated_date', 'safe'),
            array('created_date,updated_date', 'default',
                'value' => date("Y-m-d H:i:s"),
                'on' => 'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, coupon_code, discount, no_of_used, validate_to, validate_from, min_amt, desc, coupon_type, valid_for, apply_on, count, created_date, updated_date, status', 'safe', 'on' => 'search'),
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
            'coupon_code' => 'Coupon Code',
            'discount' => 'Discount(%) / Amount',
            'no_of_used' => 'Coupon Limit',
            'validate_to' => 'Validate To',
            'validate_from' => 'Validate From',
            'min_amt' => 'Minimum Amount',
            'desc' => 'Description',
            'coupon_type' => 'Coupon Type',
            'valid_for' => 'Valid For',
            'apply_on' => 'Apply On',
            'count' => 'Count',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('coupon_code', trim($this->coupon_code), true);
        $criteria->compare('discount', trim($this->discount), true);
        $criteria->compare('no_of_used', $this->no_of_used);
        $criteria->compare('validate_to', $this->validate_to, true);
        $criteria->compare('validate_from', $this->validate_from, true);
        $criteria->compare('min_amt', $this->min_amt);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('coupon_type', $this->coupon_type);
        $criteria->compare('valid_for', $this->valid_for, true);
        $criteria->compare('apply_on', $this->apply_on);
        $criteria->compare('count', $this->count);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id asc'
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Coupons the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
