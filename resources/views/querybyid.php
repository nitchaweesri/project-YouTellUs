<?php 

include 'controllers/case.php';
$_result = show_case_id();
$result = $_result[0];
$result_column = $_result[1];
?>

<div class="container-sm">
    <div class="container mb-4 shadow-lg p-3 mb-5 bg-white rounded pd-top">
        <div class="row justify-content-center ">
            <div class="col-lg-10 col-md-12 col-sm-12 pt-lg-5 pt-md-5">
                <?php 

                    $row = mysqli_fetch_array($result);

                    echo "<table class='table table-bordered mb-5'>
                          <thead>
                          <tr class='Regular text-primary'>
                              <th scope='col'>COLUMN_NAME</th>
                              <th scope='col'>VALUE</th>
                          </tr>
                          </thead>
                          <tbody class='Light'>";
                foreach ($result_column as $key => $value) {
                    if (is_object(json_decode($row[$value['COLUMN_NAME']]))) 
                        { 
                            $data = json_decode($row[$value['COLUMN_NAME']]);
                            $lenght = sizeof((array)($data));
                            echo "<tr><td rowspan='$lenght'>".$value['COLUMN_NAME']."</td>";
                            $i = 0;
                            foreach ($data as $key1 => $value1) {
                                if ($i == 0) {
                                    echo  "<td>".$key1.' -> '.$value1."</td></tr>";
                                }else{
                                    echo  "<tr><td>".$key1.' -> '.$value1."</td></tr>";
                                }
                                $i++; 
                            }
                           
                        }
                    else{
                        echo "<tr><td>".$value['COLUMN_NAME']."</td>
                            <td>".$row[$value['COLUMN_NAME']]."</td></tr>";
                    }

                    }
                    // output data of each row
                    
                    echo "</tbody>
                        </table>";

                    // foreach ($result as $key => $value) {
                    //     echo ($value['COLUMN_NAME']); 
                    // }
                    
                  $conn->close();
                ?>
            </div>
        </div>
    </div>
</div>


