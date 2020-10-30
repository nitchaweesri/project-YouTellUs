<?php 
include 'controllers/case.php';
$result = show_case();
?>

<div class="container-sm">
    <div class="container mb-4 shadow-lg p-3 mb-5 bg-white rounded pd-top">
        <div class="row justify-content-center ">
            <div class="col-lg-10 col-md-12 col-sm-12 pt-lg-5 pt-md-5">
                <?php 
                
                    echo "<table class='table table-bordered mb-5'>
                          <thead>
                          <tr class='Regular text-primary'>
                              <th scope='col'>caseid</th>
                              <th scope='col'>title</th>
                              <th scope='col'>description</th>
                          </tr>
                          </thead>
                          <tbody class='Light'>";
                foreach ($result as $key => $value) {
                    // output data of each row
                    echo "<tr><td><a href='index.php?page=querybyid&id=".$value["FEEDID"]."' >".$value["CASEID"]."</a></td>
                              <td>".$value["FEEDTITLE"]."</td>
                              <td>".unserialize($value["FEEDBODY"])['description']."</td>
                              </tr>";
                }
                    echo "</tbody>
                        </table>";
                  $conn->close();
                ?>
            </div>
        </div>
    </div>
</div>


