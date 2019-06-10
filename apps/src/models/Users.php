<?php
namespace Models;

class Users extends Model {

    protected $primaryKey = "id";
    protected $table      = 'users';
    protected $fillable   = ['id', 'name', 'email', 'phone', 'password', 'status', 'role', 'reset_code', 'created_at', 'updated_at'];

    public function __contstruct()
    {
        parent::construct();
    }

    public function validation()
    {
        \Validate::email($this->email, "Email");
        \Validate::unique($this->email, "users", "email", "Email");
        \Validate::string($this->name, "Name");
        \Validate::password($this->password, "Password");
        \Validate::phone($this->phone, "Phone");
        \Validate::inArray($this->role, [1,2] ,"Role");
        return true;
    }


    // public function create()
    // {
    //     \Validate::email($this->email, "Email");
    //     \Validate::string($this->name, "Name");
    //     \Validate::password($this->password, "Password");
    //     \Validate::phone($this->phone, "Phone");
    //     try {
    //         $this->id = $this->dbCreate();
    //     } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $th) {
    //         throw new \ValidationException("Email must is already used");
    //     }

    //     return $this->dbGet();
    // }

    // public function get()
    // {
    //     \Validate::required($this->id, "id");

    //     return $this->dbGet();
    // }

    // private function dbGet()
    // {
    //     return $this->db()->fetchAssoc( "SELECT * FROM users WHERE id = ?", array($this->id) );
    // }

    // private function dbCreate()
    // {
    //     $insertData["name"]     = $this->name;
    //     $insertData["email"]    = $this->email;
    //     $insertData["password"] = password_hash( $this->password , PASSWORD_DEFAULT);
    //     $insertData["phone"]    = $this->phone;
    //     $this->db()->insert("users", $insertData);

    //     return $this->db()->lastInsertId();
    // }

}
