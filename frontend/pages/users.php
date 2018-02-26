<div class="container">
    <form action="" role="form" id="add">
        <legend>Add User</legend>
        <label for="name">Name</label>
        <br>
        <input id="name" placeholder="Name">
        <br><br>
        <label for="surname">Surname</label>
        <br>
        <input id="surname" placeholder="Surname">
        <br><br>
        <label for="address">Address</label>
        <br>
        <input id="address" placeholder="Address">
        <br><br>
        <label for="username">Username</label>
        <br>
        <input id="username" placeholder="Username">
        <br><br>
        <label for="password">Password</label>
        <br>
        <input type="password" id="password" placeholder="Password">
        <br><br>
        <label for="email">Email</label>
        <br>
        <input type="email" id="email" placeholder="Email">
        <br>
        <br>
        <button class="btn btn-primary" id="test">Add</button>
    </form>

    <div>
        <br><br>
        <table class="table">
            <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Surname
                </th>
                <th>
                    Address
                </th>
                <th>
                    Username
                </th>
                <th>
                    Password
                </th>
                <th>email
                </th>
            </tr>
            </thead>
            <tbody id="userList">
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/users.js"></script>


