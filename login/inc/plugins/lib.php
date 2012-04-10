<?php

class ldap{
    var $ds;
    
    function __construct($host,$port){
        $this->ds=@ldap_connect($host,$port);
    }
    
    function authenticate($username,$password){
        return @ldap_bind($this->ds,"cn=".$username.",ou=users",$password);
    }

    function getInformation($username){
        $sr=@ldap_search($this->ds,"ou=users","name=".$username);
        return @ldap_get_entries($this->ds, $sr);
    }

    function getUsername($email){
        $sr=@ldap_search($this->ds,"ou=email","email=".$email);
        return @ldap_get_entries($this->ds, $sr);
    }
    
    function changeInformation($username,$password,$array){
        $this->authenticate($username,$password);
        return @ldap_modify($this->ds,"cn=".$username.",ou=users",$array);
    }
}

?>
