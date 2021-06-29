<html>
<head><title>PHP TEST</title></head>
<body>
<p>Œ‹‰Ê‹L‰¯Œ^l‘¥‰‰Z</p>
<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
<input type="text" name="input_a"><br><br>
<input type="text" name="input_b"><br><br>
      ‰‰Zq:<select name="kind">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">~</option>
        <option value="/">€</option>
      </select><br>
<input type="submit" name="btn1" value="ŒvZ‚·‚é">
</form>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    writeData();
}
readData();
function readData(){
    $result_calc_file = 'calc_reult.txt';
    $fp = fopen($result_calc_file, 'rb');
    if ($fp){
        if (flock($fp, LOCK_SH)){
            while (!feof($fp)) {
                $buffer = fgets($fp);
                print($buffer);
            }
            flock($fp, LOCK_UN);
        }else{
            print('fail file lock');
        }
    }
    fclose($fp);
}
function writeData(){
    $input_a = $_POST['input_a'];
    $input_b = $_POST['input_b'];
    $kind = $_POST['kind'];
    switch ($kind) {
     case '+':
         $result = $input_a + $input_b;
         break;
     case '-':
         $result = $input_a - $input_b;
         break;
     case '*':
         $result = $input_a * $input_b;
         break;
     case '/':
         $result = $input_a / $input_b;
         break;
    };
    
    $data = "<hr>\r\n";
    $data = $data."<p>input_a:".$input_a."</p>\r\n";
    $data = $data."<p>input_b:".$input_b."</p>\r\n";
    $result_calc_file = 'calc_reult.txt';
    print $data;
    print $kind."<br>";
    print $result;
    $fp = fopen($result_calc_file, 'ab');
    if ($fp){
        if (flock($fp, LOCK_EX)){
            if (fwrite($fp,  $data) === FALSE){
                print('fail file write');
            }
            if (fwrite($fp,  $kind."<br>") === FALSE){
                print('fail file write');
            }
            if (fwrite($fp,  $result) === FALSE){
                print('fail file write');
            }
            flock($fp, LOCK_UN);
        }else{
            print('fail file lock');
        }
    }
    fclose($fp);
}
?>
</body>
</html>