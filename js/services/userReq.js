app.factory('userservice', function ($http) {

    var obj = {};

    var update = 'http://localhost:8000/api/user/updatePersonal.php'; // update user account
    var fresh = 'http://localhost:8000/api/user/refreshData.php'; // get fresh user data
    var createPDF = 'http://localhost:8000/api/user/createPDF.php'; // create new record
    var newRecord = 'http://localhost:8000/api/consultation/createCons.php'; // create new record
    var readConsultations = 'http://localhost:8000/api/consultation/readUserCons.php'; // read all consultations

    obj.updateUser= function (data) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        return $http.post(update,data)
    }
    obj.getLoggin = function(user,pass) {
        return $http.get(fresh + '?id='+ user + '&pass=' + pass);
    }
    obj.newTask= function (data) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        return $http.post(createPDF,data)
    }
    obj.getNewRecord = function(id) {
        return $http.get(newRecord + '?id='+ id);
    }
    obj.getAllCons = function(id) {
        return $http.get(readConsultations + '?id='+ id);
    }

    return obj;
});