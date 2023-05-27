<!DOCTYPE html>
<html>
<head>
    <title>UCG</title>
</head>
<body>
<h1>
    <h1> Hi  {{$user->name }} Dear! </h1>

</h1>

<br>
<h2>
    
    Your credential account are : account_number : {{$user->get_latest_account()->account_number }} currency : {{$user->get_latest_account()->currency }} 
     counrty : {{$user->get_latest_account()->counrty }} 
    
    <p></p>

<p>Regards,</p>
<p>Thank you</p>
</h2>
</body>
</html>