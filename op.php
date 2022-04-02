
    <?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);

    require_once("rest/dao/TodoDao.class.php");

    $dao=new TodoDao();

    $op=$_REQUEST['op'];

    switch ($op) {


      case 'insert':
        $description=$_REQUEST['description'];
        $created=$_REQUEST['created'];
        $result=$dao->add($description,$created);
        print_r($result);

        break;

      case 'delete':
        $id=$_REQUEST['id'];
        $dao->delete($id);
        echo "Deleted $id";

        break;

      case 'update':
        $description=$_REQUEST['description'];
        $created=$_REQUEST['created'];
        $id=$_REQUEST['id'];
        $dao->update($id,$description,$created);
        echo "updated $id";

        break;

      case 'get':  
      default:
        $results=$dao->get_all();
        print_r($results);
        break;
    }












     ?>
