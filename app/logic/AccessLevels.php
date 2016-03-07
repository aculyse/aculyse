<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * This class provides constants for access levels
 */

namespace Aculyse;

class AccessLevels
{

    /**
     * access types, this are selected during session inititialization based on access levels this are used by the app only in sessions
     */
    const LEVEL_NO_ACCESS = 0;

    /**
     * allow user to read and write student records
     */
    const LEVEL_WRITE_STUDENTS = 1;

    /**
     * allow user to only read student records
     */
    const LEVEL_READ_STUDENTS_ONLY = 2;

    /**
     * allow user to only read analytics reports, usually this access level is used by principals
     */
    const LEVEL_READ_ANALYTICS_ONLY = 3;

    /**
     * allow user to read and write student marks and profiles, this access level is usually associated with teachers
     */
    const LEVEL_WRITE_ANALYTICS = 4;

    /**
     * allow user to view everything in the system but cannot change any data
     */
    const LEVEL_UNIVERSAL_READ_ONLY = 5;

    /**
     * givs full access to the system, but only with one account
     */
    const LEVEL_SINGLE_MODE = 7;

    /**
     * allow user to have admin privledges but the admin cannot write to student marks, only teachers can do that
     */
    const LEVEL_ADMIN_ONLY = 6;


    const LEVEL_GUARDIAN = 8;

    //access levels, used for login purpose, this are the ones saved in the database

    /**
     * access level which shows that a user is a lecturer, this is saved into the database
     */
    const LECTURER = 1;

    /**
     * access level which shows that a user is a student records manager, this is saved into the database
     */
    const STUDENT_MANAGER = 2;

    /**
     * access level which shows that a user is a principal or headmaster, this is saved into the database
     */
    const PRINCIPAL = 3;

    /**
     * access level which shows that a user is a admin, this is saved into the database
     */
    const ADMINSTRATOR = 4;

    /**
     * access level which shows that a user is a single user, this is saved into the database
     */
    const SINGLE_USER = 5;

}
