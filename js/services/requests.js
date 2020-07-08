app.factory('webservice', function ($http) {

    var obj = {};

    var login = 'http://localhost:8000/api/login/signing.php'; // sign in account
    var admin = 'http://localhost:8000/api/login/getAdmin.php'; // sign in admin
    var register = 'http://localhost:8000/api/login/registering.php'; // register user account
    var verify = 'http://localhost:8000/api/mailing/verify.php'; // send verification mail to account
    var verified = 'http://localhost:8000/api/login/verify.php'; // set user as verified account
    var checkVer = 'http://localhost:8000/api/login/checkVerify.php'; // check if account is verified
    var newPass = 'http://localhost:8000/api/login/resetpass.php'; // generate new password
    var sendPass = 'http://localhost:8000/api/mailing/sendpassword.php'; // send new password to email
    var validateAccount = 'http://localhost:8000/api/login/verifyUser.php'; // user exists

    obj.getLoggin = function(user,pass) {
        return $http.get(login + '?id='+ user + '&pass=' + pass);
    }
    obj.getAdmin = function(user,pass) {
        return $http.get(admin + '?id='+ user + '&pass=' + pass);
    }
    obj.registerUser= function (data) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        return $http.post(register,data)
    }
    obj.sendVerification= function (data) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        return $http.post(verify,data)
    }
    obj.getVerified = function(code,mail) {
        return $http.get(verified + '?ver='+ code + "&mail="+mail);
    }
    obj.checkVerified = function(mail) {
        return $http.get(checkVer + '?mail='+ mail);
    }
    obj.resetPassword = function(mail) {
        return $http.get(newPass + '?mail='+ mail);
    }
    obj.sendPassword= function (data) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        return $http.post(sendPass,data)
    }
    obj.verifyUser = function(mail) {
        return $http.get(validateAccount + '?mail='+ mail);
    }

    return obj;
});