<?php

class AdminController extends Admin
{
    // ===================================================== PRODUCT =====================================================

    public function getAllProducts()
    {
        return $this->getProducts();
    }

    public function setProduct($image, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new)
    {
        return $this->setAProduct($image, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new);
    }

    public function deleteProductById($id)
    {
        return $this->deleteAProductById($id);
    }

    public function getProductById($id)
    {
        return $this->getAProductById($id);
    }

    public function updateProductById($id, $imagepath, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new)
    {
        return $this->updateAProductById($id, $imagepath, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new);
    }

    public function searchProducts($searchInput, $searchValue)
    {
        return $this->searchAllProducts($searchInput, $searchValue);
    }

    // ===================================================== USER =====================================================
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

    public function searchUsers($searchInput, $searchValue)
    {
        return $this->searchAllUsers($searchInput, $searchValue);
    }

    // ===================================================== ORDER =====================================================

    public function getOrders()
    {
        return $this->getAllOrders();
    }

    public function saveStatus($id)
    {
        return $this->saveOrderStatus($id);
    }

    public function deleteOrder($id)
    {
        return $this->deleteAnOrderById($id);
    }

    public function searchOrders($searchInput, $searchValue)
    {
        return $this->searchAllOrders($searchInput, $searchValue);
    }

    public function searchOrdersByDate($fromDate, $toDate)
    {
        return $this->searchAllOrdersByDate($fromDate, $toDate);
    }

    public function getOrderByUserId($user_id)
    {
        return Admin::getOrdersByUserId($user_id);
    }

    public function calculateTotalMoneyByUerId($user_id)
    {
        return Admin::calculateTotalMoneyByUerId($user_id);
    }

    // ===================================================== CATEGORY =====================================================
    public function getCategories()
    {
        return $this->getAllCategories();
    }

    public function deleteCategoryById($id)
    {
        return $this->deleteACategoryById($id);
    }

    public function addCategory($name)
    {
        return $this->addNewCategory($name);
    }

    public function getCategoryById($id)
    {
        return $this->getACategoryById($id);
    }

    public function searchCategories($searchInput, $searchValue)
    {
        return $this->searchAllCategories($searchInput, $searchValue);
    }

    public function updateCategory($id, $name)
    {
        return $this->updateAnCategory($id, $name);
    }

    // ===================================================== ROLES =====================================================
    public function getRoles()
    {
        return $this->getAllRoles();
    }

    public function addRole($name)
    {
        return $this->addNewRole($name);
    }

    public function deleteRole($id)
    {
        return $this->deleteARole($id);
    }

    public function updateRole($id, $name)
    {
        return $this->updateARole($id, $name);
    }

    public function getRoleById($id)
    {
        return $this->getARoleById($id);
    }

    public function searchRoles($searchInput, $searchValue)
    {
        return $this->searchAllRoles($searchInput, $searchValue);
    }

    // ===================================================== PERMISSION =====================================================
    public function getPermissions()
    {
        return $this->getAllPermissions();
    }

    public function getPermissionsByRoleId($id)
    {
        return Admin::getPermissionsByRoleId($id);
    }

    public function setPrivilegeByRoleId($role_privilege_id, $permissionKey, $isChecked)
    {
        return Admin::setPrivilegeByRoleId($role_privilege_id, $permissionKey, $isChecked);
    }

    public function hasPermission($role_id, $permission_description)
    {
        return Admin::hasPermission($role_id, $permission_description);
    }

    // ===================================================== GET MENU ITEMS =====================================================
    public function getMenuItems($role_id)
    {
        return Admin::getMenuItems($role_id);
    }

    // ===================================================== GALLERY =====================================================
    public function getGalleries()
    {
        return Admin::getGalleries();
    }

    public function getGalleryById($id)
    {
        return Admin::getGalleryById($id);
    }

    public function deleteGalleryById($id)
    {
        return Admin::deleteGalleryById($id);
    }

    public function addGallery($title, $thumbnail)
    {
        return Admin::addGallery($title, $thumbnail);
    }

    public function searchGalleries($searchInput, $searchValue)
    {
        return Admin::searchGalleries($searchInput, $searchValue);
    }

    // ===================================================== INPUT INVOICES =====================================================
    public function getInputInvoices()
    {
        return Admin::getInputInvoices();
    }

    public function getInputInvoiceById($id)
    {
        return Admin::getInputInvoiceById($id);
    }

    public function deleteInputInvoiceById($id)
    {
        return Admin::deleteInputInvoiceById($id);
    }

    public function getImportProductInvoiceById($id)
    {
        return Admin::getImportProductInvoiceById($id);
    }

    public function addImportInvoice($user_id, $import_product_list, $supplier_id)
    {
        return Admin::addImportInvoice($user_id, $import_product_list, $supplier_id);
    }

    public function searchInputInvoices($searchInput, $searchValue)
    {
        return Admin::searchInputInvoices($searchInput, $searchValue);
    }

    public function search_input_invoice_by_date($fromDate, $toDate)
    {
        return Admin::search_input_invoice_by_date($fromDate, $toDate);
    }

    // ================================================================= SUPPLIER ===========================================================

    public function getSuppliers()
    {
        return Admin::getSuppliers();
    }

    // ================================================================= CONTACT ===========================================================
    public function getContacts()
    {
        return Admin::getContacts();
    }

    public function getContactById($id)
    {
        return Admin::getContactById($id);
    }

    public function deleteContactById($id)
    {
        return Admin::deleteContactById($id);
    }

    public function searchContacts($searchInput, $searchValue)
    {
        return Admin::searchContacts($searchInput, $searchValue);
    }
}
