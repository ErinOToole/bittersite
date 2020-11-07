<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Student
 *
 * @author Erin O'Toole
 */
class Student {
    private $studentId;
    private $name;
    protected $age; //accessible in sub classes
    CONST school = "NBCC"; //how to declare a constant, constants cannot be overridden
    public static $status;
    
    public static function PrintSchool(){ //static methods do not need an instance of the object, you can call them directly from the class
        echo "NBCC<BR>";
    }
    
    public function __construct($studentId, $name, $age) { //constructor method, two underscores in front of construct
        $this->studentId = $studentId; //do not write $this->$studentId. 
        $this->name = $name;
        $this->age = $age;
    }
    
    public function __destruct(){ //called at the end automatically after everything has already happened
        echo "OBJECT DESTROYED<BR>"; //printing something out just to prove it's working.  This destroys the object when it's called
    }
    
    public final function SomeMethod(){
        echo "THIS FUNCTION CAN'T BE OVERRIDDEN IN CHILD CLASSES"; //just to show that final methods can exist
    }
    //public abstract function someMethod(); //abstract method, class needs to be abstract to have an abstract method.

    public function __get($name){ //two underscores, name is whatever property value that you want it to return
        //every getter returns the property itself
        return $this->$name;
    }
    
    public function __set($property, $value){ //property that you want to set and then the value that you want to give it
        $this->$property = $value;
    }
    
//    public function getStudentId() {
//        //$this is a reference to the current object
//        //arrow means the same thing as the dot (dereference the pointer, get me the stuff inside of this object). In Java we say 'this.studentId' but in php it's 'this->studentId'
//        return $this->studentId;
//    }
//
//    public function getName() {
//        return $this->name;
//    }
//
//    public function getAge() {
//        return $this->age;
//    }
//
//    public function setStudentId($studentId) {
//        $this->studentId = $studentId;
//        return $this;
//    }
//
//    public function setName($name) {
//        $this->name = $name;
//        return $this;
//    }
//
//    public function setAge($age) {
//        $this->age = $age;
//        return $this;
//    }


}
