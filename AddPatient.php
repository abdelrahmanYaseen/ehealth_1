<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Patient Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 8px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #111;
}

.active {
    background-color: #808080;
}
</style>
</head>
<body>
<?php
        if ((isset($_SESSION['Authorized']))&& ($_SESSION["UserType"] == "Admin"))
        {
?>
<header>
    <ul id="header">
  <li><a href="http://localhost/ehealth/AdminHome.php">Home</a></li>
  <li><a href="http://localhost/ehealth/DoctorTable.php">Doctor Table</a></li>
  <li><a href="http://localhost/ehealth/PatientTable.php">Patient Table</a></li>
        <li><a href="http://localhost/ehealth/logout.php" style="position: absolute;right: 0px;">logout</a></li>
</ul>
    
    </header>
    
    
                <div class="container">
            <h1 class="form-heading col-xs-offset-1 " style="font-family: Times;font-size: 40px;">Patient Form</h1>
                    <br>
                    <div class="row">
                        <div class="col-md-4 col-xs-offset-1 col-xs-9">
                <div class="form-group row">
              <label for="example-text-input" class="col-2 col-form-label">Name</label>
              <div class="col-10">
                <input class="form-control" type="text"  id="Name">
              </div>
            </div>
            <div class="form-group row">
              <label for="example-text-input" class="col-2 col-form-label">Surname</label>
              <div class="col-10">
                <input class="form-control" type="text" id="Surname">
              </div>
            </div>
            <div class="form-group row">
              <label for="example-text-input" class="col-2 col-form-label">Username</label>
              <div class="col-10">
                <input class="form-control" type="text"  id="Username">
              </div>
            </div>
            <div class="form-group row">
              <label for="example-password-input" class="col-2 col-form-label">Password</label>
              <div class="col-10">
                <input class="form-control" type="password" id="Password">
              </div>
            </div>
            <div class="form-group row">
              <label for="example-date-input" class="col-2 col-form-label">Birthdate</label>
              <div class="col-10">
                <input class="form-control" type="date" id="BirthDate">
              </div>
            </div> 
            
            <div class="form-group row">
                <label for="example-date-input" class="col-2 col-form-label">DoctorID</label>
                 <div class="col-10" id="doctorrow">
                     
                  </div>
              </div>                
                            
             <div id="message"></div>                 
            <div class="form-actions">
                  <div class="row">
                      <div class="col-md-9">
                         <button type="button" id="button1">Submit</button>
                      </div>
                  </div>
            </div>
                            <br>
            </div>
        </div>
    </div>
    
    
        <script type="text/javascript">
            
        window.onload = function () {
        
        var parsedUrl = new URL(window.location.href);
            Operation = parsedUrl.searchParams.get("Operation");
            PatientID=parsedUrl.searchParams.get("PatientID");
            UserID=parsedUrl.searchParams.get("UserID");
        
        
        var xmlhttp = new XMLHttpRequest();
                var url = "http://localhost/ehealth/TablesManagement.php";
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        response = xmlhttp.responseText;
                        
                        JSONResponse = JSON.parse(response);

                        console.log('The response :' + response);
                        DivContent = "" ;
                        
                        
                        DivContent = DivContent+'<select id="DoctorID" class="form-control">';
                        
                        for(jidx=0;jidx<JSONResponse["Result"].length;jidx++){
                            
                            
                            DivContent = DivContent + '<option value="'+JSONResponse["Result"][jidx]["DoctorID"]+'">'+JSONResponse["Result"][jidx]["DoctorID"]+'</option>';
                            
                        }
                        DivContent = DivContent+'</select>';
                        
                         $('#doctorrow').empty();
                        $('#doctorrow').append(DivContent);
                    }
                };

                xmlhttp.open("POST", url, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var params = "Operation=ListAllDoctors";
                xmlhttp.send(params);
    
       
        if(Operation=="Edit"){
            
            
            var xmlhttp4 = new XMLHttpRequest();
                var url4 = "http://localhost/ehealth/TablesManagement.php";
                xmlhttp4.onreadystatechange = function () {
                    if (xmlhttp4.readyState == 4 && xmlhttp4.status == 200) {
                        response = xmlhttp4.responseText;
                        console.log(response); 
                        JSONResponse4 = JSON.parse(response);
                        
                        console.log(Operation);
                      
                        document.getElementById("BirthDate").value = JSONResponse4["Result"][0]["BirthDate"];
                        document.getElementById("DoctorID").value =JSONResponse4["Result"][0]["DoctorID"];
                        
                        $('#Name').val(JSONResponse4["Result"][0]["Name"]); 
                        $('#Surname').val(JSONResponse4["Result"][0]["Surname"]);
                        $('#Username').val(JSONResponse4["Result"][0]["Username"]);
                        $('#Password').val(JSONResponse4["Result"][0]["Password"]);
                   //     $('#BithDate').val(JSONResponse4["Result"][0]["Description"]);
                    }
                };
            
                xmlhttp4.open("POST", url4, true);
                xmlhttp4.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var params = 'Operation=ListAllPatients&PatientID='+PatientID+'&UserID='+UserID;
                xmlhttp4.send(params);
                    
            
           }
        
        
    };                 
            
    
    $('#button1').click(function(){
        var parsedUrl = new URL(window.location.href);
            Operation = parsedUrl.searchParams.get("Operation");
            PatientID=parsedUrl.searchParams.get("PatientID");
            UserID=parsedUrl.searchParams.get("UserID");
        
        if(Operation=="Edit"){
         var xmlhttp3 = new XMLHttpRequest();
                var url3 = "http://localhost/ehealth/TablesManagement.php";
                xmlhttp3.onreadystatechange = function () {
                    if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200) {
                        response = xmlhttp3.responseText;
                        console.log(response); 
                        JSONResponse3 = JSON.parse(response);

                        console.log(response);
                        DivContent3 = "" ;
                        
                        if(JSONResponse3["Result"]=="1")
                            {
                               window.location.href = "http://localhost/ehealth/PatientTable.php"; 
                            }
                        else if(JSONResponse3["Result"]=="3")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please fill Name field</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="4")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please fill Surname field</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="6")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please fill Password field</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="7")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please select your BirthDate</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="9")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Your Password Must Contain At Least 8 Characters!</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="10")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Your Password Must Contain At Least 1 Number!</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="11")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Your Password Must Contain At Least 1 Capital Letter!</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="12")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Your Password Must Contain At Least 1 Lowercase Letter!</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else{
                            DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Submission failed</p>'
                            $('#message').empty();
                            $('#message').append(DivContent);
                        }
                        
                       
                    }
                };
        
        
            
                xmlhttp3.open("POST", url3, true);
                xmlhttp3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var params = 'Operation=EditPatient&PatientID='+PatientID+'&Name='+$('#Name').val()+'&Surname='+$('#Surname').val()+'&Username='+$('#Username').val()+ '&UserID='+UserID+ '&Password='+$('#Password').val()+ '&BirthDate='+$('#BirthDate').val()+'&DoctorID='+$('#DoctorID').val();
                xmlhttp3.send(params);
            
        }
        else{
        var xmlhttp3 = new XMLHttpRequest();
                var url3 = "http://localhost/ehealth/TablesManagement.php";
                xmlhttp3.onreadystatechange = function () {
                    if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200) {
                        response = xmlhttp3.responseText;
                        console.log(response); 
                        JSONResponse3 = JSON.parse(response);

                        console.log(response);
                        DivContent3 = "" ;
                        
                        if(JSONResponse3["Result"]=="1")
                            {
                              window.location.href = "http://localhost/ehealth/PatientTable.php";
                            }
                        else if(JSONResponse3["Result"]=="2")
                        {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Username already exists</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                        }
                        else if(JSONResponse3["Result"]=="3")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please fill Name field</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="4")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please fill Surname field</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="5")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please fill Username field</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="6")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please fill Password field</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="7")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">please select your BirthDate</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="9")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Your Password Must Contain At Least 8 Characters!</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="10")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Your Password Must Contain At Least 1 Number!</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="11")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Your Password Must Contain At Least 1 Capital Letter!</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else if(JSONResponse3["Result"]=="12")
                            {
                               DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Your Password Must Contain At Least 1 Lowercase Letter!</p>'
                                $('#message').empty();
                                $('#message').append(DivContent);
                            }
                        else{
                            DivContent='<p style="font-family: Times;color:red;font-size: 14px;">Submission failed</p>'
                            $('#message').empty();
                            $('#message').append(DivContent);
                        }
                        
                         
                    }
                };
        
        
                xmlhttp3.open("POST", url3, true);
                xmlhttp3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var params = 'Operation=AddPatient&Name='+$('#Name').val()+'&Surname='+$('#Surname').val()+'&Username='+$('#Username').val()+ '&Password='+$('#Password').val()+ '&BirthDate='+$('#BirthDate').val()+ '&DoctorID='+$('#DoctorID').val();
                xmlhttp3.send(params);
            
        }
    });
    </script>
    <?php
    } else {
            header("Location: http://localhost/ehealth/index.php");
        } ?>
    </body>
</html>
