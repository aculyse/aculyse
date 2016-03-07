<?php


namespace Aculyse\Interfaces;

interface IClassManager
{

    public function getTeacherSubject( $teacher_id ) ;

    public function getAllSubjects() ;

    public function getClassesOfferedAtSchool() ;

    public function allocateClassToTeacher( $subject , $class_id , $teacher_id ) ;

    public function getClassDetails( $class_id , $get_class_students = FALSE ) ;

    public function createClass( $class_name , $class_desc , $level ) ;
}