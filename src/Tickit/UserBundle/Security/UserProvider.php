<?php

namespace Tickit\UserBundle\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Tickit\UserBundle\Entity\User;
use Tickit\UserBundle\Manager\UserManager;

/**
 * User provider implementation.
 *
 * Provides functionality for providing user information to Symfony's
 * security component
 *
 * @package Tickit\UserBundle\Security
 * @author  James Halsall <jhalsall@rippleffect.com>
 */
class UserProvider implements UserProviderInterface
{
    /**
     * The user manager
     *
     * @var UserManager
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param UserManager $manager The user manager
     */
    public function __construct(UserManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Loads the user for the given username.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException If the user is not found
     *
     */
    public function loadUserByUsername($username)
    {
        $user = $this->manager->findUserByUsernameOrEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

    /**
     * Refreshes the user for the account interface.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  If the account is not supported
     * @throws UsernameNotFoundException If the username does not exist
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Expected an instance of Tickit\UserBundle\Entity\User, but got "%s".', get_class($user))
            );
        }

        $reloadedUser = $this->manager->findUserBy(array('id' => $user->getId()));
        if (null === $reloadedUser) {
            throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $user->getId()));
        }

        return $reloadedUser;
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return boolean
     */
    public function supportsClass($class)
    {
        $userClass = $this->manager->getClass();

        return $userClass === $class || is_subclass_of($class, $userClass);
    }
}
