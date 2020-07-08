app.controller("userCtrl",function($scope,$uibModal,userservice,webservice){

    var mail = localStorage.getItem("userMail");
    var pass = localStorage.getItem("userPass");
    webservice.getLoggin(mail,pass).then(function(response){
        var resp = response.data;
        $scope.userData = resp;
        $scope.getCons($scope.userData.id);
        localStorage.setItem('userJSON', JSON.stringify(resp));
    });

    $scope.templateModal = function(val) {
        localStorage.setItem('modalType',val);
        $uibModal.open({
            templateUrl: '/pages/addEditContact.html',
            controller: 'customDialogCtrl',
            size: 'md',
        }).result.catch(function (resp) {
            if (['cancel', 'backdrop click', 'escape key press'].indexOf(resp) === -1);
        });
    }

    $scope.newRecord = function(id) {
        userservice.getNewRecord(id).then(function(response){
            console.log(response);
        });
    }

    $scope.newTask = function(consid) {
        localStorage.setItem('consid',consid);
        $uibModal.open({
            templateUrl: 'pages/defaultInfo.html',
            controller: 'customDialogCtrl',
            size: 'md',
        }).result.catch(function (resp) {
            if (['cancel', 'backdrop click', 'escape key press'].indexOf(resp) === -1);
        });
    }

    $scope.getCons = function(id) {
        userservice.getAllCons(id).then(function(response){
            $scope.userCons = response.data.contacts[0]["CONSULTATIONS"].consultations;
            console.log($scope.userCons);
        });
    }

})