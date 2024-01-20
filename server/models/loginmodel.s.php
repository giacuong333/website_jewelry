<?php
class Login extends Database
{

          protected function getUser($useremail, $password)
          {
                    try {
                              $stmt = $this->connect()->prepare("SELECT `id`, `email`, `password` FROM `user` WHERE `email` = ?;");
                              $stmt->execute([$useremail]);

                              if ($stmt->rowCount() == 0) {
                                        header("location: ../templates/login.php?error=usernotfound");
                                        exit();
                              }

                              $user = $stmt->fetch(PDO::FETCH_ASSOC);

                              $checkPassword = password_verify($password, $user["password"]);

                              if (!$checkPassword) {
                                        $stmt = null;
                                        header("location: ../templates/login.php?error=wrongpassword");
                                        exit();
                              }

                              session_start();
                              $_SESSION["id"] = $user["id"];
                              $_SESSION["useremail"] = $user["email"];
                    } catch (PDOException $e) {
                              header("location: ../templates/login.php?error=stmtfailed");
                              exit();
                    }
          }
}
