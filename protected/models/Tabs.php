<?php

/**
 * This is the model class for table "tbl_bottom_tabs".
 *
 * The followings are the available columns in table 'tbl_bottom_tabs':
 * @property integer $tab_id
 * @property string $tab_name
 * @property string $tab_title
 * @property string $tab_content
 * @property integer $tab_order
 */
class Tabs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tabs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_bottom_tabs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tab_name, tab_title, tab_content, tab_order', 'required'),
			array('tab_order', 'numerical', 'integerOnly'=>true),
			array('tab_name, tab_title', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tab_id, tab_name, tab_title, tab_content, tab_order', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tab_id' => 'Tab',
			'tab_name' => 'Tab Name',
			'tab_title' => 'Tab Title',
			'tab_content' => 'Tab Content',
			'tab_order' => 'Tab Order',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tab_id',$this->tab_id);
		$criteria->compare('tab_name',$this->tab_name,true);
		$criteria->compare('tab_title',$this->tab_title,true);
		$criteria->compare('tab_content',$this->tab_content,true);
		$criteria->compare('tab_order',$this->tab_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}