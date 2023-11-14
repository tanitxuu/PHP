<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $arr[5]=1;
    $arr[12]=12;
    $arr[13]=56;
    $arr['x']=42;
    print_r($arr);
    print_r(count($arr));
    unset($arr[5]);
    print_r($arr);
    unset($arr);
   
    ?>
    
</body>
</html>