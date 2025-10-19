<?php
include 'db.php';
$websites = ['WebsiteA','WebsiteB','WebsiteC','WebsiteD','WebsiteE'];
$priorities = ['High','Medium','Low'];
$status = ['pending','completed'];

for($i=1;$i<=20000;$i++){
    $title = "Task $i";
    $website = $websites[array_rand($websites)];
    $priority = $priorities[array_rand($priorities)];
    $stat = $status[array_rand($status)];

    mysqli_query($con, "INSERT INTO tasks(title, website, priority, status) 
                        VALUES('$title','$website','$priority','$stat')");
}
?>
