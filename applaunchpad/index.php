<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>
<form method="post" action="index.php" enctype="multipart/form-data">
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Choose Your cover</h4><br />
      <ul class="nav nav-pills nav-stacked">
        <li><img src="target2.jpg" class="img-thumbnail" alt="Cover-1" width="304" height="236"/></li>
        </ul><br/>
    </div>
    
    <div  class="col-sm-9">
      <h3>Cover</h3><br />
          <div id="cover1">
              <input type="file" class="btn btn-default" name="fname"/><br />
              <div class="form-group">
                <label for="comment">Add Text To Image</label>
                <textarea class="form-control" maxlength="37" rows="2" cols="10" name="text"></textarea>
            </div>
              <input type="submit" class="btn btn-warning" name="upload" value="Upload image"/>
              <input type="submit" class="btn btn-success" name="saved" value="Saved Screenshots"/>
              <input type="submit" class="btn btn-primary" name="uploaded" value="Uploaded Images" />
              <input type="submit" class="btn btn-danger" name="delete_saved_image" value="Delete Saved Screenshots" />              
              <input type="submit" class="btn btn-info" name="delete_uploaded_image" value="Delete Uploaded Images" /><br /><br />
              <img src="target2.jpg" id="scream" />
          </div>
          <?php 
        if(isset($_GET['n']))
        {
        ?>
        <canvas id="myCanvas" width="836" height="616"
        style="border:1px solid #d3d3d3;">
        Your browser does not support the HTML5 canvas tag.
        </canvas>

        <img style="display: none;" src="<?php echo './upload/'.$_GET['n'];?>" id="upload"/>
        <br /><button class="btn btn-success" onclick="saveit()">SAVE THIS IMAGE</button>&nbsp;<button class="btn btn-default" onclick="javascript:window.location.href='canvas.php';">GO BACK</button>
        <script>
                alert("Your Image has been Uploaded.Press Ok to view");
                var text="<?php echo $_GET['text']; ?>";
                document.getElementById("scream").style.display="none";
                var canvas = document.getElementById("myCanvas");
                var ctx = canvas.getContext("2d");  
                var img = document.getElementById("scream");
                ctx.drawImage(img, 0, 0);
                var img1 = document.getElementById("upload");
                ctx.drawImage(img1,234,257,363,233); 
                ctx.fillStyle = 'rgba(255, 255, 255, 0.1)';
                ctx.fillRect(45,59, 745, 50);
                ctx.fillStyle = '#000';
                ctx.font = '40px sans-serif';
                ctx.fillText(text, 50,99);
                
                function saveit()
                {
                    alert("Image saved");   
                    var dataURL = canvas.toDataURL();
                    console.log(dataURL);
    
                    $.ajax({
                      type: "POST",
                      url: "download.php",
                      data: { 
                         imgBase64: dataURL
                      }
                    }).done(function(o) {
                      console.log('saved'); 
                    
                    });
                }

        </script>
        <?php 
        }
?>
<?php 
if(isset($_REQUEST['upload']))
{
    $text='';
    if(!empty($_REQUEST['text']))
    {
        $text=$_REQUEST['text'];
    }
    $s=$_FILES['fname']['tmp_name'];
    $d=$_SERVER['DOCUMENT_ROOT']."applaunchpad/upload/".$_FILES['fname']['name'];
    if(move_uploaded_file($s,$d))                               
    { 
        $n=$_FILES['fname']['name'];
        header("location:index.php?n=$n & text=$text");
    }
    else
    {
        echo "<script>alert('Please Select a image')</script>";
    }
}
if(isset($_REQUEST['saved']))
{
    ?>
    <script>document.getElementById("scream").style.display="none";</script>
    <?php
    echo "<h3><b>Click on a image to DOWNLOAD it!</b></h3><br />";
    $handle=opendir("./saved");
    while($filename=readdir($handle))
    {
        if($filename=="." || $filename=="..")
        {
            continue;
        }
        
        $ext=explode(".",$filename);
        $ch=strtolower($ext[1]);
        if($ch=='png' || $ch=='jpg')
        {        
                echo "<a href='down.php?name=$filename'><img src='./saved/".$filename."'width='200px' title='$filename' height='200px' border='1px' />&nbsp;&nbsp;&nbsp;&nbsp;</a>";
        }
        else
            echo "<br /><a href='down.php?name=$filename'>".$filename."</a>";
    }
}
if(isset($_REQUEST['uploaded']))
{
    ?>
    <script>document.getElementById("scream").style.display="none";</script>
    <?php
    echo "<h3><b>Click on a image to DOWNLOAD it!</b></h3><br />";
    $handle=opendir("./upload");
    while($filename=readdir($handle))
    {
        if($filename=="." || $filename=="..")
        {
            continue;
        }
        
        $ext=explode(".",$filename);
        $ch=strtolower($ext[1]);
        if($ch=='jpg' || $ch=='png')
        {        
                echo "<a href='down1.php?name=$filename'><img src='./upload/".$filename."'width='200px' title='$filename' height='200px' border='1px' />&nbsp;&nbsp;&nbsp;&nbsp;</a>";
        }
        else
            echo "<br /><a href='down1.php?name=$filename'>".$filename."</a>";
    }
}
if(isset($_REQUEST['delete_saved_image']))
{
    ?>
    <script>document.getElementById("scream").style.display="none";</script>
    <?php
    echo "<h3><b>Click on a image to <u>DELETE</u> it!</b></h3><br />";
    
    $handle=opendir("./saved");
    while($filename=readdir($handle))
    {
        if($filename=="." || $filename=="..")
        {
            continue;
        }
        
        $ext=explode(".",$filename);
        $ch=strtolower($ext[1]);
        if($ch=='png')
        {        
                echo "<a href='del.php?delete_file=$filename &save=true'><img src='./saved/".$filename."'width='200px' title='$filename' height='200px' border='1px' />&nbsp;&nbsp;&nbsp;&nbsp;</a>";
        }
        else
            echo "<br /><a href='down.php?delete_file=$filename &save=true'>".$filename."</a>";
    }
}
if(isset($_REQUEST['delete_uploaded_image']))
{
    ?>
    <script>document.getElementById("scream").style.display="none";</script>
    <?php
    echo "<h3><b>Click on a image to <u>DELETE</u> it!</b></h3><br />";
    
    $handle=opendir("./upload");
    while($filename=readdir($handle))
    {
        if($filename=="." || $filename=="..")
        {
            continue;
        }
        
        $ext=explode(".",$filename);
        $ch=strtolower($ext[1]);
        if($ch=='png' || $ch=='jpg')
        {        
                echo "<a href='del.php?delete_file=$filename'><img src='./upload/".$filename."'width='200px' title='$filename' height='200px' border='1px' />&nbsp;&nbsp;&nbsp;&nbsp;</a>";
        }
        else
            echo "<br /><a href='del.php?delete_file=$filename'>".$filename."</a>";
    }
}
?>
</div>
  </div>
</div>

</form>
<footer class="container-fluid">
  <p>Sushil Jain</p>
</footer>

</body>
</html>
