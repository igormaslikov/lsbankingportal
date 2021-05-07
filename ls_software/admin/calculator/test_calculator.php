<html>
<head>
 <style>
     
   html,body,div,span,h1,h2,h3,p,hr,br,img,form,input,ul,li,a {
 margin:0;
 padding:0;
 border:0;
}
ul li {list-style:none;}
body {
 font-family:Helvetica, Arial, Tahoma, sans-serif;
 font-size:13px;
 color:#444;
 line-height:1.5em;
} 
#kapsayici {
background:#fff;
margin:10px auto;
width:960px;
min-height: 700px;
}
input {
border:1px solid #dfdfdf;
}  
     
     
     
 </style>   
 <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    
    <script>
        
        
      function getPeople(input){ 
 if (isNaN(input.value)){
 input.value = 0;
 }
}    

   function getPeoplee(input){ 
 if (isNaN(input.value)){
 input.value = 0;
 }
}    

function calculate(input){ 
 if (isNaN(input.value)){
 input.value = 0;
 }
var price = input.value;
var people = document.getElementById("qty").value;
var peoplee = document.getElementById("qtyy").value;
var calc = people * peoplee / price;
document.getElementById('textbox5').value = calc;
}
    </script>
    
</head>    
    
    
  <body>  
    
<form action="postenquiry.php" method="post" name="myform">
<label>Num of People</label>    <input type="text" name="qty" id="qty" onchange="getPeople(this);"/><br/>
<label>Num of People</label>    <input type="text" name="qtyy" id="qtyy" onchange="getPeoplee(this);"/><br/>
<label>Price</label>    <input type="text" name="cost" id="cost" onchange="calculate(this);"/><br/>
<input type="text" name="textbox5" id="textbox5"/>

</div>
</body>
</html>