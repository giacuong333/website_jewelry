<?php

class CustomerOrdersContr extends CustomerOrdersModel
{
      public function getOrdersById($userid)
      {
            return CustomerOrdersModel::getOrdersById($userid);
      }

      public function getOrderDetailsById($orderid, $userid)
      {
            return CustomerOrdersModel::getOrderDetailsById($orderid, $userid);
      }
}
