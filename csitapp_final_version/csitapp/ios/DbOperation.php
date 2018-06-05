<?php


 	class Response 
{
public $title;
public $due_date;

}
	class All 
{
public $title;
public $category;
public $content;
public $create_date;
public $image_path; 
}
	class Event
{
public $title;
public $start_date;
public $content;
public $create_date;
public $image_path; 
}
	class contact
{
public $name;
public $image_path;
public $identity;
public $office_address;
public $phone; 
public $email;
public $department; 
public $function;
}

class DbOperation
{
    private $conn;

    function __construct()
    {
        require_once dirname(__FILE__).'/Constants.php';
        require_once dirname(__FILE__).'/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /*
     * This method is added
     * We are taking username and password
     * and then verifying it from the database
     * */
 
    public function userLogin($username, $pass)
    {
        $password = $pass;
        $stmt = $this->conn->prepare("SELECT id FROM user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
 
    /*
     * After the successful login we will call this method
     * this method will return the user data in an array
     * */
 
    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT id, username FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $uname);
        $stmt->fetch();
        $user = array();
        $user['id'] = $id;
        $user['username'] = $uname;        
        return $user;
    }
	
	public function getnews()
    {
        $stmt = $this->conn->prepare("SELECT title, due_date FROM news ORDER BY due_date ASC");
        //$stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($title, $due_date);
		//$stmt->store_result();
		$message = array();
        while($stmt->fetch()){   		
        $message['title'] = $title;
        $message['due_date'] = $due_date; 
		//printf("%s,%s<br />", $title, $due_date);	
		//var_dump('message',$message+$message);
			
		}
		
		return $message;
        
    }
		public function gGetnewsetnews()
    {
        $sql = "SELECT title, due_date FROM news ORDER BY due_date ASC";
		$result = $this->conn->query($sql);
		while ($row = mysqli_fetch_array($result,MYSQL_ASSOC))
		{
			$response = new Response();
			$deadline = array();
			$response->title = $row["title"];
			$response->due_date = $row["due_date"];
			$deadline['message'] = $response;
			$data[]=$deadline;			
		}      
        echo json_encode($data);
		//return $data;
    }
	public function getAll()
    {
        $sql = "SELECT title, content, category, create_date,image_path  FROM news ORDER BY create_date DESC";
		$result = $this->conn->query($sql);
		while ($row = mysqli_fetch_array($result,MYSQL_ASSOC))
		{
			$response = new All();
			//$deadline = array();
			$response->title = $row["title"];
			$response->category = $row["category"];
			$response->content = $row["content"];
			$response->create_date = $row["create_date"];
			$response->image_path = $row["image_path"];			
			//$deadline['message'] = $response;
			$data[]=$response;
			//printf("%s<br />", $row["image_path"]);
		}      
        echo json_encode($data,JSON_UNESCAPED_SLASHES);
		//echo str_replace("\\/", "/",  json_encode($data));
		//return $data;
    }
	public function getEvent()
    {
        $sql = "SELECT title, start_date, content, create_date, image_path  FROM event ORDER BY start_date DESC";
		$result = $this->conn->query($sql);
		while ($row = mysqli_fetch_array($result,MYSQL_ASSOC))
		{
			$response = new Event();
			//$deadline = array();
			$response->title = $row["title"];
			$response->start_date = $row["start_date"];
			$response->content = $row["content"];
			$response->create_date = $row["create_date"];
			$response->image_path = $row["image_path"];			
			//$deadline['message'] = $response;
			$data[]=$response;
			//printf("%s<br />", $row["image_path"]);
		}      
        echo json_encode($data,JSON_UNESCAPED_SLASHES);
		//echo str_replace("\\/", "/",  json_encode($data));
		//return $data;
    }
	

	public function getContact()
    {
        $sql = "SELECT name, image_path, identity, office_address, phone, email, department, function  FROM contact";//ORDER BY start_date DESC
		$result = $this->conn->query($sql);
		while ($row = mysqli_fetch_array($result,MYSQL_ASSOC))
		{
			$response = new contact();
			//$deadline = array();
			$response->name = $row["name"];
			$response->image_path = $row["image_path"];
			$response->identity = $row["identity"];
			$response->office_address = $row["office_address"];
			$response->phone = $row["phone"];	
			$response->email = $row["email"];	
			$response->department = $row["department"];	
			$response->func = $row["function"];				
			//$deadline['message'] = $response;
			$data[]=$response;
			//printf("%s<br />", $row["image_path"]);
		}      
        echo json_encode($data,JSON_UNESCAPED_SLASHES);
		//echo str_replace("\\/", "/",  json_encode($data));
		//return $data;
    }
 
 
    public function createUser($username, $pass)
    {
        if (!$this->isUserExist($username)) {
            $password = $pass;
            $login_date = date("Y-m-d");
            $stmt = $this->conn->prepare("INSERT INTO user (username, password, login_date) VALUES (?, ?, ?)");
            $stmt->bind_param("sssss", $username, $password);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }
 
 
    private function isUserExist($username)
    {
        $stmt = $this->conn->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->bind_param("sss", $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
 
 
}
?>