<?php

class User extends dbLink
{

    public function __construct()
    {
        parent::__construct();
    }

    public function check_login($username, $password)
    {

        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $query = $this->mysqli->query($sql);

        if ($query->num_rows > 0) {
            $row = $query->fetch_array();
            return $row['id'];
        } else {
            return false;
        }
    }

    public function details($sql)
    {

        $query = $this->mysqli->query($sql);
        $row = $query->fetch_array();
        return $row;
    }

    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }
}