<?php
  include('../connection.php');

  $sql = "SELECT * FROM inventory";
  $result = $conn -> query($sql);

  echo "
    <thead>
      <tr>
        <th></th>
        <th>Equipment Name</th>
        <th>Equipment ID</th>
        <th>Brand</th>
        <th>Quantity</th>
        <th>In Reservation</th>
        <th>Available</th>
      </tr>
    </thead>
    <tbody>
  ";

  while($row = $result -> fetch_array()){
    echo "
      <tr id='".$row['id']."'>
        <td>
          <a class='edit btn btn-warning btn-sm'>Edit</a>
          <a class='delete btn btn-danger btn-sm'>Delete</a>
        </td>
        <td>".$row['name']."</td>
        <td>".$row['serial_code']."</td>
        <td>".$row['brand']."</td>
        <td>".$row['quantity']."</td>
        <td>".$row['in_reserve']."</td>
        <td>".$row['available']."</td>
      </tr>
    ";
  }

  echo "</tbody>";

  $conn -> close();
?>