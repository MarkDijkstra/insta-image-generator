
<!DOCTYPE html>
<html lang="en">
<head>
<style>
*{
    box-sizing: border-box;
}
form{
    width:500px;
    float:left;
    margin:60px;
    clear:both;
}
label{
    width:100%;
    float:left;  
}
input{
    height:40px;
    width:100%;
    float:left;
    clear:both;
    padding:10px;
    margin-bottom:30px
}
textarea{
    height:200px;
    width:100%;
    float:left; 
    clear:both;
    padding:10px;
    margin-bottom:30px
}
.msg{
    text-align:left;
    margin: 15px 60px 0 60px;
    width:500px;
    padding:30px;
    float:left; 
    clear:both;
}
.msg--warning{
    background-color:#F4EF0B;
    border:1px solid #B8AC47;
}
.msg--success{
    background-color:#4FEC13;
    border:1px solid #6EA55A;
}
</style>
</head>
<body>
<?php include_once('generator.php'); ?>

<form method="post" enctype="multipart/form-data">
  <label for="author">author:</label>
  <input type="text" id="author" name="author" value="Nelson Mandela">
  <label for="msg">msg:</label>
  <textarea id="msg" name="msg">It always seems impossible until it's done.
  </textarea> 
  <label for="bg">background:</label>
  <input type="file" id="bg" name="bg" value="">
  <br><br>
  <input type="submit" value="Submit">

</form>
</body>
</html