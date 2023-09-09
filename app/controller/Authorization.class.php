<?php

namespace controller;

class Authorization
{
    private $groupeRoles;

    public function setGroupeRoles(array $groupeRoles): void
    {
        $this->groupeRoles = $groupeRoles;
    }

    public function __construct()
    {
        $this->setGroupeRoles([]);
    }

    public function addGroupeRoles($groupId, $roleId): void
    {
        if (!isset($this->groupeRoles[$groupId])) {
            $this->groupeRoles[$groupId] = [];
        }
        $this->groupeRoles[$groupId][] = $roleId;
    }

    public function removeGroupeRoles($groupId, $roleId): void
    {
        if (isset($this->groupeRoles[$groupId])) {
            $index = array_search($roleId, $this->groupeRoles[$groupId]);
            if ($index !== false) {
                unset($this->groupeRoles[$groupId][$index]);
            }
        }
    }

    public function isAuthorized($userIdGroupe, $roleId): bool
    {
        if (isset($this->groupeRoles[$userIdGroupe])) {
            return in_array($roleId, $this->groupeRoles[$userIdGroupe]);
        }
        return false;
    }
}
