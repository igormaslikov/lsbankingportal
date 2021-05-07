<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />


<script>
        
        
        $.fn.fonkTopla = function() {
var toplam = 0;
this.each(function() {
   var deger = fonkDeger($(this).val());
   toplam += deger;
});
return toplam;
};


function fonkDeger(veri) {
    return (veri != '') ? parseInt(veri) : 0;
}

$(document).ready(function(){
$('input[name^="fiyat"]').bind('keyup', function() {
   $('#toplam').html( $('input[name^="fiyat"]').fonkTopla());
});
});
    </script>


</head>
<body>

    <br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="js/scripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>



<style>
    
 #rcorners1 {
  border-radius: 25px; 
 }
 
 .wrapper {
    width: 100%;
    max-width: 1330px;
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>
</head>

<body>

<?php include('menu.php') ;?>

    
  <div class ="container wrapper" style="margin-top:10px;border:2px solid black" id="rcorners1">


  <div class="row wrapper">

  <form action="postenquiry.php" method="post" name="myform" onkeyup="calculate()">
  <div id="kapsayici">
  
  <!-- <input name="id_type" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $id_type;?>">-->

<br> <br>
<h4><hr>&nbsp;&nbsp;Loan Calculator</h4>
<br>
    <div class="col-lg-2" id="rcorners1">
      <label for="usr">Annual Interest Rate</label>
      <input name="annual_interest" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
     <br> <br> <br>
     <div class="col-lg-2" id="rcorners1">
      <label for="usr">Years</label>
<input name="years" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <br> <br> <br>
    
    <div class="col-lg-2" id="rcorners1">
      <label for="usr">Payments Per Year </label>
      <input name="pay_per_year" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
     <br> <br> <br>
    
    <div class="col-lg-2" id="rcorners1">
      <label for="usr">Amount </label>
      <input name="amount" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
     <br> <br> <br>
    
   <input type="text" name="textbox5" />
    
    </div>

      
  </form>
  
   
</div>

</div>

  <script>
        
    var form = document.forms.myform,
  annual_interest = form.annual_interest,
  years = form.years,
  output = form.textbox5;

window.calculate = function() {
  var q = parseInt(annual_interest.value, 10) || 0,
    c = parseFloat(years.value) || 0;
  output.value = (q * c).toFixed(2);
};

    </script>

</body>
</html>     