<!Doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>How to load records using Select option with jQuery  AJAX in PHP MySQL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
  <body>
    <div class="container" style="margin-top: 50px;">
      <h2 class="text-center">Load records using Select option with jQuery AJAX in PHP </h2>
      <div class="row">
        <div class="col-md-4"></div>  
          <div class="col-md-4" style="margin-top:20px; margin-bottom:20px;">
            <form id="submitForm">
              <div class="form-group">
                <select class="form-control city" name="city" id="city">
                  <option value="">Select City</option>
                  <?php
                include_once '../dbconnect.php';
                include_once '../dbconfig.php';  

                    $sql_loan = mysqli_query($con,"SELECT DISTINCT `card_number` from loan_initial_banking where user_fnd_id = '9672'");
                    
                      while($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
                          $cityName = $row_bank_detail_sec['card_number'];
                          echo "<option value='$cityName'>$cityName</option>";
                      }
                    

                  ?>
                </select>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-12">
          <div id="show-city">
                 
          </div>
        </div>    
      </div>
      
      <!---jQuery ajax load rcords using select box --->
<script type="text/javascript">
  $(document).ready(function(){
      $(".city").on("change", function(){
        var cityname = $(this).val();
        if (cityname !== "") {
          $.ajax({
            url : "load_data.php",
            type:"POST",
            cache:false,
            data:{cityname:cityname},
            success:function(data){
              $("#show-city").html(data);
            }
          });
        }else{
          $("#show-city").html(" ");
        }
      })
  });
</script>
  </body>
</html>