<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Others extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function export2( $table )
    {

        /*******EDIT LINES 3-8*******/
        $DB_Server   = "localhost";
        $DB_Username = "root";
        $DB_Password = "555asd**";
        $DB_DBName   = "erp";
        $DB_TBLName  = $table;
        //$filename    = $table.'-';
        $filename    = $table."_" . date('Y-m-d H:i:s');
        /*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/
        //create MySQL connection
        $sql = "Select * from $DB_TBLName";
        $Connect = @mysqli_connect($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
        mysql_query("SET NAMES utf8");
        //select database
        $Db = @mysql_select_db($DB_DBName, $Connect) or die("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());
        //execute query
        $result = @mysql_query($sql,$Connect) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
        $file_ending = "xls";
        //header info for browser
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$filename.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        /*******Start of Formatting for Excel*******/
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character
        //start of printing column names as names of MySQL fields
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result,$i) . "\t";
        }
        print("\n");
        //end of printing column names
        //start while loop to get data

        while($row = mysql_fetch_row($result))
        {
            $schema_insert = "";
            for($j=0; $j<mysql_num_fields($result);$j++)
            {
                if(!isset($row[$j]))
                    $schema_insert .= "NULL".$sep;
                elseif ($row[$j] != "")
                    $schema_insert .= "$row[$j]".$sep;
                else
                    $schema_insert .= "".$sep;
            }
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
        }

    }

    public function upload_images()
    {
        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);
        foreach ($_FILES as $key => $value) {
            if ( !$this->upload->do_upload($key))
            {
                $error = array('error' => $this->upload->display_errors());
                echo 0;
            }
            else
            {
                echo '"'.$this->upload->data('file_name').'"';
            }
        }
    }

    public function upload_images2()
    {
        $data = $this->input->post('data');
        $name = $this->input->post('name');
        $data = substr($data,strpos($data,",")+1);
        $data = base64_decode($data);
        $file = 'assets/uploads/sign/'.$name.'.jpg';
        if(file_put_contents($file, $data)){
            echo 1;
        } else {
            echo 0;
        }
    }

    public function xml()
    {
        $this->load->view('dashboard/c0401');
    }

    public function zip()
    {
        $this->load->library('zip');
        $path = 'assets/uploads/invoice_xml/'.date('Y').'/'.date('m').'/'.date('d').'/';
        $this->zip->read_dir($path);
        // Download the file to your desktop. Name it "my_backup.zip"
        $this->zip->download('invoice_xml_'.date('Y-m-d').'.zip');
        //$this->load->view('dashboard/zip');
    }

    public function download()
    {
        if(!empty($_GET['file'])){
            $fileName = basename($_GET['file']);
            $filePath = './assets/uploads/invoice_xml/'.$fileName;
            if(!empty($fileName) && file_exists($filePath)){
                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$fileName");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");
                // Read the file
                readfile($filePath);
                exit;
            }else{
                echo 'The file does not exist.';
            }
        }
    }

    public function backup_db()
    {
        // Database configuration
        $host = $this->db->hostname;
        $username = $this->db->username;
        $password = $this->db->password;
        $database_name = $this->db->database;

        // Get connection object and set the charset
        $conn = mysqli_connect($host, $username, $password, $database_name);
        $conn->set_charset("utf8");


        // Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        $sqlScript = "";
        foreach ($tables as $table) {

            // Prepare SQLscript for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);

            $sqlScript .= "\n\n" . $row[1] . ";\n\n";


            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);

            $columnCount = mysqli_num_fields($result);

            // Prepare SQLscript for dumping data for each table
            for ($i = 0; $i < $columnCount; $i ++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sqlScript .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j ++) {
                        $row[$j] = $row[$j];

                        if (isset($row[$j])) {
                            $sqlScript .= '"' . $row[$j] . '"';
                        } else {
                            $sqlScript .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }

            $sqlScript .= "\n";
        }

        if(!empty($sqlScript))
        {
            // Save the SQL script to a backup file
            $backup_file_name = $database_name . '_backup_' . date('Y-m-d_H-i-s') . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            $number_of_lines = fwrite($fileHandler, $sqlScript);
            fclose($fileHandler);

            // Download the SQL backup file to the browser
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backup_file_name));
            ob_clean();
            flush();
            readfile($backup_file_name);
            exec('rm ' . $backup_file_name);
        }
    }

}