<?php

class PwdChangingContr extends PwdChangingModel
{
      public function changePwd($oldPwd, $newPwd, $id)
      {
            return PwdChangingModel::changePwd($oldPwd, $newPwd, $id);
      }
}
