<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userprofile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fullname
 * @property string $contact_mobile
 * @property string $address_line1
 * @property string $address_line2
 * @property string $city_id
 * @property string $state_id
 * @property string $postcode
 * @property string $country_id
 * @property string $image
 * @property string $twofa_secret
 * @property string $twofa_enabled
 *
 * @property User $user
 */
class Userprofile extends \yii\db\ActiveRecord
{
    public $roles = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userprofile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fullname','city_id','state_id','country_id'], 'required'],
            [['user_id'], 'integer'],
            [['image'], 'file', 'extensions' => 'gif, jpg, jpeg, png'],
            ['image', 'required', 'on' => 'create', 'skipOnEmpty' => false],
            [['fullname', 'contact_mobile', 'address_line1','address_line2', 'postcode'], 'string', 'max' => 255],
            [['twofa_enabled','twofa_secret'], 'safe'],
        ];
    }

    public function beforeValidate() {
        parent::beforeValidate();
        $fields = [
            'fullname', 'contact_mobile', 'address_line1','address_line2', 'city_id', 'state_id', 'postcode', 'country_id'
        ];
        foreach ($fields as $field) {
            $this->{$field} = strip_tags(\yii\helpers\HtmlPurifier::process($this->{$field}));
        }
        return true;    
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'fullname' => 'Full Name',
            'contact_mobile' => 'Contact Mobile',
            'address_line1' => 'Address Line1',
            'address_line2' => 'Address Line2',
            'city_id' => 'City',
            'state_id' => 'State',
            'postcode' => 'Postcode',
            'country_id' => 'Country',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getCity()
    {
        return $this->hasOne(GeoCity::className(), ['id' => 'city_id']);
    }
    
    public function getState()
    {
        return $this->hasOne(GeoState::className(), ['id' => 'state_id']);
    }
    
    public function getCountry()
    {
        return $this->hasOne(GeoCountry::className(), ['id' => 'country_id']);
    }
}
