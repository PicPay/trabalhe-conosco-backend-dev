<?php

namespace App\User\Model;

use App\Resource\Model\TimestampableInterface;
use App\Resource\Model\ToggleableInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

interface UserInterface extends AdvancedUserInterface, ToggleableInterface, TimestampableInterface
{
    const DEFAULT_ROLE = 'ROLE_USER';
    
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username);

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername();

    /**
     * @param string $usernameCanonical
     * @return User
     */
    public function setUsernameCanonical($usernameCanonical);

    /**
     * Gets normalized username (should be used in search and sort queries).
     *
     * @return string
     */
    public function getUsernameCanonical();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getEmailCanonical();

    /**
     * @param string $emailCanonical
     * @return User
     */
    public function setEmailCanonical($emailCanonical);

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt();

    /**
     * @param string $salt
     * @return User
     */
    public function setSalt($salt);

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword();

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getPlainPassword();

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword($plainPassword);

    /**
     * @return \DateTime
     */
    public function getLastLoginAt();

    /**
     * @param \DateTime $lastLoginAt
     * @return User
     */
    public function setLastLoginAt(\DateTime $lastLoginAt = null);

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles();

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles);

    /**
     * Adds a role to the user.
     *
     * @param string $role
     * @return User
     */
    public function addRole($role);

    /**
     * @return bool
     */
    public function getIsLocked();

    /**
     * @param bool $isLocked
     * @return User
     */
    public function setIsLocked($isLocked);

    /**
     * @return bool
     */
    public function getIsExpired();

    /**
     * @param bool $isExpired
     * @return User
     */
    public function setIsExpired($isExpired);

    /**
     * @return \DateTime
     */
    public function getExpiresAt();

    /**
     * @param \DateTime $expiresAt
     * @return User
     */
    public function setExpiresAt(\DateTime $expiresAt = null);

    /**
     * @return \DateTime
     */
    public function getPasswordRequestedAt();

    /**
     * @param \DateTime $passwordRequestedAt
     * @return User
     */
    public function setPasswordRequestedAt(\DateTime $passwordRequestedAt = null);

    /**
     * @return bool
     */
    public function getIsCredentialsExpired();

    /**
     * @param bool $isCredentialsExpired
     * @return User
     */
    public function setIsCredentialsExpired($isCredentialsExpired);

    /**
     * @return string
     */
    public function getConfirmationToken();

    /**
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken);

    /**
     * @return \DateTime
     */
    public function getCredentialsExpireAt();

    /**
     * @param \DateTime $credentialsExpireAt
     * @return User
     */
    public function setCredentialsExpireAt(\DateTime $credentialsExpireAt = null);

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired();

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked();

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired();

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled();

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials();

    /**
     * @param $ttl
     * @return bool
     */
    public function isPasswordRequestNonExpired($ttl);

    /**
     * Get the truncated email
     *
     * The default implementation only keeps the part following @ in the address.
     *
     * @return string
     */
    public function getObfuscatedEmail();
}