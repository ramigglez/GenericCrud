# GenericCrud

## Methods

<ol>
    <li>__construct (string $table = null)</li>
    <li>get ()</li> 
    <li>first ()</li> 
    <li>insert ($obj)</li> 
    <li>exeSql ($obj = null) | PRIVATE</li>
    <li>resetValues () | PRIVATE</li>
    <li>update ($obj)</li> 
    <li>delete ()</li>
    <li>where ($key, $condition, $value)</li>
    <li>orWhere ($key, $condition, $value)</li>
</ol>

## how to get Method

<pre>

    require_once './Connection/Strings/Strings.php';
    require_once './Connection/Connection.php';
    require_once './Crud/Crud.php';

    $get = new Crud('programmers');

    $get->setConnection((new Connection([
        'driver' => 'mysql',
        'host' => 'localhost',
        'data_base' => 'crud_users',
        'port' => '3306',
        'password' => 'Ramigglez.$%^20@',
        'user_name' => 'root',
        'charset' => 'utf8mb4'
    ]))->connect());

    $usersList = $get->get();


    var_dump($usersList);

</pre>

## how to insert Method

<pre>
    require_once './Connection/Strings/Strings.php';
    require_once './Connection/Connection.php';
    require_once './Crud/Crud.php';

    $insert= new Crud('programmers');

    $insert->setConnection((new Connection([
        'driver' => 'mysql',
        'host' => 'localhost',
        'data_base' => 'crud_users',
        'port' => '3306',
        'password' => 'Ramigglez.$%^20@',
        'user_name' => 'root',
        'charset' => 'utf8mb4'
    ]))->connect());

    $id = $insert->insert([
        'names' => 'Coda',
        'lastnames' => 'Boda',
        'email' => 'coda@boda.com',
        'website' => 'codaboda.com',
        'datein' => 'Mar 17 04:42 2022'
    ]);

    echo "El ID INSERTADO ES : $id";
</pre>

## how to update Method

<pre>
    require_once './Connection/Strings/Strings.php';
    require_once './Connection/Connection.php';
    require_once './Crud/Crud.php';

    $update = new Crud('programmers');

    $update->setConnection((new Connection([
        'driver' => 'mysql',
        'host' => 'localhost',
        'data_base' => 'crud_users',
        'port' => '3306',
        'password' => 'Ramigglez.$%^20@',
        'user_name' => 'root',
        'charset' => 'utf8mb4'
    ]))->connect());

    $rowsUpdated = $update->where('id','=',1)->update([
        'names' => 'Cody'
    ]);

    echo "FILAS ACTUALIZADAS : $rowsUpdated";
</pre>

## how to delete Method

<pre>
    require_once './Connection/Strings/Strings.php';
    require_once './Connection/Connection.php';
    require_once './Crud/Crud.php';

    $delete = new Crud('programmers');

    $delete->setConnection((new Connection([
        'driver' => 'mysql',
        'host' => 'localhost',
        'data_base' => 'crud_users',
        'port' => '3306',
        'password' => 'Ramigglez.$%^20@',
        'user_name' => 'root',
        'charset' => 'utf8mb4'
    ]))->connect());

    $rowsDeleted = $delete->where('id','=',1)->delete();

    echo "FILAS ELIMINADAS : $rowsDeleted";
</pre>