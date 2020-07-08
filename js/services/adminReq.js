app.factory('adminservice', function ($http) {

    var obj = {};

    var allContacts = 'http://localhost:8000/api/admin/getusers.php'; //list of all registered users
    var login = 'http://localhost:8000/api/login/signing.php'; // sign in account
    var register = 'http://localhost:8000/api/admin/addNewContact.php'; // register user account
    var update = 'http://localhost:8000/api/admin/updateContact.php'; // update user account
    var check = 'http://localhost:8000/api/admin/existContact.php'; // check if user account exists
    var deletion = 'http://localhost:8000/api/admin/deleteContact.php'; // check if user account exists

    obj.getUsers = function() {
        return $http.get(allContacts);
    }
    obj.getLoggin = function(user,pass) {
        return $http.get(login + '?id='+ user + '&pass=' + pass);
    }
    obj.registerUser= function (data) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        return $http.post(register,data)
    }
    obj.updateUser= function (data) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        return $http.post(update,data)
    }
    obj.checkUser = function(id) {
        return $http.get(check + '?id='+id);
    }
    obj.deleteUser = function(id) {
        return $http.get(deletion + '?id='+id);
    }

    return obj;
});