<?php

/**
 * This is the model class for table "GitHubAccount".
 *
 * The followings are the available columns in table 'GitHubAccount':
 * @property string $GitHubUsername
 * @property string $GitHubPassword
 * @property integer $GitHubOwnerID
 *
 * The followings are the available model relations:
 * @property User $gitHubOwner
 */
class GitHubAccount extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GitHubAccount the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'GitHubAccount';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('GitHubUsername, GitHubPassword', 'required'),
            array('GitHubOwnerID', 'numerical', 'integerOnly' => true),
            array('GitHubUsername, GitHubPassword', 'length', 'max' => 256),
            array('GitHubUsername', 'validUsername'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('GitHubUsername, GitHubPassword, GitHubOwnerID', 'safe', 'on' => 'search'),
        );
    }

    public function validUsername($attribute) {
        $client = new GitHubClient($this);
        if (!$client->checkUserCredentials()) {
            $this->addErrors(array(
                'GitHubUsername' => 'Username or password invalid',
                'GitHubPassword' => 'Username or password invalid'
            ));
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'gitHubOwner' => array(self::BELONGS_TO, 'User', 'GitHubOwnerID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'GitHubUsername' => 'GitHub Username',
            'GitHubPassword' => 'GitHub Password',
            'GitHubOwnerID' => 'GitHub Owner ID',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('GitHubUsername', $this->GitHubUsername, true);
        $criteria->compare('GitHubPassword', $this->GitHubPassword, true);
        $criteria->compare('GitHubOwnerID', $this->GitHubOwnerID);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        $this->GitHubPassword = self::encryptPassword($this->GitHubPassword);
        return true;
    }

    public static function encryptPassword($password) {
        $iv = md5(md5(Yii::app()->params['salt']));
        $password = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Yii::app()->params['salt']), $password, MCRYPT_MODE_CBC, $iv);
        return base64_encode($password);
    }

    public static function decryptPassword($password) {
        $iv = md5(md5(Yii::app()->params['salt']));
        $password = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Yii::app()->params['salt']), base64_decode($password), MCRYPT_MODE_CBC, $iv));
        return $password;
    }

}
