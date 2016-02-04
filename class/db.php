<?php


class DB {
	private $driver;
	
  	public function __construct()
    {
		$host = "host=ec2-54-225-199-245.compute-1.amazonaws.com";
	$port = "port=5432";
	$dbname = "dbname=dbddrf8jsndbge";
	$user="sousqigydxxmjh";
	$password="KJBXNEMK8Vcyyf5FgIJK6yfygO";
	$credentials = "user=sousqigydxxmjh password=KJBXNEMK8Vcyyf5FgIJK6yfygO";
	$db = pg_connect( "$host $port $dbname $credentials"  );
        //create db connection
        $this->driver = new PDO('pgsql:host=' . $host . ';dbname=' . $dbname . ';', $user, $password);
  		//$this->driver = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
        //set character set
  		$this->driver->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  	}

    /*
     * The $param is to pass in an array of parameters to bind to the sql statement
     * $params = array([value1], [value2])
     *
     */
    public function queryPreparedStatement($sql, $params = array())
    {
        //prepare statement
        $conn = $this->driver;
        $stmt = $conn->prepare($sql);

        //execute statement
        $stmt->execute($params);

        //return the data
        return $stmt->fetchAll();
    }
    
    public function getRowLimitSql($number_of_rows, $page_number)
    {
        //calculate start row
        $start_row = $number_of_rows * ($page_number - 1);

        //build sql
        $sql = ' LIMIT ' . $start_row . ', ' . $number_of_rows;
        
        //return 
        return $sql;
    }     
	
  	public function escape($value, $addQuote = true) 
    {
  		//set return string based on if we are to add quotes or not
		if( $addQuote )
		{	
			$return = "'" . $value . "'";
		} 
		else 
		{
			$return = $value;
		}
		
		return $return;
  	}

  	public function getLastId() 
    {
    	return $this->driver->lastInsertId();
  	}	
    
    public function getDriver() 
    {
        return $this->driver;
    }
	
  	public function __destruct() 
    {
  		$this->driver = null;
  	}

}
?>
