<?php

class AdminController extends Admin
{

          public function getAllProducts()
          {
                    return $this->getProducts();
          }

          public function getAllUsers()
          {
                    return $this->getUsers();
          }

          public function setUser($fullname, $email, $phoneNumber, $password, $verifyPassword, $role_id)
          {
                    if ($password == $verifyPassword) {
                              $this->setAnUser($fullname, $email, $phoneNumber, $password, $role_id);
                              return true;
                    } else {
                              return false;
                    }
          }

          public function getUserById($id)
          {
                    return $this->getAnUserById($id);
          }

          public function deleteUserById($id)
          {
                    return $this->deleteAnUserById($id);
          }

          public function updateUser($id, $fullname, $email, $phoneNumber, $role_id)
          {
                    return $this->updateAnUser($id, $fullname, $email, $phoneNumber, $role_id);
          }
}
