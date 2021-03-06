<?php

namespace mgirouard\CloudFlare\Entities;

use DateTime;
use DateTimeZone;

/**
 * The currently logged in/authenticated User
 *
 * <pre>{
 *     "id": "7c5dae5552338874e5053f2534d2767a",
 *     "email": "user@example.com",
 *     "first_name": "John",
 *     "last_name": "Appleseed",
 *     "username": "cfuser12345",
 *     "telephone": "+1 123-123-1234",
 *     "country": "US",
 *     "zipcode": "12345",
 *     "created_on": "2014-01-01T05:20:00Z",
 *     "modified_on": "2014-01-01T05:20:00Z",
 *     "two_factor_authentication_enabled": false
 * }</pre>
 *
 * @see <https://api.cloudflare.com/#user-properties> Official API Docs
 * @see mgirouard\CloudFlare\Entities\Test\UserTest Unit Tests
 */
class User implements EntityInterface
{
    /** 2014-01-01T05:20:00Z */
    const DATE_FORMAT = 'Y-m-d\TH:i:s\Z';

    private $id;
    private $email;
    private $firstName;
    private $lastName;
    private $username;
    private $telephone;
    private $country;
    private $zipcode;
    private $createdOn;
    private $modifiedOn;
    private $twoFactorAuthenticationEnabled;

    public function __construct()
    {
        $this->setCreatedOn(new DateTime('now', new DateTimeZone('UTC')));
        $this->setModifiedOn(new DateTime('now', new DateTimeZone('UTC')));
    }

    /**
     * Get User identifier tag
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set User identifier tag
     *
     * @param string $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get Your contact email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Your contact email address
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get User's first name
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstName;
    }

    /**
     * Set User's first name
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get User's last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set User's last name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Get A username used to access other cloudflare services, like support
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set A username used to access other cloudflare services, like support
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get User's telephone number
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set User's telephone number
     *
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * Get the country in which the user lives.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the country in which the user lives.
     *
     * @param string $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get the zipcode or postal code where the user lives
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set the zipcode or postal code where the user lives
     *
     * @param string $zipcode
     * @return User
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * Get when the user signed up
     *
     * @return DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set when the user signed up
     *
     * @param DateTime $createdOn
     * @return User
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * Get last time the user was modified
     *
     * @return DateTime
     */
    public function getModifiedOn()
    {
        return $this->modifiedOn;
    }

    /**
     * Set last time the user was modified
     *
     * @param DateTime $modifiedOn
     * @return User
     */
    public function setModifiedOn($modifiedOn)
    {
        $this->modifiedOn = $modifiedOn;
        return $this;
    }

    /**
     * Get whether two-factor authentication is enabled for the user account
     *
     * @return bool
     */
    public function getTwoFactorAuthenticationEnabled()
    {
        return $this->twoFactorAuthenticationEnabled;
    }

    /**
     * Set whether two-factor authentication is enabled for the user account
     *
     * @param bool 
     * @return User
     */
    public function setTwoFactorAuthenticationEnabled($twoFactorAuthenticationEnabled)
    {
        $this->twoFactorAuthenticationEnabled = $twoFactorAuthenticationEnabled;
        return $this;
    }

    /** @inheritDoc */
    public function jsonSerialize()
    {
        $json = [];

        foreach (self::jsonMap() as $jsonField => $userField) {
            $json[$jsonField] = $this->{'get' . $userField}();
        }

        $json['created_on'] = $json['created_on']->format(self::DATE_FORMAT);
        $json['modified_on'] = $json['modified_on']->format(self::DATE_FORMAT);

        $json['two_factor_authentication_enabled'] =
            (bool) $json['two_factor_authentication_enabled'];

        return $json;
    }

    /** @inheritDoc */
    public static function jsonHydrate($json)
    {
        $user = new self;
        $data = json_decode($json, true);
        $map  = self::jsonMap();

        $data['created_on'] = new DateTime($data['created_on']);
        $data['modified_on'] = new DateTime($data['modified_on']);

        $data['two_factor_authentication_enabled'] =
            (bool) $data['two_factor_authentication_enabled'];

        foreach ($map as $jsonField => $userField) {
            $user->{'set' . $userField}($data[$jsonField]);
        }

        return $user;
    }

    /** @inheritDoc */
    public static function jsonMap()
    {
        return [
            'id'          => 'Id',
            'email'       => 'Email',
            'first_name'  => 'FirstName',
            'last_name'   => 'LastName',
            'username'    => 'Username',
            'telephone'   => 'Telephone',
            'country'     => 'Country',
            'zipcode'     => 'Zipcode',
            'created_on'  => 'CreatedOn',
            'modified_on' => 'ModifiedOn',

            'two_factor_authentication_enabled' => 'TwoFactorAuthenticationEnabled',
        ];
    }
}
