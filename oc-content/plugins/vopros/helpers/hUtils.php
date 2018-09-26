<?php

if (!function_exists("filter_import_sql")) {
    /**
     * Imports an SQL file into the Osclass database.
     *
     * Really useful when installing a plugin to create its model schema,
     * or delete its schema on uninstall. Avoid to have an install/uninstall
     * method in every plugin data-access object.
     *
     * @param   $path absolute file path to the SQL file to import.php.
     *
     * @return  void
     *
     * @throws  Exception if the import.php fails.
     *
     * @see     Madhouse_Utils_Models::import.php
     */
    function filter_import_sql($path)
    {
        // Try to import.php it. Throws Exception if failure.
        $conn = DBConnectionClass::newInstance()->getOsclassDb();
        $dao = new DBCommandClass($conn);

        // // Get the content of the file.
        $sql = file_get_contents($path);

        // Strip comments.
        // Makes DAO go wazoo.
        $sql = preg_replace('/\-\-.*$/m', '', $sql);

        if (! $dao->importSQL($sql)) {
            throw new Exception("Import failed with: '" . $dao->getErrorDesc() . "'");
        }
    }
}