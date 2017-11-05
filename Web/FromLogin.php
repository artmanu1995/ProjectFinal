<!DOCTYPE html>
<html>
<style>
form {
    width: 27%;
    border: 3px solid #f1f1f1;
}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #0fc15a;
    color: white;
    font-size:20px;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    width: 100%;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
	text-align:left;
}
</style>
<body>
<center>
<h1></h1>
<p><form action="/action_page.php">
  <div class="imgcontainer">
    <img src="img/restaurant.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="กรอก Username" name="un" required>

	<label><b>Password</b></label>
    <input type="password" placeholder="กรอก Password" name="pw" required>
        
    <p><button type="submit">LOGIN</button>
  </div>
</form>
</center>

</body>
</html>
